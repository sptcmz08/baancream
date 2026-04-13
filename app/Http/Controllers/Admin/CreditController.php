<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditCycle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreditController extends Controller
{
    public function index()
    {
        $usersWithCredits = User::has('creditCycles')
            ->with(['creditCycles' => function ($query) {
                $query->with(['orders.items.product', 'orders.items.variant'])
                    ->orderByDesc('year')
                    ->orderByDesc('month')
                    ->orderByDesc('id');
            }])
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $users = User::where('role', '!=', 'admin')
            ->orderBy('name')
            ->get();

        return view('admin.credits.index', compact('usersWithCredits', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'member_role' => 'required|in:customer,vip',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'due_date' => 'required|date',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->forceFill([
            'role' => $validated['member_role'],
            'is_credit_enabled' => true,
            'default_credit_limit' => $validated['member_role'] === 'vip'
                ? null
                : ($validated['credit_limit'] ?? $user->default_credit_limit),
            'credit_due_date' => $validated['due_date'],
        ])->save();

        CreditCycle::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'month' => $validated['month'],
                'year' => $validated['year'],
            ],
            [
                'due_date' => $validated['due_date'],
                'credit_limit' => $validated['member_role'] === 'vip' ? null : ($validated['credit_limit'] ?? null),
                'status' => 'pending',
            ]
        );

        return back()->with('success', 'กำหนดรอบเครดิตสำเร็จ');
    }

    public function update(Request $request, CreditCycle $credit)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid',
            'due_date' => 'nullable|date',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_note' => 'nullable|string',
            'payment_slip' => 'nullable|image|max:4096',
        ]);

        $credit->fill([
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? $credit->due_date,
            'credit_limit' => array_key_exists('credit_limit', $validated) ? $validated['credit_limit'] : $credit->credit_limit,
            'payment_note' => $validated['payment_note'] ?? $credit->payment_note,
            'paid_at' => $validated['status'] === 'paid' ? ($credit->paid_at ?? now()) : null,
        ]);

        if ($request->hasFile('payment_slip')) {
            if ($credit->payment_slip) {
                Storage::disk('public')->delete($credit->payment_slip);
            }

            $credit->payment_slip = $request->file('payment_slip')->store('credit-slips', 'public');
            $credit->payment_submitted_at = now();
        }

        $credit->save();
        $credit->recalculateSpentAmount();

        return back()->with('success', 'อัปเดตรอบเครดิตสำเร็จ');
    }

    public function destroy(CreditCycle $credit)
    {
        if ($credit->payment_slip) {
            Storage::disk('public')->delete($credit->payment_slip);
        }

        $credit->delete();

        return back()->with('success', 'ลบรอบบิลเครดิตสำเร็จ');
    }
}
