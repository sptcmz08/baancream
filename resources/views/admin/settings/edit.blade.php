@extends('layouts.admin')

@section('content')
<div class="header-actions">
    <div>
        <h2>ตั้งค่าเว็บ / โลโก้ / ค่าส่ง</h2>
        <p style="margin-top:8px; color:var(--text-muted);">อัปโหลดโลโก้และกำหนดค่าจัดส่งสำหรับหน้าร้าน</p>
    </div>
</div>

<div class="card" style="max-width: 980px;">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid; gap:24px; grid-template-columns:minmax(260px, 320px) minmax(0, 1fr); align-items:start;">
            <div>
                <div style="font-weight:500; margin-bottom:12px;">ตัวอย่างโลโก้ปัจจุบัน</div>
                <div style="border:1px solid var(--border-color); border-radius:16px; min-height:220px; background:#fafafa; display:flex; align-items:center; justify-content:center; padding:24px;">
                    @if($storefrontLogoUrl)
                        <img src="{{ $storefrontLogoUrl }}" alt="โลโก้เว็บไซต์" style="max-width:100%; max-height:160px; object-fit:contain;">
                    @else
                        <div style="text-align:center; color:var(--text-muted);">ยังไม่ได้อัปโหลดโลโก้<br>ระบบจะใช้ข้อความแทนให้อัตโนมัติ</div>
                    @endif
                </div>
            </div>

            <div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:10px; font-weight:500;">อัปโหลดโลโก้ใหม่</label>
                    <input type="file" name="storefront_logo" accept="image/*" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:10px; background:white;">
                    <div style="margin-top:8px; color:var(--text-muted); font-size:0.9rem;">แนะนำไฟล์พื้นหลังโปร่งใส เช่น PNG หรือ WebP</div>
                    @error('storefront_logo')
                        <div style="margin-top:8px; color:#dc2626; font-size:0.9rem;">{{ $message }}</div>
                    @enderror
                </div>

                <label style="display:flex; gap:10px; align-items:flex-start; margin-bottom:24px; color:var(--text-dark);">
                    <input type="checkbox" name="remove_storefront_logo" value="1" style="margin-top:4px;">
                    <span>ลบโลโก้ปัจจุบันและกลับไปใช้ข้อความแทน</span>
                </label>

                <div style="padding:16px 18px; border:1px solid var(--border-color); border-radius:14px; background:#fcfaf6; color:var(--text-muted); margin-bottom:24px;">
                    <div style="font-weight:500; color:var(--text-dark); margin-bottom:6px;">ตำแหน่งที่นำโลโก้นี้ไปใช้</div>
                    <div>หน้าแรกของร้าน</div>
                    <div>หน้ารายละเอียดสินค้า</div>
                    <div>popup เข้าสู่ระบบ / สมัครสมาชิก</div>
                </div>

                <button type="submit" class="btn btn-primary">บันทึกการตั้งค่า</button>
            </div>
        </div>

        <div style="margin-top:28px; padding-top:24px; border-top:1px solid var(--border-color);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:18px; flex-wrap:wrap; margin-bottom:18px;">
                <div>
                    <h3 style="margin:0 0 6px; font-size:1.2rem;">ตั้งค่าค่าจัดส่ง</h3>
                    <div style="color:var(--text-muted); font-size:0.92rem; line-height:1.7;">
                        ลูกค้าออนไลน์จะคิดค่าส่งจากจำนวนชิ้นตามตารางนี้ ส่วนลูกค้าเครดิตสามารถกลับมาแก้ค่าส่งจริงในหน้าออเดอร์หลังชั่งน้ำหนักได้
                    </div>
                </div>
                <button type="button" id="addShippingRuleButton" class="btn" style="background:#e0f2fe; color:#0369a1;">+ เพิ่มช่วงค่าส่ง</button>
            </div>

            <div style="max-width:260px; margin-bottom:18px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">ค่าส่งเริ่มต้น (บาท)</label>
                <input type="number" name="shipping_base_fee" value="{{ old('shipping_base_fee', $shippingBaseFee) }}" min="0" step="0.01" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:10px;">
            </div>

            <div style="overflow-x:auto;">
                <table class="table" style="min-width:680px;">
                    <thead>
                        <tr>
                            <th>ตั้งแต่จำนวนชิ้น</th>
                            <th>ถึงจำนวนชิ้น</th>
                            <th>ค่าส่ง (บาท)</th>
                            <th style="width:90px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody id="shippingRulesBody">
                        @foreach(old('shipping_rules', $shippingRules) as $index => $rule)
                            <tr data-shipping-rule-row>
                                <td>
                                    <input type="number" name="shipping_rules[{{ $index }}][min_qty]" value="{{ $rule['min_qty'] ?? 1 }}" min="1" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                                </td>
                                <td>
                                    <input type="number" name="shipping_rules[{{ $index }}][max_qty]" value="{{ $rule['max_qty'] ?? '' }}" min="1" placeholder="เว้นว่าง = ขึ้นไป" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                                </td>
                                <td>
                                    <input type="number" name="shipping_rules[{{ $index }}][fee]" value="{{ $rule['fee'] ?? 0 }}" min="0" step="0.01" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;">
                                </td>
                                <td>
                                    <button type="button" class="btn" data-remove-shipping-rule style="background:#fee2e2; color:#dc2626; padding:8px 12px;">ลบ</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:14px; padding:14px 16px; border:1px solid #fed7aa; background:#fff7ed; color:#9a3412; border-radius:12px; line-height:1.7; font-size:0.92rem;">
                แนะนำสำหรับลูกค้าโอนออนไลน์: ตั้งค่าส่งแบบเหมารวมตามจำนวนชิ้น เช่น 1-5 ชิ้น 30 บาท, 6-10 ชิ้น 50 บาท เพื่อให้ลูกค้าชำระจบในครั้งเดียว ส่วนกรณีน้ำหนักจริงเกิน ให้ใช้ระบบเครดิตหรือแจ้งเก็บส่วนต่างภายหลังเป็นรายออเดอร์
            </div>
        </div>
    </form>
</div>

<script>
    const shippingRulesBody = document.getElementById('shippingRulesBody');
    const addShippingRuleButton = document.getElementById('addShippingRuleButton');
    let shippingRuleIndex = shippingRulesBody?.querySelectorAll('[data-shipping-rule-row]').length || 0;

    function nextShippingRuleIndex() {
        const index = shippingRuleIndex;
        shippingRuleIndex += 1;
        return index;
    }

    function makeShippingRuleRow(index) {
        const row = document.createElement('tr');
        row.dataset.shippingRuleRow = '';
        row.innerHTML = `
            <td><input type="number" name="shipping_rules[${index}][min_qty]" value="1" min="1" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;"></td>
            <td><input type="number" name="shipping_rules[${index}][max_qty]" min="1" placeholder="เว้นว่าง = ขึ้นไป" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;"></td>
            <td><input type="number" name="shipping_rules[${index}][fee]" value="30" min="0" step="0.01" style="width:100%; padding:10px; border:1px solid var(--border-color); border-radius:8px;"></td>
            <td><button type="button" class="btn" data-remove-shipping-rule style="background:#fee2e2; color:#dc2626; padding:8px 12px;">ลบ</button></td>
        `;
        return row;
    }

    addShippingRuleButton?.addEventListener('click', () => {
        shippingRulesBody?.appendChild(makeShippingRuleRow(nextShippingRuleIndex()));
    });

    shippingRulesBody?.addEventListener('click', (event) => {
        if (event.target.matches('[data-remove-shipping-rule]')) {
            event.target.closest('[data-shipping-rule-row]')?.remove();
        }
    });
</script>
@endsection
