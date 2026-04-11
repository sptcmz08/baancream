<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): RedirectResponse
    {
        return redirect()->route('home', array_filter([
            'auth' => 'register',
            'redirect_to' => $this->redirectTarget($request),
        ]));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => strtolower(preg_replace('/[^A-Za-z0-9]/', '', $request->username)) . '_' . time() . '@baancream.local',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        $redirectTarget = $this->redirectTarget($request);

        return $redirectTarget
            ? redirect()->to($redirectTarget)
            : redirect(route('dashboard', absolute: false));
    }

    private function redirectTarget(Request $request): ?string
    {
        $target = (string) $request->input('redirect_to', $request->query('redirect_to', ''));

        if ($target === '') {
            return null;
        }

        if (str_starts_with($target, '/')) {
            return $target;
        }

        return null;
    }
}
