<x-layouts.admin title="Rekap Nasabah - {{ $student['name'] ?? 'Nasabah' }}" :admin="$admin">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold text-[#92591f]"><a href="{{ route('admin.nasabah') }}" class="hover:underline">Nasabah</a> &rsaquo; Rekap Lengkap</p>
            <div class="mt-2 flex flex-wrap items-center gap-3">
                <h1 class="text-3xl font-bold">Detail Data Nasabah</h1>
                <b class="rounded bg-[#ffdcca] px-3 py-1 font-mono text-xs">{{ $student['number'] ?? '-' }}</b>
                <span class="rounded-full bg-[#dce9c9] px-3 py-1 text-xs font-bold text-[#3d2417]">&bull; {{ $student['status'] ?? 'Aktif' }}</span>
            </div>
            <p class="mt-1 text-[#695b51]">Informasi rekening buku tabungan, identitas siswa, dan statistik penimbangan terverifikasi.</p>
        </div>
        <div class="flex gap-3"><button type="button" class="rounded-lg border border-[#d8c5a8] bg-white px-4 py-3 text-sm font-bold"><i class="bi bi-printer mr-1"></i> Cetak</button><button type="button" class="rounded-lg bg-[#92591f] px-4 py-3 text-sm font-bold text-white"><i class="bi bi-download mr-1"></i> Unduh PDF</button></div>
    </div>

    <section class="mt-6 flex items-center gap-4 rounded-xl border border-[#e5dcc8] bg-[#fcf3dd] p-5">
        <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-[#54220f] text-lg font-bold text-white">{{ $student['initial'] ?? strtoupper(substr($student['name'] ?? 'U', 0, 2)) }}</span>
        <div>
            <div class="flex flex-wrap items-center gap-2"><b class="text-lg">{{ $student['name'] ?? '-' }}</b><span class="rounded bg-[#e9e4d4] px-2 py-1 text-xs">{{ str_contains($student['class'] ?? '', 'Guru') ? 'Guru' : 'Siswa' }}</span></div>
            <small class="mt-0.5 block text-[#92591f]">{{ $student['class'] ?? '-' }}</small>
            <small class="mt-1 block font-mono">{{ $student['phone'] ?? '-' }}</small>
        </div>
    </section>

    <h2 class="mt-6 text-sm font-bold text-[#92591f]">DATA REKENING &amp; ATRIBUT ENTITAS</h2>
    <section class="mt-3 grid gap-3 sm:grid-cols-3">
        <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">ID_NASABAH</small><b class="block">#{{ $student['id'] ?? '-' }}</b></div>
        <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">NO_NASABAH</small><b class="block font-mono">{{ $student['number'] ?? '-' }}</b></div>
        <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">NAMA_LENGKAP</small><b class="block">{{ $student['name'] ?? '-' }}</b></div>
        <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">TINGKAT_KELAS</small><b class="block">{{ $student['class'] ?? '-' }}</b></div>
        <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">KONTAK_WA</small><b class="block font-mono">{{ $student['phone'] ?? '-' }}</b></div>
        <div class="rounded-lg border border-[#ece5d8] bg-white p-4"><small class="ns-label">STATUS_SYNC_KAS</small><b class="block">&bull; Real-time Kas</b></div>
    </section>

    <h2 class="mt-6 text-sm font-bold text-[#92591f]">RINGKASAN STATISTIK SAMPAH &amp; FINANSIAL</h2>
    <section class="mt-3 grid gap-4 md:grid-cols-4">
        <x-nasabah.stat-card label="Saldo Tabungan"
            value="Rp {{ number_format((int) str_replace('.', '', $student['balance'] ?? '0'), 0, ',', '.') }}"
            description="Buku Kas Aktif" icon="bi-wallet2" desc-icon="bi-wallet2" accent="#92591f" />
        <x-nasabah.stat-card label="Total Sampah Ditimbang" value="{{ $student['total_weight'] ?? '0' }}" unit="Kg"
            description="Tereduksi" icon="bi-recycle" desc-icon="bi-recycle" accent="#bdcaa8" />
        <x-nasabah.stat-card label="Frekuensi Setor" value="{{ $student['count'] ?? '0' }}" unit="Kali"
            description="Transaksi" icon="bi-arrow-repeat" desc-icon="bi-arrow-repeat" accent="#ffb980" />
        <x-nasabah.stat-card label="Timbang Terakhir" value="{{ $student['last_deposit'] ?? '-' }}"
            description="{{ $student['last_deposit_item'] ?? '-' }}" icon="bi-clock-history"
            desc-icon="bi-clock-history" accent="#dce9c9" />
    </section>

    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-sm font-bold text-[#92591f]">RIWAYAT SETORAN TERAKHIR</h2>
        <span class="rounded bg-[#eee8d7] px-3 py-1 text-xs font-semibold">{{ count($transactions) }} Transaksi</span>
    </div>
    <section class="ns-card mt-3 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide text-[#695b51]">
                    <tr>
                        <th class="w-[6%] px-4 py-3 text-center">No</th>
                        <th class="w-[14%] px-4 py-3">ID Transaksi</th>
                        <th class="w-[16%] px-4 py-3">Tanggal &amp; Waktu</th>
                        <th class="w-[24%] px-4 py-3">Kategori Sampah</th>
                        <th class="w-[10%] px-4 py-3 text-right">Berat<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(kg)</small></th>
                        <th class="w-[12%] px-4 py-3 text-right">Harga / Kg<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                        <th class="w-[12%] px-4 py-3 text-right">Total Nilai<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                        <th class="w-[10%] px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody data-admin-rekap-rows>
                    @forelse($transactions as $i => $t)
                        <tr data-search="{{ strtolower($t['id'].' '.$t['jenis'].' '.$t['status']) }}" class="border-t border-[#f0eadf] even:bg-[#fffdf8] last:border-0">
                            <td class="px-4 py-3.5 text-center font-mono">{{ $i + 1 }}</td>
                            <td class="px-4 py-3.5 font-mono text-xs font-bold text-[#92591f]">{{ $t['id'] }}</td>
                            <td class="px-4 py-3.5">{{ $t['date'] }}<small class="mt-0.5 block text-[#695b51]">{{ $t['time'] }}</small></td>
                            <td class="px-4 py-3.5"><span class="rounded-full bg-[#f4ecd7] px-2.5 py-1 text-xs font-semibold">{{ $t['jenis'] }}</span></td>
                            <td class="px-4 py-3.5 text-right font-mono font-bold">{{ $t['weight'] }}</td>
                            <td class="px-4 py-3.5 text-right font-mono">{{ $t['price'] }}</td>
                            <td class="px-4 py-3.5 text-right font-mono font-bold text-[#92591f]">{{ $t['total'] }}</td>
                            <td class="px-4 py-3.5 text-center"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; {{ $t['status'] }}</span></td>
                        </tr>
                    @empty
                        <tr data-page-ignore><td colspan="8" class="px-4 py-10 text-center text-sm text-[#695b51]">Belum ada riwayat transaksi untuk nasabah ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-admin.table-pagination rows="[data-admin-rekap-rows] tr" label="transaksi" />
    </section>

    <footer class="mt-8 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-[#e5dcc8] bg-[#fcf3dd] p-5">
        <p class="text-xs text-[#695b51]"><i class="bi bi-info-circle mr-1"></i> Data pembukuan Bank Sampah SMKN 2 Cimahi. Terakhir diperbarui: {{ $stats['lastUpdated'] ?? '-' }}.</p>
        <a href="{{ route('admin.nasabah') }}" class="rounded-lg border border-[#d8c5a8] bg-white px-4 py-2 text-sm font-bold">Kembali ke daftar nasabah</a>
    </footer>
</x-layouts.admin>
