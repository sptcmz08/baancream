@php
    $variant = $variant ?? 'brand';
    $imageClass = $variant === 'auth' ? 'auth-logo-image' : 'brand-logo-image';
@endphp

@if(!empty($storefrontLogoUrl))
    <img src="{{ $storefrontLogoUrl }}" alt="บ้านครีม สิงห์บุรี" class="{{ $imageClass }}">
@else
    <span>b</span><span>a</span><span>a</span><span>n</span><span>cream</span>
@endif
