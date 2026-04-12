<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Support\MediaPath;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with(['categories', 'variants'])->latest()->get();

            $html = view('admin.products.index', compact('products'))->render();
            return $html;
        } catch (\Throwable $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->prepareProductInput($request);

        try {
            $validated = $this->validateProduct($request);
            $data = $this->extractProductData($request, $validated);

            DB::transaction(function () use ($request, $data): void {
                $product = Product::create($data);
                $product->categories()->sync($request->input('category_ids', []));
                $this->syncVariants($request, $product);
            });
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Throwable $e) {
            Log::error('Admin product create failed', [
                'message' => $e->getMessage(),
                'sku' => $request->input('sku'),
            ]);

            return back()->withInput()->with('error', 'บันทึกสินค้าไม่สำเร็จ: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')->with('success', 'เพิ่มสินค้าสำเร็จ');
    }

    public function show(Product $product): RedirectResponse
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product): View
    {
        $product->load(['variants', 'categories']);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->prepareProductInput($request);

        try {
            $validated = $this->validateProduct($request, $product);
            $data = $this->extractProductData($request, $validated, $product);

            DB::transaction(function () use ($request, $product, $data): void {
                $product->update($data);
                $product->categories()->sync($request->input('category_ids', []));
                $this->syncVariants($request, $product);
            });
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Throwable $e) {
            Log::error('Admin product update failed', [
                'message' => $e->getMessage(),
                'product_id' => $product->id,
                'sku' => $request->input('sku'),
            ]);

            return back()->withInput()->with('error', 'บันทึกสินค้าไม่สำเร็จ: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')->with('success', 'อัปเดตสินค้าสำเร็จ');
    }

    public function copy(Product $product): RedirectResponse
    {
        $product->load(['categories', 'variants']);

        try {
            $newProduct = DB::transaction(function () use ($product): Product {
                $copy = $product->replicate();
                $copy->sku = $this->duplicateSku($product->sku);
                $copy->name = mb_substr($product->name, 0, 248) . ' (Copy)';
                $copy->save();

                $copy->categories()->sync($product->categories->pluck('id')->all());

                foreach ($product->variants as $variant) {
                    $variantCopy = $variant->replicate();
                    $variantCopy->product_id = $copy->id;
                    $variantCopy->save();
                }

                return $copy;
            });
        } catch (\Throwable $e) {
            Log::error('Admin product copy failed', [
                'message' => $e->getMessage(),
                'product_id' => $product->id,
                'sku' => $product->sku,
            ]);

            return back()->with('error', 'คัดลอกสินค้าไม่สำเร็จ: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.products.edit', $newProduct)
            ->with('success', "คัดลอกสินค้า {$product->sku} สำเร็จ กรุณาตรวจสอบ SKU ใหม่ก่อนเผยแพร่");
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ((array) $product->images as $image) {
            Storage::disk('public')->delete($image);
        }

        $product->variants->each(function (ProductVariant $variant): void {
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
        });

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'ลบสินค้าสำเร็จ');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'sku' => 'required|string|max:255|unique:products,sku,' . $product?->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'wholesale_min_qty' => 'nullable|integer|min:1',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image',
            'kept_images' => 'nullable|array',
            'kept_images.*' => 'string',
            'is_new_arrival' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.name' => 'required_with:variants.*.retail_price,variants.*.wholesale_price|string|max:255',
            'variants.*.description' => 'nullable|string',
            'variants.*.retail_price' => 'nullable|numeric|min:0',
            'variants.*.wholesale_price' => 'nullable|numeric|min:0',
            'variants.*.wholesale_min_qty' => 'nullable|integer|min:1',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.images' => 'nullable|array',
            'variants.*.images.*' => 'nullable|image',
            'variants.*.kept_images' => 'nullable|array',
            'variants.*.kept_images.*' => 'string',
        ], [
            'sku.unique' => 'SKU นี้มีอยู่ในระบบแล้ว',
            'category_ids.required' => 'กรุณาเลือกหมวดหมู่อย่างน้อย 1 หมวด',
            'category_ids.min' => 'กรุณาเลือกหมวดหมู่อย่างน้อย 1 หมวด',
            'images.*.image' => 'ไฟล์รูปสินค้าต้องเป็นรูปภาพเท่านั้น',
            'variants.*.images.*.image' => 'ไฟล์รูปสูตรสินค้าต้องเป็นรูปภาพเท่านั้น',
            'variants.*.name.required_with' => 'กรุณากรอกชื่อสูตรเมื่อระบุราคาสูตร',
        ], [
            'sku' => 'SKU รหัสสินค้า',
            'name' => 'ชื่อสินค้า',
            'retail_price' => 'ราคาปลีกหลัก',
            'wholesale_price' => 'ราคารวมราคาส่งหลัก',
            'wholesale_min_qty' => 'จำนวนขั้นต่ำราคาส่งหลัก',
            'stock' => 'สต็อกสินค้าหลัก',
            'category_ids' => 'หมวดหมู่',
            'variants.*.name' => 'ชื่อสูตรสินค้า',
            'variants.*.retail_price' => 'ราคาปลีกสูตร',
            'variants.*.wholesale_price' => 'ราคารวมราคาส่งสูตร',
            'variants.*.wholesale_min_qty' => 'จำนวนขั้นต่ำราคาส่งสูตร',
            'variants.*.stock' => 'สต็อกสูตร',
        ]);
    }

    private function duplicateSku(string $sku): string
    {
        $base = mb_substr($sku . '-COPY', 0, 245);
        $candidate = $base;
        $counter = 2;

        while (Product::withTrashed()->where('sku', $candidate)->exists()) {
            $suffix = '-' . $counter++;
            $candidate = mb_substr($base, 0, 255 - mb_strlen($suffix)) . $suffix;
        }

        return $candidate;
    }

    private function prepareProductInput(Request $request): void
    {
        $variants = [];
        $variantFiles = $request->file('variants', []);

        foreach ($request->input('variants', []) as $index => $variantInput) {
            $variantImages = $variantFiles[$index]['images'] ?? [];
            $hasVariantImage = !empty(array_filter((array) $variantImages));
            $hasContent = trim((string) ($variantInput['id'] ?? '')) !== ''
                || trim((string) ($variantInput['name'] ?? '')) !== ''
                || trim((string) ($variantInput['description'] ?? '')) !== ''
                || trim((string) ($variantInput['retail_price'] ?? '')) !== ''
                || trim((string) ($variantInput['wholesale_price'] ?? '')) !== ''
                || trim((string) ($variantInput['stock'] ?? '')) !== ''
                || !empty($variantInput['kept_images'] ?? [])
                || $hasVariantImage;

            if ($hasContent) {
                $variants[$index] = $variantInput;
            }
        }

        $request->merge(['variants' => $variants]);
    }

    private function validationErrorResponse(ValidationException $e): RedirectResponse
    {
        return back()
            ->withErrors($e->validator)
            ->withInput()
            ->with('error', 'บันทึกสินค้าไม่สำเร็จ กรุณาตรวจสอบข้อมูลที่กรอก');
    }

    private function extractProductData(Request $request, array $validated, ?Product $product = null): array
    {
        $data = collect($validated)
            ->except(['images', 'kept_images', 'variants', 'category_ids'])
            ->toArray();

        $data['is_new_arrival'] = $request->boolean('is_new_arrival');
        $data['stock'] = $request->integer('stock', 0);
        $data['wholesale_min_qty'] = $request->integer('wholesale_min_qty', 10);

        $images = collect($request->input('kept_images', []))
            ->map(fn ($path) => MediaPath::normalize($path))
            ->filter(fn ($path) => is_string($path) && $path !== '')
            ->values()
            ->all();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('products', 'public');
            }
        }

        foreach (array_diff((array) $product?->images, $images) as $removedImage) {
            Storage::disk('public')->delete($removedImage);
        }

        $data['image'] = $images[0] ?? null;
        $data['images'] = $images;

        return $data;
    }

    private function syncVariants(Request $request, Product $product): void
    {
        $submittedVariants = $request->input('variants', []);
        $variantFiles = $request->file('variants', []);
        $keptVariantIds = [];

        foreach ($submittedVariants as $index => $variantInput) {
            $name = trim((string) ($variantInput['name'] ?? ''));
            $retailPrice = $variantInput['retail_price'] ?? null;
            $wholesalePrice = $variantInput['wholesale_price'] ?? null;

            if ($name === '' && ($retailPrice === null || $retailPrice === '') && ($wholesalePrice === null || $wholesalePrice === '')) {
                continue;
            }

            $variant = $product->variants()->find($variantInput['id'] ?? null) ?? new ProductVariant();
            $existingImages = collect($variant->galleryImages());
            $variantImages = collect($variantInput['kept_images'] ?? [])
                ->map(fn ($path) => MediaPath::normalize($path))
                ->filter(fn ($path) => is_string($path) && $path !== '')
                ->values()
                ->all();

            $variant->product_id = $product->id;
            $variant->name = $name;
            $variant->description = $variantInput['description'] ?? null;
            $variant->retail_price = $retailPrice ?: 0;
            $variant->wholesale_price = $wholesalePrice ?: 0;
            $variant->wholesale_min_qty = max(1, (int) ($variantInput['wholesale_min_qty'] ?? $request->integer('wholesale_min_qty', 10)));
            $variant->stock = (int) ($variantInput['stock'] ?? 0);
            $variant->sort_order = $index;

            $imageFiles = $variantFiles[$index]['images'] ?? [];
            foreach ((array) $imageFiles as $imageFile) {
                if ($imageFile) {
                    $variantImages[] = $imageFile->store('products/variants', 'public');
                }
            }

            foreach ($existingImages->diff($variantImages) as $removedImage) {
                Storage::disk('public')->delete($removedImage);
            }

            $variant->images = array_values(array_unique(array_filter($variantImages)));
            $variant->image = $variant->images[0] ?? null;
            $variant->save();
            $keptVariantIds[] = $variant->id;
        }

        $product->variants()
            ->whereNotIn('id', $keptVariantIds)
            ->get()
            ->each(function (ProductVariant $variant): void {
                if ($variant->image) {
                    Storage::disk('public')->delete($variant->image);
                }

                $variant->delete();
            });
    }
}
