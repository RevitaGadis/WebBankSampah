<section class="flex items-center gap-4 rounded-xl border border-[#e5dcc8] bg-[#fcf3dd] p-5">
    <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-[#54220f] text-lg font-bold text-white">{{ $student['initial'] ?? strtoupper(substr($student['name'] ?? 'U', 0, 2)) }}</span>
    <div>
        <div class="flex flex-wrap items-center gap-2">
            <b class="text-lg">{{ $student['name'] ?? '-' }}</b>
            <span class="rounded bg-[#e9e4d4] px-2 py-1 text-xs">{{ str_contains($student['class'] ?? '', 'Guru') ? 'Guru' : 'Siswa' }}</span>
        </div>
        <small class="mt-0.5 block text-[#92591f]">{{ $student['class'] ?? '-' }}</small>
        <small class="mt-1 block font-mono">{{ $student['phone'] ?? '-' }}</small>
    </div>
</section>

<h3 class="mt-6 text-sm font-bold text-[#92591f]">DATA REKENING &amp; ATRIBUT ENTITAS</h3>
<section class="mt-3 grid gap-3 sm:grid-cols-3">
    <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">ID_NASABAH</small><b class="block">#{{ $student['id'] ?? '-' }}</b></div>
    <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">NO_NASABAH</small><b class="block font-mono">{{ $student['number'] ?? '-' }}</b></div>
    <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">NAMA_LENGKAP</small><b class="block">{{ $student['name'] ?? '-' }}</b></div>
    <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">TINGKAT_KELAS</small><b class="block">{{ $student['class'] ?? '-' }}</b></div>
    <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">KONTAK_WA</small><b class="block font-mono">{{ $student['phone'] ?? '-' }}</b></div>
    <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">STATUS_SYNC_KAS</small><b class="block">&bull; {{ $student['status'] ?? 'Aktif' }}</b></div>
</section>

<h3 class="mt-6 text-sm font-bold text-[#92591f]">RINGKASAN STATISTIK SAMPAH &amp; FINANSIAL</h3>
<section class="mt-3 grid gap-3 sm:grid-cols-2">
    <x-nasabah.stat-card label="Saldo Saat Ini" value="Rp {{ $student['balance'] ?? '0' }}"
        description="Buku kas aktif" icon="bi-wallet2" desc-icon="bi-wallet2" accent="#92591f" />
    <x-nasabah.stat-card label="Reduksi Sampah" value="{{ $student['total_weight'] ?? '0' }}" unit="Kg"
        description="Tereduksi dari TPA" icon="bi-recycle" desc-icon="bi-recycle" accent="#bdcaa8" />
    <x-nasabah.stat-card label="Frekuensi Setor" value="{{ $student['count'] ?? '0' }}" unit="Sesi"
        description="Transaksi terverifikasi" icon="bi-arrow-repeat" desc-icon="bi-arrow-repeat" accent="#ffb980" />
    <x-nasabah.stat-card label="Timbang Terakhir" value="{{ $student['last_deposit'] ?? '-' }}"
        description="{{ $student['last_deposit_item'] ?? '-' }}" icon="bi-clock-history"
        desc-icon="bi-clock-history" accent="#dce9c9" />
</section>

<div class="mt-6 flex items-center justify-between gap-3">
    <h3 class="text-sm font-bold text-[#92591f]">RIWAYAT SETORAN TERAKHIR</h3>
    <a href="{{ route('admin.nasabah.rekap', $student['number'] ?? '') }}"
        class="text-xs font-bold text-[#92591f] hover:underline">Lihat Semua Setoran &rsaquo;</a>
</div>
<section class="mt-3 overflow-hidden rounded-xl border border-[#ece5d8] bg-white text-sm">
    <div class="grid grid-cols-[1fr_2fr_1fr_1fr] bg-[#f8f1df] p-3 text-[10px] font-bold uppercase tracking-wide text-[#695b51]">
        <span>Tanggal</span>
        <span>Kategori &amp; Komoditas</span>
        <span>Berat</span>
        <span>Subtotal Saldo</span>
    </div>
    @forelse ($transactions as $t)
        <div class="grid grid-cols-[1fr_2fr_1fr_1fr] items-start gap-2 border-t border-[#f0eadf] p-3">
            <span class="font-mono text-xs">{{ $t['date'] }}</span>
            <b>{{ $t['jenis'] }}</b>
            <span class="font-mono">{{ $t['weight'] }} Kg</span>
            <b class="font-mono text-[#92591f]">+ Rp {{ $t['total'] }}</b>
        </div>
    @empty
        <p class="border-t border-[#f0eadf] p-5 text-center text-xs text-[#695b51]">Belum ada setoran tercatat untuk nasabah ini.</p>
    @endforelse
</section>
