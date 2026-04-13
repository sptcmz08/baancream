<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditCycle;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display orders with payment-method tab filtering.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all');

        $query = Order::with('user')->latest();

        if ($tab === 'transfer') {
            $query->where('payment_method', 'promptpay')->where('type', '!=', 'credit');
        } elseif ($tab === 'cod') {
            $query->where('payment_method', 'cod');
        } elseif ($tab === 'pickup') {
            $query->where('payment_method', 'pickup');
        } elseif ($tab === 'credit') {
            $query->where(function ($q) {
                $q->where('payment_method', 'credit')->orWhere('type', 'credit');
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        // Tab counts
        $counts = [
            'all' => Order::count(),
            'transfer' => Order::where('payment_method', 'promptpay')->where('type', '!=', 'credit')->count(),
            'cod' => Order::where('payment_method', 'cod')->count(),
            'pickup' => Order::where('payment_method', 'pickup')->count(),
            'credit' => Order::where(function ($q) {
                $q->where('payment_method', 'credit')->orWhere('type', 'credit');
            })->count(),
        ];

        return view('admin.orders.index', compact('orders', 'tab', 'counts'));
    }

    /**
     * Order detail with all management actions.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'items.variant']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status, tracking, shipping cost, or notes.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'nullable|string',
            'tracking_number' => 'nullable|string|max:255',
            'shipping_cost' => 'nullable|numeric|min:0',
            'customer_notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $order, $validated): void {
            // If status changes, reset read status so customer sees the notification dot
            if (isset($validated['status']) && $validated['status'] !== $order->status) {
                $order->user_read_status = false;
            }

            $oldShippingCost = (float) ($order->shipping_cost ?? 0);
            if (array_key_exists('shipping_cost', $validated)) {
                $newShippingCost = (float) $validated['shipping_cost'];
                $shippingDelta = $newShippingCost - $oldShippingCost;
                $order->shipping_cost = $newShippingCost;
                $order->total_amount = max(0, (float) $order->total_amount + $shippingDelta);
                $order->user_read_status = false;

                if ($shippingDelta !== 0.0 && ($order->payment_method === 'credit' || $order->type === 'credit')) {
                    $creditCycle = $order->creditCycle
                        ?? CreditCycle::activeForUser($order->user_id)
                        ?? CreditCycle::query()
                            ->where('user_id', $order->user_id)
                            ->where('month', $order->created_at->month)
                            ->where('year', $order->created_at->year)
                            ->first();

                    $creditCycle?->increment('spent_amount', $shippingDelta);
                }
            }

            $order->fill(collect($validated)->except('shipping_cost')->filter(fn ($v) => $v !== null)->toArray());

            // Handle pickup image upload
            if ($request->hasFile('pickup_image')) {
                if ($order->pickup_image) {
                    Storage::disk('public')->delete($order->pickup_image);
                }
                $order->pickup_image = $request->file('pickup_image')->store('orders/pickup', 'public');
                $order->pickup_at = now();
            }

            // Handle COD image upload
            if ($request->hasFile('cod_image')) {
                if ($order->cod_image) {
                    Storage::disk('public')->delete($order->cod_image);
                }
                $order->cod_image = $request->file('cod_image')->store('orders/cod', 'public');
                $order->cod_uploaded_at = now();
            }

            $order->save();
        });

        return back()->with('success', 'อัปเดตออเดอร์สำเร็จ');
    }

    /**
     * Quick status actions: confirm, ship, reject.
     */
    public function quickAction(Request $request, Order $order)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'confirm':
                $order->update(['status' => 'paid_wait_shipping', 'user_read_status' => false]);
                $message = 'ยืนยันออเดอร์แล้ว';
                break;
            case 'ship':
                $order->update([
                    'status' => 'shipped',
                    'tracking_number' => $request->input('tracking_number', $order->tracking_number),
                    'user_read_status' => false,
                ]);
                $message = 'เปลี่ยนสถานะเป็นจัดส่งแล้ว';
                break;
            case 'reject':
                $order->update(['status' => 'cancelled', 'user_read_status' => false]);
                $message = 'ยกเลิกออเดอร์แล้ว';
                break;
            case 'complete':
                $order->update(['status' => 'completed', 'user_read_status' => false]);
                $message = 'ออเดอร์สำเร็จแล้ว';
                break;
            default:
                return back()->with('error', 'ไม่รู้จัก Action');
        }

        return back()->with('success', $message);
    }

    /**
     * Confirm all credit orders for a specific user in bulk.
     */
    public function confirmAllCredit(Request $request)
    {
        $userId = $request->input('user_id');

        $count = Order::where('user_id', $userId)
            ->where(function ($q) {
                $q->where('payment_method', 'credit')->orWhere('type', 'credit');
            })
            ->where('status', 'pending')
            ->update(['status' => 'paid_wait_shipping', 'user_read_status' => false]);

        return back()->with('success', "ยืนยันออเดอร์เครดิตสำเร็จ {$count} รายการ");
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'ลบออเดอร์สำเร็จ');
    }
}
