<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name)
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'เพิ่มหมวดหมู่สำเร็จ');
    }

    public function edit(\App\Models\Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, \App\Models\Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name)
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'อัปเดตหมวดหมู่สำเร็จ');
    }

    public function destroy(\App\Models\Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'ลบหมวดหมู่สำเร็จ');
    }
}
