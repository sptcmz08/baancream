<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
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
        $validated = $request->validate([
            'role' => 'nullable|in:customer,vip,admin',
            'is_credit_enabled' => 'nullable|boolean',
            'credit_due_date' => 'nullable|date',
            'default_credit_limit' => 'nullable|numeric|min:0',
        ]);

        $user->fill([
            'role' => $validated['role'] ?? $user->role,
            'is_credit_enabled' => $request->boolean('is_credit_enabled'),
            'credit_due_date' => $validated['credit_due_date'] ?? $user->credit_due_date,
            'default_credit_limit' => $validated['default_credit_limit'] ?? $user->default_credit_limit,
        ]);
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
