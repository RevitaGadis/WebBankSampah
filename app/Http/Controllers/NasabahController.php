<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNasabahRequest;
use App\Http\Requests\UpdateNasabahRequest;
use App\Models\Nasabah;
use App\Services\NasabahService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NasabahController extends Controller
{
    public function __construct(protected NasabahService $nasabahService)
    {
    }

    public function index(Request $request): View
    {
        $nasabah = Nasabah::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_nasabah', 'like', "%{$search}%");
            })
            ->when($request->kelas, fn ($query, $kelas) => $query->where('kelas', $kelas))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('nasabah.index', compact('nasabah'));
    }

    public function show(Nasabah $nasabah): View
    {
        $riwayat = $nasabah->setoran()->with('jenisSampah', 'petugas')->latest('tanggal')->paginate(10);

        return view('nasabah.show', compact('nasabah', 'riwayat'));
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
