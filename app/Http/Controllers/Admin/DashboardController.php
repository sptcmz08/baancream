<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditCycle;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingOrders = Order::where('status', 'pending')->count();
        $monthlyCreditUsage = CreditCycle::where('month', now()->month)
            ->where('year', now()->year)
            ->sum('spent_amount');
        $productCount = Product::count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('pendingOrders', 'monthlyCreditUsage', 'productCount', 'recentOrders'));
    }
}
