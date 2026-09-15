<x-layouts.admin title="Rekap Nasabah - {{ $student['name'] ?? 'Nasabah' }}" :admin="$admin">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold text-[#92591f]"><a href="{{ route('admin.nasabah') }}" class="hover:underline">Nasabah</a> &rsaquo; Rekap Lengkap</p>
            <h1 class="mt-2 text-3xl font-bold">Rekap Transaksi Lengkap</h1>
            <p class="mt-1 text-[#695b51]">Rincian seluruh mutasi setoran sampah dan kredit saldo nasabah tercatat.</p>
        </div>
        <div class="flex gap-3"><button type="button" class="rounded-lg bg-white px-4 py-3 text-sm font-bold"><i class="bi bi-printer mr-1"></i> Cetak</button><button type="button" class="rounded-lg bg-[#92591f] px-4 py-3 text-sm font-bold text-white"><i class="bi bi-download mr-1"></i> Unduh PDF</button></div>
    </div>

    <section class="mt-6 flex items-center gap-4 rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-5">
        <span class="grid h-14 w-14 place-items-center rounded-2xl bg-[#54220f] text-lg font-bold text-white">{{ $student['initial'] ?? strtoupper(substr($student['name'] ?? 'U', 0, 2)) }}</span>
        <div>
            <div class="flex items-center gap-2"><h2 class="text-xl font-bold">{{ $student['name'] ?? '-' }}</h2><span class="rounded bg-[#eee8d7] px-2 py-0.5 text-xs font-medium">Siswa Nasabah</span><span class="flex items-center gap-1 rounded-full bg-[#dce9c9] px-2 py-0.5 text-[10px] font-bold text-[#3d2417]">&bull; {{ $student['status'] ?? 'Aktif' }}</span></div>
            <p class="mt-0.5 text-sm text-[#695b51]">{{ $student['class'] ?? '-' }} &bull; No. {{ $student['number'] ?? '-' }} &bull; {{ $student['phone'] ?? '-' }}</p>
        </div>
    </section>

    <section class="mt-6 grid gap-4 md:grid-cols-4">
        <article class="ns-card border-t-4 border-[#92591f] p-5"><span class="ns-label">Saldo Tabungan</span><strong class="mt-4 block text-2xl">Rp {{ number_format((int) str_replace('.', '', $student['balance'] ?? '0'), 0, ',', '.') }}</strong><small class="mt-1 block text-[#695b51]"><i class="bi bi-wallet2"></i> Buku Kas Aktif</small></article>
        <article class="ns-card border-t-4 border-[#bdcaa8] p-5"><span class="ns-label">Total Sampah Ditimbang</span><strong class="mt-4 block text-2xl">{{ $student['total_weight'] ?? '68,4' }} Kg</strong><small class="mt-1 block text-[#695b51]"><i class="bi bi-recycle"></i> Tereduksi</small></article>
        <article class="ns-card border-t-4 border-[#ffb980] p-5"><span class="ns-label">Frekuensi Setor</span><strong class="mt-4 block text-2xl">{{ $student['count'] ?? '0' }} Kali</strong><small class="mt-1 block text-[#695b51]"><i class="bi bi-arrow-repeat"></i> Transaksi</small></article>
        <article class="ns-card border-t-4 border-[#dce9c9] p-5"><span class="ns-label">Terakhir Setor</span><strong class="mt-4 block text-lg">{{ $student['last_deposit'] ?? '07 Sep 2026' }}</strong><small class="mt-1 block text-[#695b51]">{{ $student['last_deposit_item'] ?? 'Plastik PET (4,2 Kg)' }}</small></article>
    </section>

    <section class="ns-card mt-8 overflow-hidden">
        <header class="flex items-center justify-between bg-[#f8f1df] px-6 py-4">
            <h2 class="text-lg font-bold">Riwayat Transaksi Setoran</h2>
            <span class="rounded bg-[#eee8d7] px-3 py-1 text-xs font-semibold">{{ count($transactions) }} Transaksi</span>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-sm">
                <thead class="bg-[#fffaf0] text-left text-[10px] uppercase tracking-wide text-[#695b51]">
                    <tr>
                        <th class="w-[6%] px-4 py-3 text-center">No</th>
                        <th class="w-[14%] px-4 py-3">ID Transaksi</th>
                        <th class="w-[16%] px-4 py-3">Tanggal &amp; Waktu</th>
                        <th class="w-[24%] px-4 py-3">Kategori Sampah</th>
                        <th class="w-[10%] px-4 py-3 text-right">Berat</th>
                        <th class="w-[12%] px-4 py-3 text-right">Harga / Kg</th>
                        <th class="w-[12%] px-4 py-3 text-right">Total Nilai</th>
                        <th class="w-[10%] px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $i => $t)
                        <tr class="border-t border-[#f0eadf] even:bg-[#fffdf8]">
                            <td class="px-4 py-3.5 text-center">{{ $i + 1 }}</td>
                            <td class="px-4 py-3.5 font-mono text-xs font-bold text-[#92591f]">{{ $t['id'] }}</td>
                            <td class="px-4 py-3.5">{{ $t['date'] }}<small class="mt-0.5 block text-[#695b51]">{{ $t['time'] }}</small></td>
                            <td class="px-4 py-3.5"><span class="rounded-full bg-[#f4ecd7] px-2.5 py-1 text-xs font-semibold">{{ $t['jenis'] }}</span></td>
                            <td class="px-4 py-3.5 text-right font-bold">{{ $t['weight'] }} Kg</td>
                            <td class="px-4 py-3.5 text-right">Rp {{ $t['price'] }}</td>
                            <td class="px-4 py-3.5 text-right font-bold text-[#92591f]">Rp {{ $t['total'] }}</td>
                            <td class="px-4 py-3.5 text-center"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; {{ $t['status'] }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-10 text-center text-sm text-[#695b51]">Belum ada riwayat transaksi untuk nasabah ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <footer class="flex items-center justify-between px-6 py-4 text-xs text-[#695b51]">
            <span>Menampilkan {{ count($transactions) }} dari {{ count($transactions) }} total transaksi</span>
            <span>&lsaquo;&nbsp; <b class="rounded bg-[#92591f] px-3 py-2 text-white">1</b> &nbsp;&rsaquo;</span>
        </footer>
    </section>

    <div class="mt-6 rounded-lg bg-[#f1ead9] px-5 py-3 text-xs text-[#695b51]">
        <i class="bi bi-info-circle mr-1"></i> Data rekap ini diambil dari sistem pembukuan Bank Sampah SMKN 2 Cimahi. Terakhir diperbarui: {{ $stats['lastUpdated'] ?? '07 September 2026, 08:14 WIB' }}.
    </div>
</x-layouts.admin>
