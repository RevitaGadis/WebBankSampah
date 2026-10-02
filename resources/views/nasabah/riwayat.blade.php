<x-layouts.nasabah title="Riwayat Setoran" :student="$student">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold">Riwayat Setoran</h1>
            <p class="mt-1 max-w-2xl text-[#695b51]">Daftar seluruh setoran sampah yang telah kamu lakukan dan
                divalidasi oleh petugas sekolah.</p>
        </div>
        <div class="rounded-xl bg-[#f3eddd] px-5 py-3 text-sm"><small class="block">▱ Buku Besar Siswa</small><b>{{ $student['count'] }}
                Transaksi Valid</b></div>
    </div>
    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Akumulasi Bulan Ini" value="{{ $stats['monthlyWeight'] }}"
            description="{{ $stats['monthlyWeightDesc']}}" icon="bi-recycle" accent="#92591f" /><x-nasabah.stat-card
            label="Konversi Nilai Tabungan" value="{{ $stats['monthlyIncome'] }}" description="{{ $stats['monthlyIncomeDesc'] }}"
            icon="bi-wallet2" desc-icon="bi-wallet2" accent="#bdcaa8" />
        <article class="rounded-2xl bg-[#5a270f] p-6 text-white"><span class="ns-label !text-[#dfc5af]">STATUS
                REKENING</span><strong class="mt-4 block text-2xl">{{ $student['number'] }} / {{ $student['class']}}</strong>
            <p class="mt-2 text-sm text-[#e4c9b1]">Setoran terakhir tercatat pada {{ $student['last_deposit'] }}</p><b
                class="mt-5 block text-xs">Petugas Shift Aktif <span class="float-right">{{ $stats['activeOfficers'] }}</span></b>
        </article>
    </section>
    <section class="ns-card mt-8 grid gap-3 p-4 md:grid-cols-[1fr_1.1fr_.65fr]">
        <input data-admin-global-search data-search-target="[data-nasabah-riwayat-rows] tr" data-search-empty="[data-nasabah-riwayat-empty]"
            class="ns-input" placeholder="Cari nomor transaksi atau komoditas…">
        <button class="rounded-xl bg-[#f7f0df] px-4 text-left text-sm font-semibold">Semua Tanggal (Bulan Ini: {{ $stats['currentDate'] }})</button>
        <button class="rounded-xl bg-[#f7f0df] px-4 text-left text-sm font-semibold">Semua Jenis Sampah</button>
    </section>
    <section class="ns-card mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1050px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide text-[#695b51]">
                    <tr>
                        <th class="px-5 py-5">No. Transaksi</th>
                        <th>Tanggal & Waktu</th>
                        <th>Jenis Sampah</th>
                        <th class="text-right">Berat<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(kg)</small></th>
                        <th class="text-right">Harga / Kg<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                        <th class="text-right">Total Nilai<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                        <th>Petugas Validasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody data-nasabah-riwayat-rows>
                    @forelse ($transactions as $transaction)
                        <x-nasabah.transaction-row :transaction="$transaction" />
                    @empty
                        <tr data-page-ignore><td colspan="8" class="px-5 py-10 text-center text-sm text-[#695b51]">Belum ada setoran tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p data-nasabah-riwayat-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada setoran yang sesuai dengan pencarian.</p>
        <x-admin.table-pagination rows="[data-nasabah-riwayat-rows] tr" label="setoran" />
    </section>
    <x-nasabah.receipt-modal />
</x-layouts.nasabah>
