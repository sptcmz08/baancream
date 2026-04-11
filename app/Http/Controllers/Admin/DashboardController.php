<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditCycle;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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
        $userCount = User::count();
        $totalRevenue = Order::whereIn('status', ['paid_wait_shipping', 'shipped', 'completed'])->sum('total_amount');

        return view('admin.dashboard', compact(
            'pendingOrders',
            'monthlyCreditUsage',
            'productCount',
            'recentOrders',
            'userCount',
            'totalRevenue'
        ));
    }
}
