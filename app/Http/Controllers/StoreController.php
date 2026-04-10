<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CreditCycle;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::with([
            'products' => fn ($query) => $query->with('brand')->latest(),
        ])->whereHas('products')->orderBy('name')->get();

        $brands = Brand::withCount('products')
            ->whereHas('products')
            ->orderBy('name')
            ->get();

        $brandCollections = Brand::with([
            'products' => fn ($query) => $query->with('category')->latest()->take(8),
        ])->whereHas('products')->orderBy('name')->get();

        $newArrivals = Product::with(['category', 'brand'])
            ->where('is_new_arrival', true)
            ->latest()
            ->take(8)
            ->get();

        if ($newArrivals->isEmpty()) {
            $newArrivals = Product::with(['category', 'brand'])->latest()->take(8)->get();
        }

        return view('welcome', compact('categories', 'brands', 'brandCollections', 'newArrivals'));
    }

    public function search(Request $request)
    {
        $products = Product::with(['category', 'brand'])
            ->where('name', 'like', '%' . $request->q . '%')
            ->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->orWhereHas('brand', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->get();

        return response()->json($products);
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        $id = $product->id;
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->retail_price,
                "wholesale" => $product->wholesale_price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'เพิ่มลงตะกร้าแล้ว!');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('store.cart', compact('cart'));
    }

    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        return back()->with('success', 'ลบสินค้าออกจากตะกร้า');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
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

        return view('store.checkout', compact('cart', 'credit'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home');
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $price = $item['quantity'] >= 5 ? $item['wholesale'] : $item['price'];
            $totalAmount += $price * $item['quantity'];
        }

        $type = $request->payment_type ?? 'money_transfer';
        $status = 'pending';

        if ($request->hasFile('slip_image')) {
            $slipPath = $request->file('slip_image')->store('slips', 'public');
            $status = 'paid_wait_shipping';
        } else {
            $slipPath = null;
        }

        if ($type == 'credit') {
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
            'slip_image' => $slipPath
        ]);

        foreach ($cart as $item) {
            $price = $item['quantity'] >= 5 ? $item['wholesale'] : $item['price'];
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price_per_unit' => $price,
                'total' => $price * $item['quantity']
            ]);
        }

        session()->forget('cart');
        return redirect()->route('dashboard')->with('success', 'สั่งซื้อสำเร็จ ขอบคุณที่ใช้บริการครับ!');
    }
}
