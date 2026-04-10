<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): RedirectResponse
    {
        return redirect()->route('home', array_filter([
            'auth' => 'login',
            'redirect_to' => $this->redirectTarget($request),
        ]));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $redirectTarget = $this->redirectTarget($request);

        return $redirectTarget
            ? redirect()->to($redirectTarget)
            : redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
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
