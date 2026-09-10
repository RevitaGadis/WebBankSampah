<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSetoranRequest;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Setoran;
use App\Services\SetoranService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SetoranController extends Controller
{
    public function __construct(protected SetoranService $setoranService)
    {
    }

    public function index(Request $request): View
    {
        $setoran = Setoran::query()
            ->with(['nasabah', 'jenisSampah', 'petugas'])
            ->when($request->tanggal_mulai, fn ($q, $v) => $q->whereDate('tanggal', '>=', $v))
            ->when($request->tanggal_selesai, fn ($q, $v) => $q->whereDate('tanggal', '<=', $v))
            ->latest('tanggal')
            ->paginate(15)
            ->withQueryString();

        return view('setoran.index', compact('setoran'));
    }

    public function create(): View
    {
        $jenisSampah = JenisSampah::orderBy('nama_jenis')->get();

        return view('setoran.create', compact('jenisSampah'));
    }

    public function store(StoreSetoranRequest $request): RedirectResponse
    {
        $setoran = $this->setoranService->prosesSetoran(
            $request->validated(),
            Auth::guard('web')->id()
        );

        return redirect()
            ->route('setoran.show', $setoran)
            ->with('sukses', 'Setoran berhasil dicatat, saldo nasabah sudah diupdate.');
    }

    public function show(Setoran $setoran): View
    {
        $setoran->load(['nasabah', 'jenisSampah', 'petugas']);

        return view('setoran.show', compact('setoran'));
    }

    public function cariNasabah(Request $request): \Illuminate\Http\JsonResponse
    {
        $nasabah = Nasabah::query()
            ->where('nama', 'like', "%{$request->q}%")
            ->orWhere('no_nasabah', 'like', "%{$request->q}%")
            ->limit(8)
            ->get(['id_nasabah', 'no_nasabah', 'nama', 'kelas', 'saldo']);

        return response()->json($nasabah);
    }
}
