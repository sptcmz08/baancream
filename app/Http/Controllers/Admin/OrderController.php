<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = \App\Models\Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show(\App\Models\Order $order)
    {
        // Load items later
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, \App\Models\Order $order)
    {
        $request->validate(['status' => 'required']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'เปลี่ยนสถานะออเดอร์สำเร็จ');
    }

    public function destroy(\App\Models\Order $order)
    {
        $order->delete();
        return back()->with('success', 'ลบออเดอร์สำเร็จ');
    }
}
