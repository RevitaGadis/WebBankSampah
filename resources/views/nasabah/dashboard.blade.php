<x-layouts.nasabah title="Dashboard" :student="$student">
    <div class="mb-8"><span class="rounded-full bg-[#dce9c9] px-3 py-1 text-[11px] font-bold">● Nasabah Aktif • Kelas
            {{ $student['class'] }} • {{ $student['number'] }}</span>
        <h1 class="mt-3 text-4xl font-bold tracking-tight">Selamat datang, {{ $student['name'] }}</h1>
        <p class="mt-1 text-[#695b51]">Pantau saldo dan riwayat setoran sampah kamu di SMKN 2 Cimahi.</p>
    </div>
    <section class="relative overflow-hidden rounded-2xl bg-[#5a270f] p-8 text-[#fff8ed] shadow-xl">
        <div class="absolute -right-12 -bottom-24 size-80 rounded-full bg-[#75401f]"></div><span
            class="ns-label !text-[#ddc5b0]">▣ &nbsp; SALDO SAYA SAAT INI</span>
        <div class="mt-4 flex flex-wrap items-center gap-4"><strong class="text-5xl">Rp
                {{ $student['balance'] }}</strong><span class="rounded bg-white/15 px-2 py-1 text-xs">↑ {{ $student['last_change'] ?? '+ Rp 7.500' }}</span></div>
        <p class="mt-2 max-w-xs text-sm text-[#e4c9b1]">Tercatat di buku kas digital Bank Sampah • Penambahan terakhir:
            {{ $student['last_change_desc'] ?? '+Rp 7.500 (07 Sep 2026)' }}</p>
        <div class="absolute right-8 top-8 hidden rounded-xl bg-[#431806] px-5 py-3 text-sm lg:block"><small
                class="block text-[#dfc5af]">BUKU TABUNGAN</small>{{ $student['book_number'] ?? 'Reg. 042-SMK-2026' }}</div>
    </section>
    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Total Setoran" value="{{ $student['count'] ?? '12' }}"
            description="{{ $stats['totalDepositsDesc'] ?? 'transaksi terverifikasi' }}" icon="bi-receipt" accent="#92591f" /><x-nasabah.stat-card label="Total Sampah Terpilah"
            value="{{ $stats['totalWeight'] ?? '24,5 Kg' }}" description="{{ $stats['totalWeightDesc'] ?? 'tereduksi dari TPA sekolah' }}" icon="bi-recycle" accent="#bdcaa8" /><x-nasabah.stat-card
            label="Pendapatan Akumulasi" value="Rp {{ $student['balance'] ?? '42.500' }}" description="{{ $stats['totalIncomeDesc'] ?? 'bebas potongan admin' }}" icon="bi-wallet2" desc-icon="bi-wallet2" accent="#ffb980" /></section>
    <section class="ns-card mt-8 overflow-hidden">
        <div class="flex items-center justify-between p-6">
            <h2 class="text-2xl font-bold">▌ Setoran Terbaru</h2><a href="{{ route('nasabah.riwayat') }}"
                class="text-sm font-bold text-[#92591f]">Lihat Semua Riwayat →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide text-[#695b51]">
                    <tr>
                        <th class="px-5 py-4">No. Transaksi</th>
                        <th>Tanggal & Waktu</th>
                        <th>Jenis Sampah</th>
                        <th class="text-right">Berat<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(kg)</small></th>
                        <th class="text-right">Tarif / Kg<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                        <th class="text-right">Total Kredit<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody data-nasabah-dashboard-rows>@forelse($transactions as $transaction)<x-nasabah.transaction-row
                    :transaction="$transaction" compact />@empty<tr data-page-ignore><td colspan="7"
                        class="px-5 py-10 text-center text-sm text-[#695b51]">Belum ada setoran sampah.</td></tr>@endforelse</tbody>
            </table>
        </div>
        <x-admin.table-pagination rows="[data-nasabah-dashboard-rows] tr" label="setoran" :per-page="5" />
    </section>
</x-layouts.nasabah>