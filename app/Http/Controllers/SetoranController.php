<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSetoranRequest;
use App\Models\Nasabah;
use App\Services\SetoranService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    public function __construct(protected SetoranService $setoranService)
    {
    }

    public function store(StoreSetoranRequest $request): RedirectResponse
    {
        $this->setoranService->prosesSetoran(
            $request->validated(),
            Auth::guard('web')->user()->id_user
        );

        return redirect()
            ->route('petugas.setoran')
            ->with('sukses', 'Setoran berhasil dicatat, saldo nasabah sudah diupdate.');
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