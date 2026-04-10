<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['categories', 'variants'])->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        $data = $this->extractProductData($request, $validated);

        $product = Product::create($data);
        $product->categories()->sync($request->input('category_ids', []));
        $this->syncVariants($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'เพิ่มสินค้าสำเร็จ');
    }

    public function edit(Product $product): View
    {
        $product->load(['variants', 'categories']);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);
        $data = $this->extractProductData($request, $validated, $product);

        $product->update($data);
        $product->categories()->sync($request->input('category_ids', []));
        $this->syncVariants($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'อัปเดตสินค้าสำเร็จ');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if (is_array($product->images)) {
            foreach($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $product->variants->each(function (ProductVariant $variant) {
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
            'sku' => 'required|unique:products,sku,' . $product?->id,
            'name' => 'required|string',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'wholesale_min_qty' => 'nullable|integer|min:1',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'images.*' => 'nullable|image',
            'kept_images' => 'nullable|array',
            'is_new_arrival' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.name' => 'required_with:variants.*.retail_price,variants.*.wholesale_price|string|max:255',
            'variants.*.description' => 'nullable|string',
            'variants.*.retail_price' => 'nullable|numeric|min:0',
            'variants.*.wholesale_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.image' => 'nullable|image',
        ]);
    }

    private function extractProductData(Request $request, array $validated, ?Product $product = null): array
    {
        $data = collect($validated)
            ->except(['images', 'kept_images', 'variants', 'category_ids'])
            ->toArray();

        $data['is_new_arrival'] = $request->boolean('is_new_arrival');
        $data['stock'] = $request->integer('stock', 0);
        $data['wholesale_min_qty'] = $request->integer('wholesale_min_qty', 10);

        $images = $request->input('kept_images', []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('products', 'public');
            }
        }

        if ($product && is_array($product->images)) {
            $removed = array_diff($product->images, $images);
            foreach ($removed as $img) {
                Storage::disk('public')->delete($img);
            }
        }

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

            if ($name === '' && $retailPrice === null && $wholesalePrice === null) {
                continue;
            }

            $variant = $product->variants()->find($variantInput['id'] ?? null) ?? new ProductVariant();
            $variant->product_id = $product->id;
            $variant->name = $name;
            $variant->description = $variantInput['description'] ?? null;
            $variant->retail_price = $retailPrice ?: 0;
            $variant->wholesale_price = $wholesalePrice ?: 0;
            $variant->stock = (int) ($variantInput['stock'] ?? 0);
            $variant->sort_order = $index;

            $imageFile = $variantFiles[$index]['image'] ?? null;
            if ($imageFile) {
                if ($variant->exists && $variant->image) {
                    Storage::disk('public')->delete($variant->image);
                }
                $variant->image = $imageFile->store('products/variants', 'public');
            }

            $variant->save();
            $keptVariantIds[] = $variant->id;
        }

        $product->variants()
            ->whereNotIn('id', $keptVariantIds)
            ->get()
            ->each(function (ProductVariant $variant) {
                if ($variant->image) {
                    Storage::disk('public')->delete($variant->image);
                }
                $variant->delete();
            });
    }
}
