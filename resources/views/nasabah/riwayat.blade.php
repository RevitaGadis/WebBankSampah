<x-layouts.nasabah title="Riwayat Setoran" :student="$student">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold">Riwayat Setoran</h1>
            <p class="mt-1 max-w-2xl text-[#695b51]">Daftar seluruh setoran sampah yang telah kamu lakukan dan
                divalidasi oleh petugas sekolah.</p>
        </div>
        <div class="rounded-xl bg-[#f3eddd] px-5 py-3 text-sm"><small class="block">▱ Buku Besar Siswa</small><b>{{ $student['count'] ?? '12' }}
                Transaksi Valid</b></div>
    </div>
    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Akumulasi Bulan Ini" value="{{ $stats['monthlyWeight'] ?? '7,5 Kg' }}"
            description="{{ $stats['monthlyWeightDesc'] ?? '3 setoran terkonfirmasi pada September 2026' }}" symbol="♧" /><x-nasabah.stat-card
            label="Konversi Nilai Tabungan" value="{{ $stats['monthlyIncome'] ?? 'Rp 18.500' }}" description="{{ $stats['monthlyIncomeDesc'] ?? 'Terkreditasi langsung ke saldo utama' }}"
            symbol="▣" />
        <article class="rounded-2xl bg-[#5a270f] p-6 text-white"><span class="ns-label !text-[#dfc5af]">STATUS
                REKENING</span><strong class="mt-4 block text-2xl">{{ $student['number'] ?? 'NS-003' }} / {{ $student['class'] ?? 'XII RPL B' }}</strong>
            <p class="mt-2 text-sm text-[#e4c9b1]">Setoran terakhir tercatat pada {{ $student['last_deposit'] ?? '07 Sep 2026' }}</p><b
                class="mt-5 block text-xs">Petugas Shift Aktif <span class="float-right">{{ $stats['activeOfficers'] ?? 'Andi & Ibu Sri' }}</span></b>
        </article>
    </section>
    <section class="ns-card mt-8 grid gap-3 p-4 md:grid-cols-[1fr_1.1fr_.65fr]"><input class="ns-input"
            placeholder="⌕  Cari nomor transaksi atau komoditas…"><button
            class="rounded-xl bg-[#f7f0df] px-4 text-left text-sm font-semibold">Semua Tanggal (Bulan Ini: September
            2026)　▣</button><button class="rounded-xl bg-[#f7f0df] px-4 text-left text-sm font-semibold">Semua Jenis
            Sampah　⌄</button></section>
    <section class="ns-card mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1050px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-5">No. Transaksi</th>
                        <th>Tanggal & Waktu</th>
                        <th>Jenis Sampah</th>
                        <th>Berat</th>
                        <th>Harga / Kg</th>
                        <th>Total Nilai</th>
                        <th>Petugas Validasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>@foreach($transactions as $transaction)<x-nasabah.transaction-row
                :transaction="$transaction" />@endforeach</tbody>
            </table>
        </div>
        <footer
            class="flex flex-wrap items-center justify-between gap-3 border-t border-[#eee8dc] p-5 text-xs text-[#695b51]">
            <span>Menampilkan 1 - {{ count($transactions) }} dari {{ $student['count'] ?? '12' }} setoran | Halaman 1 dari {{ $stats['totalPages'] ?? '2' }}</span><span class="space-x-2"><button disabled
                    class="rounded bg-[#f4f0e6] px-3 py-2">‹ Sebelumnya</button><button
                    class="rounded bg-[#955a25] px-3 py-2 text-white">1</button><button
                    class="rounded bg-[#f4f0e6] px-3 py-2">2</button><button
                    class="rounded bg-[#f4f0e6] px-3 py-2">Berikutnya ›</button></span></footer>
    </section>
    <x-nasabah.receipt-modal />
</x-layouts.nasabah>
