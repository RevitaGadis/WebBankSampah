<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSetoranRequest;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Services\SetoranService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SetoranController extends Controller
{
    public function __construct(protected SetoranService $setoranService)
    {
    }

    public function store(StoreSetoranRequest $request): RedirectResponse
    {
        $setoran = $this->setoranService->prosesSetoran(
            $request->validated(),
            Auth::guard('web')->id()
        );

        return redirect()
            ->route('petugas.setoran.show', $setoran)
            ->with('sukses', 'Setoran berhasil dicatat, saldo nasabah sudah diupdate.');
    }

    public function show(Setoran $setoran): View
    {
        $setoran->load(['nasabah', 'jenisSampah', 'petugas']);

        return view('setoran.show', compact('setoran'));
    }

    public function cariNasabah(Request $request): JsonResponse
    {
        $nasabah = Nasabah::query()
            ->where('nama', 'like', "%{$request->q}%")
            ->orWhere('no_nasabah', 'like', "%{$request->q}%")
            ->limit(8)
            ->get(['id_nasabah', 'no_nasabah', 'nama', 'kelas', 'saldo']);

        return response()->json($nasabah);
    }
}