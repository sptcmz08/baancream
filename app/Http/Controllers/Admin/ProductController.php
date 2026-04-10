<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['category', 'brand', 'variants'])->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        $data = $this->extractProductData($request, $validated);

        $product = Product::create($data);
        $this->syncVariants($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'เพิ่มสินค้าสำเร็จ');
    }

    public function edit(Product $product): View
    {
        $product->load('variants');
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);
        $data = $this->extractProductData($request, $validated, $product);

        $product->update($data);
        $this->syncVariants($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'อัปเดตสินค้าสำเร็จ');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
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
            'image' => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_new_arrival' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.name' => 'required_with:variants.*.retail_price,variants.*.wholesale_price|string|max:255',
            'variants.*.sku' => 'nullable|string|max:255',
            'variants.*.retail_price' => 'nullable|numeric|min:0',
            'variants.*.wholesale_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.image' => 'nullable|image',
        ]);
    }

    private function extractProductData(Request $request, array $validated, ?Product $product = null): array
    {
        $data = collect($validated)
            ->except(['image', 'variants'])
            ->toArray();

        $data['is_new_arrival'] = $request->boolean('is_new_arrival');

        if ($request->hasFile('image')) {
            if ($product?->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

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
            $variant->sku = $variantInput['sku'] ?? null;
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
