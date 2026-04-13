<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateUser($request);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => null,
            'password' => Hash::make($validated['password']),
            'role' => $this->normalizeRole($validated['role']),
        ]);

        return back()->with('success', 'เพิ่มผู้ใช้งานสำเร็จ');
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateUser($request, $user);
        $validated['role'] = $this->normalizeRole($validated['role']);

        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'ไม่สามารถลดสิทธิ์แอดมินของบัญชีที่กำลังใช้งานอยู่ได้');
        }

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

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

    private function validateUser(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user?->id),
            ],
            'role' => ['required', 'in:user,customer,admin'],
            'password' => [
                $user ? 'nullable' : 'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);
    }

    private function normalizeRole(string $role): string
    {
        return $role === 'user' ? 'customer' : $role;
    }
}
