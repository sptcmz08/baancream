<a href="{{ route('cart.index') }}" style="position:fixed; right:24px; bottom:24px; width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg, #4fb696, #5cd1b3); color:white; display:flex; align-items:center; justify-content:center; box-shadow:0 20px 45px rgba(51, 130, 106, 0.3); z-index:40; text-decoration:none; transition:transform 0.25s ease;">
    <span style="font-size:2rem; line-height:1;">🛒</span>
    @if(($cartCount ?? 0) > 0)
        <span style="position:absolute; top:4px; right:2px; min-width:26px; height:26px; border-radius:999px; background:#111827; color:white; font-size:0.8rem; font-weight:700; display:flex; align-items:center; justify-content:center; padding:0 7px;">{{ $cartCount }}</span>
    @endif
</a>
