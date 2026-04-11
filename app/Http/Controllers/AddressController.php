<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        return response()->json(
            Auth::user()->addresses()->orderByDesc('is_primary')->orderByDesc('id')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address_line' => 'required|string',
            'subdistrict' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'is_primary' => 'nullable|boolean',
        ]);

        $validated['user_id'] = Auth::id();

        $address = Address::create($validated);

        if ($request->boolean('is_primary') || Auth::user()->addresses()->count() === 1) {
            $address->markAsPrimary();
        }

        return response()->json(['success' => true, 'address' => $address->fresh()]);
    }

    public function update(Request $request, Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'label' => 'nullable|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address_line' => 'required|string',
            'subdistrict' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'is_primary' => 'nullable|boolean',
        ]);

        $address->update($validated);

        if ($request->boolean('is_primary')) {
            $address->markAsPrimary();
        }

        return response()->json(['success' => true, 'address' => $address->fresh()]);
    }

    public function destroy(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);
        $address->delete();
        return response()->json(['success' => true]);
    }

    public function setPrimary(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);
        $address->markAsPrimary();
        return response()->json(['success' => true]);
    }
}
