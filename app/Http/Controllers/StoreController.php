<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CreditCycle;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $catalogProducts = Product::query()
            ->select([
                'id',
                'sku',
                'name',
                'description',
                'retail_price',
                'wholesale_price',
                'stock',
                'wholesale_min_qty',
                'image',
                'images',
                'is_new_arrival',
                'created_at',
            ])
            ->with([
                'categories:id,name,slug',
                'variants:id,product_id,name,description,image,images,retail_price,wholesale_price,wholesale_min_qty,stock,sort_order',
            ])
            ->latest()
            ->get();

        $newArrivals = $catalogProducts
            ->where('is_new_arrival', true)
            ->take(8)
            ->values();

        if ($newArrivals->isEmpty()) {
            $newArrivals = $catalogProducts->take(8)->values();
        }

        $featuredProducts = $catalogProducts->take(12)->values();

        $cartSummary = $this->cartWithTotals();
        $cartCount = $cartSummary['count'];

        return view('welcome', compact(
            'categories',
            'newArrivals',
            'featuredProducts',
            'catalogProducts',
            'cartCount',
            'cartSummary'
        ));
    }

    public function show(Product $product): View
    {
        $product->load(['categories', 'variants']);

        $selectedVariant = null;
        
        $categoryIds = $product->categories->pluck('id')->toArray();

        $relatedProducts = Product::with(['categories', 'variants'])
            ->whereKeyNot($product->id)
            ->when(!empty($categoryIds), function ($query) use ($categoryIds) {
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            })
            ->latest()
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::with(['categories', 'variants'])
                ->whereKeyNot($product->id)
                ->latest()
                ->take(4)
                ->get();
        }

        $cartSummary = $this->cartWithTotals();
        $cartCount = $cartSummary['count'];

        return view('store.product', compact('product', 'selectedVariant', 'relatedProducts', 'cartCount', 'cartSummary'));
    }

    public function search(Request $request): JsonResponse
    {
        $products = Product::with(['categories', 'variants'])
            ->where('name', 'like', '%' . $request->q . '%')
            ->orWhereHas('categories', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->orWhereHas('variants', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->get();

        return response()->json($products);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::with('variants')->findOrFail($request->integer('product_id'));
        $quantity = max(1, $request->integer('quantity', 1));
        $variant = $this->resolveVariant($product, $request->integer('variant_id'));
        $cart = session()->get('cart', []);
        $cartKey = $this->cartKey($product->id, $variant?->id);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = $this->makeCartItem($product, $variant, $quantity);
        }

        $cart[$cartKey]['retail_subtotal'] = $cart[$cartKey]['retail_price'] * $cart[$cartKey]['quantity'];
        $cart[$cartKey]['wholesale_subtotal'] = $cart[$cartKey]['wholesale_bundle_price'];

        session()->put('cart', $cart);

        return back()->with('success', 'เพิ่มลงตะกร้าแล้ว!');
    }

    public function cart(): View
    {
        $cart = $this->cartWithTotals();

        return view('store.cart', [
            'cart' => $cart['items'],
            'cartCount' => $cart['count'],
            'cartTotal' => $cart['total'],
        ]);
    }

    public function removeFromCart(Request $request): RedirectResponse
    {
        if ($request->id) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }

        return back()->with('success', 'ลบสินค้าออกจากตะกร้า');
    }

    public function checkout(): RedirectResponse|View
    {
        $cart = $this->cartWithTotals();
        if (empty($cart['items'])) {
            return redirect()->route('home');
        }

        $user = auth()->user();
        $credit = null;
        if (in_array($user->role, ['customer', 'vip'])) {
            $credit = CreditCycle::where('user_id', $user->id)
                ->where('month', date('n'))
                ->where('year', date('Y'))
                ->first();
        }

        return view('store.checkout', [
            'cart' => $cart['items'],
            'credit' => $credit,
            'cartCount' => $cart['count'],
            'cartTotal' => $cart['total'],
            'customerName' => old('recipient_name', $user->name),
        ]);
    }

    public function processCheckout(Request $request): RedirectResponse
    {
        $cart = $this->cartWithTotals();
        if (empty($cart['items'])) {
            return redirect()->route('home');
        }

        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address_line' => ['required', 'string'],
            'subdistrict' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'order_note' => ['nullable', 'string'],
            'payment_type' => ['required', 'in:promptpay,credit'],
            'slip_image' => ['nullable', 'image'],
        ]);

        $totalAmount = $cart['total'];
        $paymentType = $validated['payment_type'];
        $type = $paymentType === 'credit' ? 'credit' : 'normal';
        $status = 'pending';

        if ($paymentType === 'promptpay' && !$request->hasFile('slip_image')) {
            return back()->withInput()->with('error', 'กรุณาแนบสลิปการโอนผ่าน PromptPay');
        }

        if ($request->hasFile('slip_image')) {
            $slipPath = $request->file('slip_image')->store('slips', 'public');
        } else {
            $slipPath = null;
        }

        if ($paymentType === 'credit') {
            $credit = CreditCycle::where('user_id', auth()->id())
                ->where('month', date('n'))
                ->where('year', date('Y'))
                ->first();
            if ($credit) {
                if ($credit->credit_limit !== null && ($credit->spent_amount + $totalAmount > $credit->credit_limit)) {
                    return back()->withInput()->with('error', 'โควตาเครดิตในเดือนนี้ของคุณไม่เพียงพอ!');
                }
                $credit->increment('spent_amount', $totalAmount);
                $status = 'paid_wait_shipping';
            } else {
                return back()->withInput()->with('error', 'คุณยังไม่ได้รับสิทธิ์เครดิตในเดือนนี้');
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'type' => $type,
            'payment_method' => $paymentType,
            'status' => $status,
            'slip_image' => $slipPath,
            'recipient_name' => $validated['recipient_name'],
            'phone' => $validated['phone'],
            'address_line' => $validated['address_line'],
            'subdistrict' => $validated['subdistrict'],
            'district' => $validated['district'],
            'province' => $validated['province'],
            'postal_code' => $validated['postal_code'],
            'order_note' => $validated['order_note'] ?? null,
        ]);

        foreach ($cart['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['variant_id'],
                'variant_name' => $item['variant_name'],
                'quantity' => $item['quantity'],
                'price_per_unit' => $item['unit_price'],
                'total' => $item['subtotal'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('account.orders')->with('success', 'สั่งซื้อสำเร็จ ขอบคุณที่ใช้บริการครับ!');
    }

    private function resolveVariant(Product $product, ?int $variantId): ?ProductVariant
    {
        if (!$product->hasVariants()) {
            return null;
        }

        if ($variantId) {
            $variant = $product->variants->firstWhere('id', $variantId);
            if ($variant) {
                return $variant;
            }
        }

        return null;
    }

    private function cartKey(int $productId, ?int $variantId): string
    {
        return $variantId ? $productId . ':' . $variantId : (string) $productId;
    }

    private function makeCartItem(Product $product, ?ProductVariant $variant, int $quantity): array
    {
        return [
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
            'id' => $this->cartKey($product->id, $variant?->id),
            'name' => $product->name,
            'variant_name' => $variant?->name,
            'quantity' => $quantity,
            'retail_price' => (float) ($variant?->retail_price ?? $product->retail_price),
            'wholesale_bundle_price' => (float) ($variant?->wholesale_price ?? $product->wholesale_price),
            'wholesale_min_qty' => (int) ($variant?->wholesale_min_qty ?? $product->wholesale_min_qty ?? 1),
            'image' => $variant?->displayImage() ?: $product->displayImage(),
            'stock' => $variant?->stock ?? $product->stock,
        ];
    }

    private function cartWithTotals(): array
    {
        $items = array_values(session()->get('cart', []));
        $count = 0;
        $total = 0;

        foreach ($items as &$item) {
            $minQty = max(1, (int) ($item['wholesale_min_qty'] ?? 1));
            $item['uses_wholesale'] = $item['quantity'] >= $minQty;
            $wholesaleUnitPrice = $minQty > 0
                ? ((float) ($item['wholesale_bundle_price'] ?? 0) / $minQty)
                : (float) ($item['wholesale_bundle_price'] ?? 0);

            $item['unit_price'] = $item['uses_wholesale'] ? $wholesaleUnitPrice : (float) $item['retail_price'];
            $item['subtotal'] = $item['unit_price'] * $item['quantity'];
            $count += $item['quantity'];
            $total += $item['subtotal'];
        }

        unset($item);

        return [
            'items' => $items,
            'count' => $count,
            'total' => $total,
        ];
    }

    private function cartCount(): int
    {
        return array_sum(array_column(session()->get('cart', []), 'quantity'));
    }
}
