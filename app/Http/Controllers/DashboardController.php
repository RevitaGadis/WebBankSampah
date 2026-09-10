<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::guard('web')->user();

        $totalSampahKg = Setoran::sum('berat');
        $totalTransaksiBulanIni = Setoran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        $totalSaldoBeredar = DB::table('nasabah')->sum('saldo');

        $transaksiTerbaru = Setoran::with(['nasabah', 'jenisSampah'])
            ->latest('tanggal')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalSampahKg',
            'totalTransaksiBulanIni',
            'totalSaldoBeredar',
            'transaksiTerbaru'
        ));
    }
}
