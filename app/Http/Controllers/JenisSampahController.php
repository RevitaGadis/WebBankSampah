<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJenisSampahRequest;
use App\Http\Requests\UpdateJenisSampahRequest;
use App\Models\JenisSampah;
use Illuminate\Http\RedirectResponse;

class JenisSampahController extends Controller
{
    public function store(StoreJenisSampahRequest $request): RedirectResponse
    {
        JenisSampah::create($request->validated());

        return back()->with('sukses', 'Jenis sampah berhasil ditambahkan.');
    }

    public function update(UpdateJenisSampahRequest $request, JenisSampah $jenis_sampah): RedirectResponse
    {
        $jenis_sampah->update($request->validated());

        return back()->with('sukses', 'Jenis sampah berhasil diupdate.');
    }

    public function destroy(JenisSampah $jenis_sampah): RedirectResponse
    {
        if ($jenis_sampah->setoran()->exists()) {
            return back()->withErrors(['hapus' => 'Jenis sampah ini masih punya riwayat transaksi, gak bisa dihapus.']);
        }

        $jenis_sampah->delete();

        return back()->with('sukses', 'Jenis sampah berhasil dihapus.');
    }
}