<x-layouts.nasabah title="Saldo Tabungan" :student="$student"><span class="ns-label text-[#92591f]">BUKU TABUNGAN
        DIGITAL</span>
    <h1 class="mt-1 text-4xl font-bold">Saldo Saya</h1>
    <p class="mt-1 text-[#695b51]">Pantau akumulasi saldo buku tabungan sampah dan ringkasan mutasi kredit kamu secara
        transparan dan berkala.</p>
    <div class="mt-8 rounded-xl bg-[#dce9c9] p-5 font-semibold">♧ &nbsp; Saldo bertambah otomatis setiap kali setoran
        sampahmu berhasil ditimbang dan dicatat oleh petugas loket Bank Sampah.</div>
    <section class="relative mt-8 overflow-hidden rounded-2xl bg-[#5a270f] p-12 text-white">
        <div class="absolute -right-10 -top-20 size-64 rounded-full bg-[#75401f]"></div><span
            class="ns-label !text-[#e5c9b0]">● TOTAL SALDO AKTIF SAAT INI</span><strong class="mt-4 block text-4xl">Rp
            {{ $student['balance'] }} <small class="text-sm font-normal text-[#e4c9b1]">IDR</small></strong>
        <p class="mt-5 text-sm">▣ {{ $student['number'] }}　•　Atas Nama: {{ $student['name'] }}</p>
    </section>
    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Total Transaksi" value="{{ $student['count'] ?? '12 Transaksi' }}"
            description="{{ $stats['totalTransactionsDesc'] ?? 'Setoran sampah terverifikasi' }}" /><x-nasabah.stat-card label="Berat Sampah Terkumpul"
            value="{{ $stats['totalWeight'] ?? '24,5 Kg' }}" description="{{ $stats['totalWeightDesc'] ?? 'Terkonversi ke circular economy' }}" /><x-nasabah.stat-card
            label="Total Pendapatan" value="Rp {{ $student['balance'] ?? '42.500' }}" description="{{ $stats['totalIncomeDesc'] ?? 'Kumulatif kredit masuk aktif' }}" /></section>
    <section class="ns-card mt-8 p-7">
        <div class="flex justify-between">
            <div>
                <h2 class="text-2xl font-bold">Riwayat Aktivitas Saldo & Kredit Masuk</h2>
                <p class="text-sm text-[#695b51]">Daftar transaksi penambahan nilai kredit tabungan dari setiap loket
                </p>
            </div><b class="self-center rounded-full bg-[#f4ecd7] px-4 py-2 text-xs text-[#92591f]">Terbaru: {{ $stats['lastDepositDate'] ?? '07 Sep 2026' }}</b>
        </div>
        <div class="mt-8 space-y-5 border-l-2 border-[#e7dcc4] pl-8">
            @foreach(array_slice($transactions, 0, 4) as $transaction)
                <article class="relative rounded-xl bg-[#fcf8ee] p-4"><span
                        class="absolute -left-[54px] top-5 grid size-10 place-items-center rounded-full bg-[#955a25] text-xl text-white">+</span><span
                        class="text-xs">{{ $transaction['date'] }} • {{ $transaction['time'] }}　 <b
                            class="rounded bg-[#dce9c9] px-2">{{ $transaction['jenis'] }}</b></span><strong
                        class="mt-1 block text-lg">Setoran {{ $transaction['jenis'] }} ({{ $transaction['weight'] }}
                        Kg)</strong><small>♙ Petugas: {{ $transaction['officer'] }} (Loket Penimbangan 1)</small>
                    <div class="absolute right-4 top-8 text-right font-bold text-[#92591f]">+ Rp
                        {{ $transaction['total'] }}<small class="block font-normal text-[#695b51]">Saldo akhir: Rp
                            {{ $transaction['balance'] }}</small></div>
            </article>@endforeach
        </div><a href="{{ route('nasabah.riwayat') }}"
            class="mt-8 block text-right text-sm font-bold text-[#92591f]">Lihat Semua →</a>
    </section>
</x-layouts.nasabah>
