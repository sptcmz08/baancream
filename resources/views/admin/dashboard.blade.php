@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <h2>ภาพรวมระบบ (Dashboard)</h2>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">ยอดขายรอตรวจสอบสลิป</h4>
        <div style="font-size: 2rem; font-weight: 600; color: var(--primary-color);">{{ $pendingOrders }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">ออเดอร์ใหม่</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">ยอดการใช้เครดิตเดือนนี้</h4>
        <div style="font-size: 2rem; font-weight: 600; color: #dc2626;">฿ {{ number_format($monthlyCreditUsage, 2) }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">รอบบิลปัจจุบัน</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">รายการสินค้าทั้งหมด</h4>
        <div style="font-size: 2rem; font-weight: 600; color: #3b82f6;">{{ $productCount }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">SKU ที่ใช้งานอยู่</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">สมาชิกทั้งหมด</h4>
        <div style="font-size: 2rem; font-weight: 600; color: #8b5cf6;">{{ $userCount }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">ผู้ใช้ที่ลงทะเบียน</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">รายได้ (ยืนยันแล้ว)</h4>
        <div style="font-size: 2rem; font-weight: 600; color: #10b981;">฿ {{ number_format($totalRevenue, 2) }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">รวมออเดอร์สำเร็จ</div>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 20px; font-weight: 500;">ออเดอร์ล่าสุด (ล่าสุด 5 รายการ)</h3>
    <table class="table">
        <thead>
            <tr>
                <th>รหัสออเดอร์</th>
                <th>ลูกค้า</th>
                <th>ชำระเงิน</th>
                <th>ยอดชำระ</th>
                <th>สถานะ</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
            <tr>
                <td style="font-weight:500;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>{{ $order->paymentLabel() }}</td>
                <td style="color:var(--primary-color); font-weight:500;">฿{{ number_format($order->total_amount, 2) }}</td>
                <td>
                    <span style="font-size:0.82rem; font-weight:500;">{{ $order->statusLabel() }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" style="color:var(--primary-color); font-size:0.85rem; text-decoration:none;">ดู →</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">ยังไม่มีรายการสั่งซื้อ</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
