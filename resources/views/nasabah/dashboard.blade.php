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
            description="{{ $stats['totalDepositsDesc'] ?? 'transaksi terverifikasi' }}" symbol="▤" /><x-nasabah.stat-card label="Total Sampah Terpilah"
            value="{{ $stats['totalWeight'] ?? '24,5 Kg' }}" description="{{ $stats['totalWeightDesc'] ?? 'tereduksi dari TPA sekolah' }}" symbol="♻" /><x-nasabah.stat-card
            label="Pendapatan Akumulasi" value="Rp {{ $student['balance'] ?? '42.500' }}" description="{{ $stats['totalIncomeDesc'] ?? 'bebas potongan admin' }}" symbol="▱" /></section>
    <section class="ns-card mt-8 overflow-hidden">
        <div class="flex items-center justify-between p-6">
            <h2 class="text-2xl font-bold">▌ Setoran Terbaru</h2><a href="{{ route('nasabah.riwayat') }}"
                class="text-sm font-bold text-[#92591f]">Lihat Semua Riwayat →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th>Tanggal & Waktu</th>
                        <th>Jenis Sampah</th>
                        <th>Berat</th>
                        <th>Tarif / Kg</th>
                        <th>Total Kredit</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>@foreach(array_slice($transactions, 0, 3) as $transaction)<x-nasabah.transaction-row
                :transaction="$transaction" compact />@endforeach</tbody>
            </table>
        </div>
        <p class="border-t border-[#eee8dc] p-4 text-xs text-[#695b51]">♢ Menampilkan {{ min(count($transactions), 3) }} dari total {{ $student['count'] ?? '12' }} riwayat transaksi
            siswa</p>
    </section>
</x-layouts.nasabah>