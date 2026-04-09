<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credits = \App\Models\CreditCycle::with('user')->latest()->get();
        $users = \App\Models\User::whereIn('role', ['customer', 'vip'])->get();
        return view('admin.credits.index', compact('credits', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'credit_limit' => 'nullable|numeric|min:0'
        ]);

        \App\Models\CreditCycle::updateOrCreate(
            ['user_id' => $request->user_id, 'month' => $request->month, 'year' => $request->year],
            ['credit_limit' => $request->credit_limit]
        );

        return back()->with('success', 'กำหนดโควตาเครดิตสำเร็จ');
    }

    public function update(Request $request, \App\Models\CreditCycle $credit)
    {
        $request->validate(['status' => 'required']);
        $credit->update(['status' => $request->status]);
        return back()->with('success', 'เปลี่ยนสถานะบิลเครดิตสำเร็จ');
    }

    public function destroy(\App\Models\CreditCycle $credit)
    {
        $credit->delete();
        return back()->with('success', 'ลบรอบบิลเครดิตสำเร็จ');
    }
}
