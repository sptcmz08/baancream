<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Support\MediaPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $path,
            'link' => $request->link,
            'sort_order' => $request->integer('sort_order', 0),
            'is_active' => true,
        ]);

        return back()->with('success', 'เพิ่มแบนเนอร์สำเร็จ');
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $banner->image = $request->file('image')->store('banners', 'public');
        }

        $banner->title = $request->input('title', $banner->title);
        $banner->link = $request->input('link', $banner->link);
        $banner->sort_order = $request->integer('sort_order', $banner->sort_order);
        $banner->is_active = $request->boolean('is_active', $banner->is_active);
        $banner->save();

        return back()->with('success', 'อัปเดตแบนเนอร์สำเร็จ');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return back()->with('success', 'ลบแบนเนอร์สำเร็จ');
    }
}
