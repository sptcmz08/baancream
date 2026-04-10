<?php

namespace Tests\Feature;

use App\Models\CreditCycle;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    private function fakePngSlip(): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'slip');
        file_put_contents($path, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9sot8X8AAAAASUVORK5CYII='));

        return new UploadedFile($path, 'slip.png', 'image/png', null, true);
    }

    public function test_promptpay_checkout_stores_shipping_details_and_slip(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $product = Product::create([
            'sku' => 'SKU-001',
            'name' => 'ครีมหน้าใสพรีเมียม',
            'retail_price' => 590,
            'wholesale_price' => 5000,
            'wholesale_min_qty' => 10,
            'stock' => 30,
        ]);

        $cartItem = [
            'id' => (string) $product->id,
            'product_id' => $product->id,
            'variant_id' => null,
            'name' => $product->name,
            'variant_name' => null,
            'quantity' => 1,
            'retail_price' => 590.0,
            'wholesale_bundle_price' => 5000.0,
            'wholesale_min_qty' => 10,
            'image' => null,
            'stock' => 30,
        ];

        $response = $this->actingAs($user)
            ->withSession(['cart' => [$cartItem['id'] => $cartItem]])
            ->post(route('checkout.process'), [
                'recipient_name' => 'ลูกค้า ทดสอบ',
                'phone' => '0812345678',
                'address_line' => '123 หมู่ 5 ถนนทดสอบ',
                'subdistrict' => 'บางมัญ',
                'district' => 'เมือง',
                'province' => 'สิงห์บุรี',
                'postal_code' => '16000',
                'order_note' => 'ส่งช่วงบ่าย',
                'payment_type' => 'promptpay',
                'slip_image' => $this->fakePngSlip(),
            ]);

        $response->assertRedirect(route('account.orders', absolute: false));

        $order = Order::first();

        $this->assertNotNull($order);
        $this->assertSame('normal', $order->type);
        $this->assertSame('promptpay', $order->payment_method);
        $this->assertSame('pending', $order->status);
        $this->assertSame('ลูกค้า ทดสอบ', $order->recipient_name);
        $this->assertSame('0812345678', $order->phone);
        $this->assertSame('123 หมู่ 5 ถนนทดสอบ', $order->address_line);
        $this->assertSame('บางมัญ', $order->subdistrict);
        $this->assertSame('เมือง', $order->district);
        $this->assertSame('สิงห์บุรี', $order->province);
        $this->assertSame('16000', $order->postal_code);
        $this->assertSame('ส่งช่วงบ่าย', $order->order_note);
        $this->assertNotNull($order->slip_image);
        Storage::disk('public')->assertExists($order->slip_image);
        $this->assertDatabaseCount('order_items', 1);
    }

    public function test_credit_checkout_updates_credit_cycle_and_marks_order_ready_for_shipping(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $product = Product::create([
            'sku' => 'SKU-002',
            'name' => 'เซรั่มกลางคืน',
            'retail_price' => 850,
            'wholesale_price' => 7000,
            'wholesale_min_qty' => 10,
            'stock' => 30,
        ]);

        CreditCycle::create([
            'user_id' => $user->id,
            'month' => (int) date('n'),
            'year' => (int) date('Y'),
            'credit_limit' => 10000,
            'spent_amount' => 1000,
            'status' => 'pending',
        ]);

        $cartItem = [
            'id' => (string) $product->id,
            'product_id' => $product->id,
            'variant_id' => null,
            'name' => $product->name,
            'variant_name' => null,
            'quantity' => 2,
            'retail_price' => 850.0,
            'wholesale_bundle_price' => 7000.0,
            'wholesale_min_qty' => 10,
            'image' => null,
            'stock' => 30,
        ];

        $response = $this->actingAs($user)
            ->withSession(['cart' => [$cartItem['id'] => $cartItem]])
            ->post(route('checkout.process'), [
                'recipient_name' => 'ลูกค้า เครดิต',
                'phone' => '0899999999',
                'address_line' => '99/9 ซอยเครดิต',
                'subdistrict' => 'ต้นโพธิ์',
                'district' => 'เมือง',
                'province' => 'สิงห์บุรี',
                'postal_code' => '16000',
                'payment_type' => 'credit',
            ]);

        $response->assertRedirect(route('account.orders', absolute: false));

        $order = Order::first();

        $this->assertNotNull($order);
        $this->assertSame('credit', $order->type);
        $this->assertSame('credit', $order->payment_method);
        $this->assertSame('paid_wait_shipping', $order->status);
        $this->assertSame(2700.0, (float) CreditCycle::first()->fresh()->spent_amount);
    }
}
