<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNasabahRequest;
use App\Http\Requests\UpdateNasabahRequest;
use App\Models\Nasabah;
use App\Services\NasabahService;
use Illuminate\Http\RedirectResponse;

class NasabahController extends Controller
{
    public function __construct(protected NasabahService $nasabahService)
    {
    }

    public function store(StoreNasabahRequest $request): RedirectResponse
    {
        $this->nasabahService->buatNasabah($request->validated());

        return back()->with('sukses', 'Nasabah berhasil ditambahkan.');
    }

    public function update(UpdateNasabahRequest $request, Nasabah $nasabah): RedirectResponse
    {
        $this->nasabahService->updateNasabah($nasabah, $request->validated());

        return back()->with('sukses', 'Data nasabah berhasil diupdate.');
    }

    public function destroy(Nasabah $nasabah): RedirectResponse
    {
        if ($nasabah->setoran()->exists()) {
            return back()->withErrors(['hapus' => 'Nasabah ini masih punya riwayat transaksi, gak bisa dihapus.']);
        }

        $nasabah->delete();

        return back()->with('sukses', 'Nasabah berhasil dihapus.');
    }
}