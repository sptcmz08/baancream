<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CreditCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product', 'items.variant'])
            ->latest()
            ->get();
        $creditCycles = CreditCycle::where('user_id', $user->id)
            ->with(['orders.items.product', 'orders.items.variant'])
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->get();

        // Count unread notifications
        $unreadCount = Order::where('user_id', $user->id)
            ->where('user_read_status', false)
            ->count();

        return view('store.account.index', [
            'user'         => $user->load('addresses'),
            'orders'       => $orders,
            'creditCycles' => $creditCycles,
            'unreadCount'  => $unreadCount
        ]);
    }

    public function orders()
    {
        return redirect()->to(route('account.index') . '#orders');
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

    public function uploadCreditSlip(Request $request, CreditCycle $credit)
    {
        abort_unless($credit->user_id === Auth::id(), 403);
        abort_if($credit->status === 'paid', 422);

        $validated = $request->validate([
            'payment_slip' => ['required', 'image', 'max:4096'],
            'payment_note' => ['nullable', 'string'],
        ]);

        if ($credit->payment_slip) {
            Storage::disk('public')->delete($credit->payment_slip);
        }

        $credit->update([
            'payment_slip' => $request->file('payment_slip')->store('credit-slips', 'public'),
            'payment_note' => $validated['payment_note'] ?? null,
            'payment_submitted_at' => now(),
        ]);

        return back()->with('success', 'ส่งสลิปชำระเครดิตแล้ว รอแอดมินตรวจสอบยอดเงิน');
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
