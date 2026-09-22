<x-layouts.admin title="Dashboard Admin" :admin="$admin">
    <section class="rounded-2xl bg-[#f5edda] p-6 lg:p-7">
        <span class="text-xs font-bold">{{ $stats['currentDate'] }}</span>
        <div class="mt-3"><h1 class="text-3xl font-bold">Dashboard Pengelola</h1><p class="mt-1 text-[#695b51]">Selamat datang kembali, {{ $admin['name'] }} &bull; Panel pengelolaan bank sampah sekolah.</p></div>
    </section>
    <section class="mt-3 grid gap-4 md:grid-cols-3">
        <x-nasabah.stat-card label="Transaksi Pekan Ini" value="{{ $stats['totalTransactions'] ?? '128' }}" description="{{ $stats['totalTransactionsDesc'] ?? '19 slip tercatat hari ini' }}"/><x-nasabah.stat-card label="Berat Terpilah" value="{{ $stats['totalWeight'] ?? '356.5 Kg' }}" description="{{ $stats['totalWeightDesc'] ?? 'Dari 4 zona pilah gedung sekolah' }}"/><x-nasabah.stat-card label="Total Kas & Saldo" value="{{ $stats['totalBalance'] ?? 'Rp 1.250.000' }}" description="{{ $stats['totalBalanceDesc'] ?? 'Dana tabungan aktif nasabah' }}"/>
    </section>
    <section class="ns-card mt-6 p-6">
        <h2 class="text-xl font-bold">Komposisi Sampah Terpilah Pekan Ini</h2><p class="text-sm text-[#695b51]">Distribusi perolehan material daur ulang terakumulasi</p>
        <div class="mt-5 flex h-4 overflow-hidden rounded-full"><span class="w-[{{ $stats['wasteComposition'][0]['percentage'] ?? '40' }}%] bg-[#48200e]"></span><span class="w-[{{ $stats['wasteComposition'][1]['percentage'] ?? '32' }}%] bg-[#955a25]"></span><span class="w-[{{ $stats['wasteComposition'][2]['percentage'] ?? '17' }}%] bg-[#bdcaa8]"></span><span class="w-[{{ $stats['wasteComposition'][3]['percentage'] ?? '11' }}%] bg-[#ddd8c5]"></span></div>
        <div class="mt-5 grid gap-3 sm:grid-cols-2"><div class="rounded-xl bg-[#fcf3dd] p-4"><b>{{ $stats['wasteComposition'][0]['name'] ?? 'Plastik Daur Ulang' }}</b><span class="float-right">{{ $stats['wasteComposition'][0]['weight'] ?? '142.5 Kg' }}</span></div><div class="rounded-xl bg-[#fcf3dd] p-4"><b>{{ $stats['wasteComposition'][1]['name'] ?? 'Kardus & Box Tebal' }}</b><span class="float-right">{{ $stats['wasteComposition'][1]['weight'] ?? '115.0 Kg' }}</span></div></div>
    </section>
    <section class="ns-card mt-6 overflow-hidden">
        <div class="p-5">
            <x-admin.table-search placeholder="Cari ID, nasabah, kelas..." target="[data-admin-dashboard-rows] tr" empty="[data-admin-dashboard-empty]" />
        </div>
        <div class="overflow-x-auto"><table class="w-full min-w-[950px] text-sm"><thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide"><tr><th class="px-5 py-4">ID Transaksi</th><th class="px-4 py-4">Waktu &amp; Tanggal</th><th class="px-4 py-4">Nasabah &amp; Kelas</th><th class="px-4 py-4">Kategori Sampah</th><th class="px-4 py-4 text-right">Berat</th><th class="px-4 py-4 text-right">Tarif/Kg</th><th class="px-4 py-4 text-right">Total Nilai</th><th class="px-4 py-4">Petugas Validasi</th><th class="px-5 py-4 text-center">Aksi</th></tr></thead><tbody data-admin-dashboard-rows>
            @foreach($transactions as $t)
                <tr data-search="{{ strtolower($t['id'].' '.$t['name'].' '.$t['class'].' '.$t['jenis'].' '.$t['officer']) }}" data-category="{{ $t['jenis'] }}" class="border-b border-[#f0eadf]"><td class="px-5 py-5 font-bold text-[#713b18]">{{ $t['id'] }}</td><td class="px-4 py-5">{{ $t['date'] }}<small class="mt-1 block">{{ $t['time'] }}</small></td><td class="px-4 py-5"><b class="block">{{ $t['name'] }}</b><small class="mt-1 block">{{ $t['class'] }}</small></td><td class="px-4 py-5"><span class="inline-block rounded-full bg-[#f4ecd7] px-3 py-1.5 text-xs font-semibold">{{ $t['jenis'] }}</span></td><td class="px-4 py-5 text-right font-bold">{{ $t['weight'] }} Kg</td><td class="px-4 py-5 text-right">Rp {{ $t['price'] }}</td><td class="px-4 py-5 text-right font-bold text-[#92591f]">Rp {{ $t['total'] }}</td><td class="px-4 py-5">{{ $t['officer'] }}</td><td class="px-5 py-5 text-center"><button type="button" aria-label="Lihat detail transaksi {{ $t['id'] }}" title="Lihat detail transaksi" data-admin-transaction-open data-id="{{ $t['id'] }}" data-date="{{ $t['date'] }}" data-time="{{ $t['time'] }}" data-name="{{ $t['name'] }}" data-number="{{ $t['number'] }}" data-class="{{ $t['class'] }}" data-jenis="{{ $t['jenis'] }}" data-weight="{{ $t['weight'] }}" data-price="{{ $t['price'] }}" data-total="{{ $t['total'] }}" data-officer="{{ $t['officer'] }}" data-phone="{{ $t['phone'] ?? '-' }}" data-balance-before="{{ $t['balance_before'] ?? '' }}" data-balance-after="{{ $t['balance_after'] ?? '' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-[#f4ecd7] text-sm font-bold text-[#713b18]"><i class="bi bi-eye"></i></button></td></tr>
            @endforeach
        </tbody></table></div>
        <p data-admin-dashboard-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada transaksi yang sesuai dengan pencarian.</p>
    </section>
    <div data-admin-transaction-modal class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-3 sm:p-5">
        <section role="dialog" aria-modal="true" aria-labelledby="admin-transaction-title" class="max-h-[calc(100vh-1.5rem)] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl sm:max-h-[calc(100vh-2.5rem)]">
            <header class="flex items-start justify-between bg-[#fcf3dd] px-5 py-4 sm:px-6">
                <div class="flex items-start gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#f4ecd7] text-lg text-[#92591f]"><i class="bi bi-receipt"></i></span>
                    <div>
                        <div class="flex items-center gap-2"><h2 id="admin-transaction-title" class="text-lg font-bold">Detail Transaksi Setoran</h2><span class="flex items-center gap-1 rounded-full bg-[#dce9c9] px-2 py-0.5 text-[10px] font-bold text-[#3d2417]"><i class="bi bi-check-circle-fill"></i> Sukses / Terverifikasi</span></div>
                        <p class="mt-0.5 text-xs text-[#695b51]">Rincian bukti penerimaan sampah dan kredit saldo nasabah</p>
                    </div>
                </div>
                <button type="button" aria-label="Tutup modal" data-admin-transaction-close class="flex h-7 w-7 items-center justify-center rounded-lg text-lg text-[#695b51] hover:bg-[#f4ecd7]">&times;</button>
            </header>
            <div class="space-y-3 p-4 sm:p-5">
                <section class="grid gap-x-4 gap-y-2 rounded-xl bg-[#fcf7e9] p-4 text-[11px] sm:grid-cols-4">
                    <div><span class="font-bold uppercase text-[#695b51]">ID Setoran (PK)</span><b data-at-id class="mt-0.5 block text-sm text-[#92591f]"></b></div>
                        <div><span class="font-bold uppercase text-[#695b51]">No. Slip / Transaksi</span><b class="mt-0.5 block text-sm text-[#3d2417]" data-at-id-slip></b></div>
                    <div><span class="font-bold uppercase text-[#695b51]">Waktu Setor</span><b class="mt-0.5 block text-xs text-[#3d2417]"><span data-at-date></span>, <span data-at-time></span></b></div>
                    <div><span class="font-bold uppercase text-[#695b51]">Petugas Validasi</span><b class="mt-0.5 block text-xs text-[#3d2417]"><span data-at-officer></span> (Loket 1)</b></div>
                </section>
                <section class="flex items-center justify-between rounded-xl border border-[#eee3cf] px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#54220f] text-xs font-bold text-white" data-at-initial></span>
                        <div>
                            <div class="flex items-center gap-2"><b data-at-name class="text-sm"></b><span class="rounded bg-[#f4ecd7] px-1.5 py-0.5 text-[10px]">Siswa Aktif</span></div>
                            <small class="mt-0.5 block text-xs text-[#695b51]"><i class="bi bi-mortarboard"></i> <span data-at-class></span> &bull; <i class="bi bi-phone"></i> <span data-at-phone></span></small>
                        </div>
                    </div>
                    <div class="text-right text-[11px] text-[#695b51]">Petugas Loket<b class="mt-0.5 block text-xs text-[#3d2417]"><span data-at-officer></span></b></div>
                </section>
                <section class="overflow-hidden rounded-xl border border-[#eee3cf]">
                    <h3 class="flex items-center gap-1.5 bg-[#f8f1df] px-4 py-2.5 text-xs font-bold"><i class="bi bi-recycle"></i> Item Penimbangan Sampah</h3>
                    <div class="p-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                            <div class="flex items-start gap-3 sm:flex-1">
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#dce9c9] text-sm text-[#587332]"><i class="bi bi-recycle"></i></span>
                                <div><b data-at-jenis class="block text-sm"></b><small class="text-[11px] text-[#695b51]">Kategori: <span data-at-jenis></span> &bull; Grade A</small><small class="mt-0.5 block text-[11px] italic text-[#695b51]">Catatan: Kondisi botol bersih &amp; kering tanpa tutup segel.</small></div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-right sm:w-[52%] sm:gap-6">
                                <div><span class="block text-[11px] text-[#695b51]">Berat</span><b class="mt-1 block"><span data-at-weight></span> <small class="font-normal">Kg</small></b></div>
                                <div><span class="block text-[11px] text-[#695b51]">Tarif / Kg</span><b class="mt-1 block">Rp <span data-at-price></span></b></div>
                                <div><span class="block text-[11px] text-[#695b51]">Subtotal</span><b class="mt-1 block text-[#92591f]">Rp <span data-at-total></span></b></div>
                            </div>
                        </div>
                        <div class="mt-4 rounded-lg bg-[#fff4ec] px-4 py-3 text-xs">
                            <div class="flex items-center justify-between"><span class="text-[#695b51]">Saldo Sebelum Setor</span><span class="font-medium">Rp <span data-at-balance-before></span></span></div>
                            <div class="mt-1 flex items-center justify-between"><b><i class="bi bi-plus-circle text-[#587332]"></i> Kredit Masuk (+)</b><b class="text-[#92591f]">+ Rp <span data-at-total-copy></span></b></div>
                            <div class="mt-2 border-t border-[#ebd7c5] pt-2"><div class="flex items-center justify-between"><b class="text-sm">TOTAL SALDO AKHIR</b><b class="text-base text-[#3d2417]">Rp <span data-at-balance-after></span></b></div></div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="flex items-center justify-between border-t border-[#eee3cf] bg-[#fcf7e9] px-5 py-3 sm:px-6">
                <small class="flex items-center gap-1.5 text-[10px] text-[#695b51]"><i class="bi bi-printer"></i> Format struk mendukung printer thermal 58/80mm &amp; A4</small>
                <div class="flex gap-2"><button type="button" data-admin-transaction-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Tutup</button><button type="button" onclick="window.print()" class="flex items-center gap-1.5 rounded-lg bg-[#f4ecd7] px-4 py-2 text-xs font-bold text-[#713b18]"><i class="bi bi-download"></i> Unduh PDF</button></div>
            </footer>
        </section>
    </div>
</x-layouts.admin>
