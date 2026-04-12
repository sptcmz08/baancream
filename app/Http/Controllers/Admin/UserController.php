<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $role = $request->input('role');
        if ($role === 'user') {
            $request->merge(['role' => 'customer']);
        }

        $validated = $request->validate([
            'role' => 'required|in:customer,admin',
        ]);

        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'ไม่สามารถลดสิทธิ์แอดมินของบัญชีที่กำลังใช้งานอยู่ได้');
        }

        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', "อัปเดตข้อมูลผู้ใช้ {$user->name} สำเร็จ");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'ไม่สามารถลบตัวเองได้');
        }

        $user->delete();
        return back()->with('success', 'ลบผู้ใช้สำเร็จ');
    }
}
