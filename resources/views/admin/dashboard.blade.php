@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <h2>ภาพรวมระบบ (Dashboard)</h2>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">ยอดขายรอตรวจสอบสลิป</h4>
        <div style="font-size: 2rem; font-weight: 600; color: var(--primary-color);">0</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">ออเดอร์ใหม่</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">ยอดการใช้เครดิตเดือนนี้</h4>
        <div style="font-size: 2rem; font-weight: 600; color: #dc2626;">฿ 0.00</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">รอบบิลปัจจุบัน</div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <h4 style="color: var(--text-muted); margin-bottom: 10px;">รายการสินค้าทั้งหมด</h4>
        <div style="font-size: 2rem; font-weight: 600; color: #3b82f6;">0</div>
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;">SKU ที่ใช้งานอยู่</div>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 20px; font-weight: 500;">ออเดอร์ล่าสุด (ล่าสุด 5 รายการ)</h3>
    <table class="table">
        <thead>
            <tr>
                <th>รหัสออเดอร์</th>
                <th>ลูกค้า</th>
                <th>ประเภท</th>
                <th>ยอดชำระ</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">ยังไม่มีรายการสั่งซื้อ</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
