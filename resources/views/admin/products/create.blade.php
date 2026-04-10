@extends('layouts.admin')

@section('content')
@php
    $variantRows = old('variants', [
        [
            'name' => '',
            'description' => '',
            'retail_price' => '',
            'wholesale_price' => '',
            'wholesale_min_qty' => old('wholesale_min_qty', 10),
            'stock' => '',
            'images' => [],
        ],
    ]);
@endphp

@include('admin.products.partials.form', [
    'pageTitle' => 'เพิ่มสินค้าใหม่',
    'backRoute' => route('admin.products.index'),
    'formAction' => route('admin.products.store'),
    'formMethod' => 'POST',
    'submitLabel' => 'บันทึกสินค้าใหม่',
    'product' => null,
    'categories' => $categories,
    'selectedCategoryIds' => old('category_ids', []),
    'variantRows' => $variantRows,
])
@endsection
