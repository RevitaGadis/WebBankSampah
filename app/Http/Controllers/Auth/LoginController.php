<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $identitas = $request->validated()['identitas'];
        $password = $request->validated()['password'];

        if (Auth::guard('web')->attempt(['username' => $identitas, 'password' => $password])) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            return $user->role === 'admin'
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('petugas.dashboard'));
        }

        if (Auth::guard('nasabah')->attempt(['no_nasabah' => $identitas, 'password' => $password])) {
            $request->session()->regenerate();

            return redirect()->intended(route('nasabah.dashboard'));
        }

        return back()->withErrors([
            'identitas' => 'Username/No. Nasabah atau password salah.',
        ])->onlyInput('identitas');
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        if (Auth::guard('nasabah')->check()) {
            Auth::guard('nasabah')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
