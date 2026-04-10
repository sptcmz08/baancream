<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::withCount('products')->latest()->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        $slug = Str::slug($request->name);
        if (empty($slug)) $slug = 'brand-' . uniqid();

        Brand::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'เพิ่มแบรนด์สำเร็จ');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
        ]);

        $slug = Str::slug($request->name);
        if (empty($slug)) $slug = 'brand-' . uniqid();

        $brand->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'อัปเดตแบรนด์สำเร็จ');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'ลบแบรนด์สำเร็จ');
    }
}
