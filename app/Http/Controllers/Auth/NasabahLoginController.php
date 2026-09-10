<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NasabahLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasabahLoginController extends Controller
{
    public function create(): \Illuminate\View\View
    {
        return view('nasabah.auth.login');
    }

    public function store(NasabahLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        
        if (!Auth::guard('nasabah')->attempt($credentials)) {
            return back()->withErrors([
                'no_nasabah' => 'Nomor nasabah atau PIN salah.',
            ])->onlyInput('no_nasabah');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('portal.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('nasabah')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('nasabah.login');
    }
}
