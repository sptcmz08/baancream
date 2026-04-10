@extends('layouts.admin')

@section('content')
@php
    $variantRows = old('variants', $product->variants->map(fn ($variant) => [
        'id' => $variant->id,
        'name' => $variant->name,
        'description' => $variant->description,
        'retail_price' => $variant->retail_price,
        'wholesale_price' => $variant->wholesale_price,
        'wholesale_min_qty' => $variant->wholesale_min_qty ?: $product->wholesale_min_qty,
        'stock' => $variant->stock,
        'images' => $variant->galleryImages(),
    ])->toArray());

    if (empty($variantRows)) {
        $variantRows = [[
            'name' => '',
            'description' => '',
            'retail_price' => '',
            'wholesale_price' => '',
            'wholesale_min_qty' => $product->wholesale_min_qty,
            'stock' => '',
            'images' => [],
        ]];
    }
@endphp

@include('admin.products.partials.form', [
    'pageTitle' => 'แก้ไขสินค้า: ' . $product->sku,
    'backRoute' => route('admin.products.index'),
    'formAction' => route('admin.products.update', $product),
    'formMethod' => 'PUT',
    'submitLabel' => 'บันทึกการแก้ไข',
    'product' => $product,
    'categories' => $categories,
    'selectedCategoryIds' => old('category_ids', $product->categories->pluck('id')->toArray()),
    'variantRows' => $variantRows,
])
@endsection
