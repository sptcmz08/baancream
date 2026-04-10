<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_renders_with_variants_and_related_products(): void
    {
        $category = Category::create([
            'name' => 'สกินแคร์',
            'slug' => 'skincare',
        ]);

        $product = Product::create([
            'sku' => 'P-001',
            'name' => 'ครีมหน้าใส',
            'description' => 'รายละเอียดสินค้า',
            'retail_price' => 590,
            'wholesale_price' => 350,
            'stock' => 20,
            'wholesale_min_qty' => 10,
        ]);
        $product->categories()->sync([$category->id]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'สูตรกลางวัน',
            'sku' => 'P-001-DAY',
            'retail_price' => 590,
            'wholesale_price' => 3500,
            'wholesale_min_qty' => 10,
            'stock' => 12,
            'sort_order' => 1,
        ]);

        $relatedProduct = Product::create([
            'sku' => 'P-002',
            'name' => 'เซรั่มบำรุงผิว',
            'description' => 'สินค้าแนะนำ',
            'retail_price' => 790,
            'wholesale_price' => 5200,
            'stock' => 10,
            'wholesale_min_qty' => 10,
        ]);
        $relatedProduct->categories()->sync([$category->id]);

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee('ครีมหน้าใส');
        $response->assertSee('สูตรกลางวัน');
        $response->assertSee('สินค้าที่คุณอาจชอบ');
    }

    public function test_product_page_renders_without_optional_relations(): void
    {
        $product = Product::create([
            'sku' => 'P-003',
            'name' => 'สินค้าทดสอบ',
            'description' => null,
            'retail_price' => 199,
            'wholesale_price' => 1500,
            'stock' => 3,
            'wholesale_min_qty' => 10,
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee('สินค้าทดสอบ');
        $response->assertSee('ใส่ตะกร้า 1 ชิ้น');
    }
}
