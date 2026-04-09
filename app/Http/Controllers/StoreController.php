<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $products = \App\Models\Product::with('category')->get();
        return view('welcome', compact('products'));
    }

    public function search(Request $request)
    {
        $products = \App\Models\Product::where('name', 'like', '%'.$request->q.'%')->get();
        return response()->json($products);
    }

    public function addToCart(Request $request)
    {
        $product = \App\Models\Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        $id = $product->id;
        if(isset($cart[$id])) {
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
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        return back()->with('success', 'ลบสินค้าออกจากตะกร้า');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) return redirect()->route('home');
        
        $user = auth()->user();
        $credit = null;
        if(in_array($user->role, ['customer', 'vip'])) {
            $credit = \App\Models\CreditCycle::where('user_id', $user->id)
                        ->where('month', date('n'))
                        ->where('year', date('Y'))
                        ->first();
        }

        return view('store.checkout', compact('cart', 'credit'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) return redirect()->route('home');

        $totalAmount = 0;
        foreach($cart as $item) {
            $price = $item['quantity'] >= 5 ? $item['wholesale'] : $item['price'];
            $totalAmount += $price * $item['quantity'];
        }

        $type = $request->payment_type ?? 'money_transfer';
        $status = 'pending';

        if($request->hasFile('slip_image')) {
            $slipPath = $request->file('slip_image')->store('slips', 'public');
            $status = 'paid_wait_shipping';
        } else {
            $slipPath = null;
        }

        if($type == 'credit') {
            $credit = \App\Models\CreditCycle::where('user_id', auth()->id())
                        ->where('month', date('n'))->where('year', date('Y'))->first();
            if($credit) {
                if($credit->credit_limit !== null && ($credit->spent_amount + $totalAmount > $credit->credit_limit)) {
                    return back()->with('error', 'โควตาเครดิตในเดือนนี้ของคุณไม่เพียงพอ!');
                }
                $credit->increment('spent_amount', $totalAmount);
                $status = 'paid_wait_shipping';
            } else {
                return back()->with('error', 'คุณยังไม่ได้รับสิทธิ์เครดิตในเดือนนี้');
            }
        }

        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'type' => $type,
            'status' => $status,
            'slip_image' => $slipPath
        ]);

        foreach($cart as $item) {
            $price = $item['quantity'] >= 5 ? $item['wholesale'] : $item['price'];
            \App\Models\OrderItem::create([
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
