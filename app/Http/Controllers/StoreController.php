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
    private const WHOLESALE_MIN_QTY = 10;

    public function index(Request $request): View
    {
        $categories = Category::query()
            ->whereHas('products')
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
                'image',
                'category_id',
                'brand_id',
                'is_new_arrival',
                'created_at',
            ])
            ->with([
                'category:id,name,slug',
                'brand:id,name,slug',
                'variants:id,product_id,name,image,retail_price,wholesale_price,stock,sort_order',
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
        $product->load(['category', 'brand', 'variants']);

        $selectedVariant = $product->defaultVariant();
        $relatedProducts = Product::with(['category', 'brand', 'variants'])
            ->whereKeyNot($product->id)
            ->when($product->category_id, fn ($query) => $query->where('category_id', $product->category_id))
            ->latest()
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::with(['category', 'brand', 'variants'])
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
        $products = Product::with(['category', 'brand', 'variants'])
            ->where('name', 'like', '%' . $request->q . '%')
            ->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->orWhereHas('brand', function ($query) use ($request) {
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
        $cart[$cartKey]['wholesale_subtotal'] = $cart[$cartKey]['wholesale_price'] * $cart[$cartKey]['quantity'];

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
        ]);
    }

    public function processCheckout(Request $request): RedirectResponse
    {
        $cart = $this->cartWithTotals();
        if (empty($cart['items'])) {
            return redirect()->route('home');
        }

        $totalAmount = $cart['total'];
        $type = $request->payment_type ?? 'money_transfer';
        $status = 'pending';

        if ($request->hasFile('slip_image')) {
            $slipPath = $request->file('slip_image')->store('slips', 'public');
            $status = 'paid_wait_shipping';
        } else {
            $slipPath = null;
        }

        if ($type === 'credit') {
            $credit = CreditCycle::where('user_id', auth()->id())
                ->where('month', date('n'))
                ->where('year', date('Y'))
                ->first();
            if ($credit) {
                if ($credit->credit_limit !== null && ($credit->spent_amount + $totalAmount > $credit->credit_limit)) {
                    return back()->with('error', 'โควตาเครดิตในเดือนนี้ของคุณไม่เพียงพอ!');
                }
                $credit->increment('spent_amount', $totalAmount);
                $status = 'paid_wait_shipping';
            } else {
                return back()->with('error', 'คุณยังไม่ได้รับสิทธิ์เครดิตในเดือนนี้');
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'type' => $type,
            'status' => $status,
            'slip_image' => $slipPath,
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

        return redirect()->route('dashboard')->with('success', 'สั่งซื้อสำเร็จ ขอบคุณที่ใช้บริการครับ!');
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

        return $product->defaultVariant();
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
            'wholesale_price' => (float) ($variant?->wholesale_price ?? $product->wholesale_price),
            'image' => $variant?->image ?: $product->image,
            'stock' => $variant?->stock,
        ];
    }

    private function cartWithTotals(): array
    {
        $items = array_values(session()->get('cart', []));
        $count = 0;
        $total = 0;

        foreach ($items as &$item) {
            $item['uses_wholesale'] = $item['quantity'] >= self::WHOLESALE_MIN_QTY;
            $item['unit_price'] = $item['uses_wholesale'] ? $item['wholesale_price'] : $item['retail_price'];
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
