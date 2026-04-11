<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product', 'items.variant'])
            ->latest()
            ->get();

        // Count unread notifications
        $unreadCount = Order::where('user_id', $user->id)
            ->where('user_read_status', false)
            ->count();

        return view('store.account.index', compact('user', 'orders', 'unreadCount'));
    }

    public function orders()
    {
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        $unreadCount = Order::where('user_id', $user->id)
            ->where('user_read_status', false)
            ->count();

        return view('store.account.orders', compact('user', 'orders', 'unreadCount'));
    }

    public function orderDetail(Order $order)
    {
        // Make sure the order belongs to the logged-in user
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load(['items.product', 'items.variant']);

        // Mark as read when customer views the order detail
        $order->markAsRead();

        return view('store.account.order-detail', compact('order'));
    }

    public function notifications()
    {
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(20)
            ->get();

        return response()->json([
            'unread' => $orders->where('user_read_status', false)->count(),
            'items'  => $orders->map(fn($o) => [
                'id'         => $o->id,
                'status'     => $o->status,
                'label'      => $this->statusLabel($o->status),
                'color'      => $this->statusColor($o->status),
                'total'      => number_format($o->total_amount, 2),
                'is_read'    => $o->user_read_status,
                'created_at' => $o->created_at->diffForHumans(),
                'url'        => route('account.order', $o->id),
            ]),
        ]);
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'pending'    => 'รอชำระเงิน',
            'confirmed'  => 'ยืนยันแล้ว',
            'paid_wait_shipping' => 'เตรียมจัดส่ง',
            'processing' => 'กำลังดำเนินการ',
            'shipped'    => 'จัดส่งแล้ว',
            'completed'  => 'สำเร็จ',
            'cancelled'  => 'ยกเลิก',
            default      => $status,
        };
    }

    private function statusColor(string $status): string
    {
        return match ($status) {
            'pending'    => '#f59e0b',
            'confirmed'  => '#06b6d4',
            'paid_wait_shipping' => '#3b82f6',
            'processing' => '#3b82f6',
            'shipped'    => '#8b5cf6',
            'completed'  => '#10b981',
            'cancelled'  => '#ef4444',
            default      => '#6b7280',
        };
    }
}
