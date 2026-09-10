<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function dashboard(): View
    { /** @var \App\Models\Nasabah $nasabah */
        $nasabah = Auth::guard('nasabah')->user();

        $riwayat = $nasabah->setoran()
            ->with('jenisSampah')
            ->latest('tanggal')
            ->paginate(10);

        return view('portal.dashboard', compact('nasabah', 'riwayat'));
    }
}
