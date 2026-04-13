@php
    $mediaUrl = fn (?string $path) => $path ? '/storage/' . ltrim($path, '/') : null;
@endphp

<style>
    @media (max-width: 640px) {
        #floatingCartButton {
            right: 14px !important;
            bottom: 14px !important;
            width: 56px !important;
            height: 56px !important;
            z-index: 55 !important;
        }
        #floatingCartButton > span:first-child {
            font-size: 1.45rem !important;
        }
        #floatingCartModal {
            align-items: flex-end !important;
            justify-content: center !important;
            padding: 0 !important;
        }
        #floatingCartModal > div {
            width: 100% !important;
            max-height: 88vh !important;
            border-radius: 22px 22px 0 0 !important;
        }
    }
</style>

@php
    $cartItems = $cartItems ?? [];
    $cartTotal = $cartTotal ?? 0;
@endphp

<button type="button" id="floatingCartButton" data-open-cart aria-label="เปิดตะกร้าสินค้า" style="position:fixed; right:24px; bottom:24px; width:72px; height:72px; border:none; border-radius:50%; background:linear-gradient(135deg, #4fb696, #5cd1b3); color:white; display:flex; align-items:center; justify-content:center; box-shadow:0 20px 45px rgba(51, 130, 106, 0.3); z-index:40; cursor:pointer; transition:transform 0.25s ease;">
    <span style="font-size:2rem; line-height:1;">🛒</span>
    @if(($cartCount ?? 0) > 0)
        <span style="position:absolute; top:4px; right:2px; min-width:26px; height:26px; border-radius:999px; background:#111827; color:white; font-size:0.8rem; font-weight:700; display:flex; align-items:center; justify-content:center; padding:0 7px;">{{ $cartCount }}</span>
    @endif
</button>

<div id="floatingCartModal" style="position:fixed; inset:0; background:rgba(15, 23, 42, 0.42); display:none; align-items:flex-end; justify-content:flex-end; padding:24px; z-index:60;">
    <div style="width:min(420px, 100%); max-height:min(78vh, 760px); background:#ffffff; border-radius:28px; box-shadow:0 28px 80px rgba(15, 23, 42, 0.24); overflow:hidden; display:flex; flex-direction:column;">
        <div style="padding:22px 22px 16px; border-bottom:1px solid #e7edf3; display:flex; align-items:center; justify-content:space-between; gap:12px;">
            <div>
                <div style="font-size:1.2rem; font-weight:700; color:#152034;">รายการในตะกร้า</div>
                <div style="font-size:0.92rem; color:#708198;">รวม {{ $cartCount ?? 0 }} ชิ้น</div>
            </div>
            <button type="button" id="floatingCartClose" aria-label="ปิดตะกร้า" style="width:40px; height:40px; border:none; border-radius:999px; background:#f3f6fb; color:#152034; font-size:1.1rem; cursor:pointer;">✕</button>
        </div>

        <div style="padding:18px 22px; overflow:auto; display:grid; gap:14px;">
            @forelse($cartItems as $item)
                <div style="border:1px solid #e7edf3; border-radius:20px; padding:14px; display:grid; gap:12px;">
                    <div style="display:flex; gap:12px; align-items:flex-start;">
                        <div style="width:72px; height:72px; border-radius:18px; overflow:hidden; flex:0 0 auto; background:#f3f6fb;">
                            @if(!empty($item['image']))
                                <img src="{{ $mediaUrl($item['image']) }}" alt="{{ $item['name'] ?? 'สินค้า' }}" style="width:100%; height:100%; object-fit:contain; padding:6px; mix-blend-mode:multiply;">
                            @else
                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:0.8rem;">No image</div>
                            @endif
                        </div>
                        <div style="min-width:0; flex:1;">
                            <div style="font-weight:700; color:#152034; line-height:1.4;">{{ $item['name'] ?? 'สินค้า' }}</div>
                            @if(!empty($item['variant_name']))
                                <div style="margin-top:6px; display:inline-flex; padding:5px 10px; border-radius:999px; background:#fff1f5; color:#e11d72; font-size:0.78rem; font-weight:700;">{{ $item['variant_name'] }}</div>
                            @endif
                            @if(!empty($item['uses_wholesale']))
                                <div style="margin-top:6px; display:inline-flex; padding:5px 10px; border-radius:999px; background:#e9faef; color:#15803d; font-size:0.78rem; font-weight:700;">ราคาส่ง {{ $item['wholesale_min_qty'] ?? 1 }} ชิ้น</div>
                            @endif
                            <div style="margin-top:8px; color:#708198; font-size:0.92rem;">{{ $item['quantity'] ?? 0 }} ชิ้น x ฿{{ number_format((float) ($item['unit_price'] ?? 0), 2) }}</div>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                        <div style="font-size:1rem; font-weight:700; color:#152034;">฿{{ number_format((float) ($item['subtotal'] ?? 0), 2) }}</div>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item['id'] ?? '' }}">
                            <button type="submit" style="border:none; border-radius:999px; padding:10px 14px; background:#fff1f2; color:#dc2626; font-family:inherit; font-weight:700; cursor:pointer;">ลบออก</button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="padding:24px; border:1px dashed #cbd5e1; border-radius:20px; text-align:center; color:#708198;">
                    ยังไม่มีสินค้าในตะกร้า
                </div>
            @endforelse
        </div>

        <div style="padding:18px 22px 22px; border-top:1px solid #e7edf3; display:grid; gap:12px;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                <span style="color:#708198;">ยอดรวม</span>
                <strong style="font-size:1.2rem; color:#152034;">฿{{ number_format((float) $cartTotal, 2) }}</strong>
            </div>
            @auth
                <a href="{{ route('checkout.index') }}" style="display:flex; align-items:center; justify-content:center; min-height:52px; border-radius:18px; background:linear-gradient(135deg, #12c758, #10b34e); color:white; font-weight:700; text-decoration:none;">ไปชำระเงิน</a>
            @else
                <button type="button" data-open-auth data-auth-mode="login" data-auth-redirect="{{ route('cart.index', absolute: false) }}" style="display:flex; align-items:center; justify-content:center; min-height:52px; border:none; width:100%; border-radius:18px; background:#152034; color:white; font-weight:700; cursor:pointer;">เข้าสู่ระบบเพื่อชำระเงิน</button>
            @endauth
        </div>
    </div>
</div>

<script>
    (() => {
        const cartButtons = Array.from(document.querySelectorAll('[data-open-cart]'));
        const cartModal = document.getElementById('floatingCartModal');
        const cartClose = document.getElementById('floatingCartClose');

        if (!cartButtons.length || !cartModal) {
            return;
        }

        const openCart = () => {
            cartModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };

        const closeCart = () => {
            cartModal.style.display = 'none';
            document.body.style.overflow = '';
        };

        cartButtons.forEach((button) => button.addEventListener('click', openCart));
        cartClose?.addEventListener('click', closeCart);
        cartModal.addEventListener('click', (event) => {
            if (event.target === cartModal) {
                closeCart();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && cartModal.style.display === 'flex') {
                closeCart();
            }
        });
    })();
</script>
