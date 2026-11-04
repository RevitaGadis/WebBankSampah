<x-layouts.nasabah title="Riwayat Setoran" :student="$student">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold">Riwayat Setoran</h1>
            <p class="mt-1 max-w-2xl text-[#695b51]">Daftar seluruh setoran sampah yang telah kamu lakukan dan
                divalidasi oleh petugas sekolah.</p>
        </div>
        <div class="rounded-xl bg-[#f3eddd] px-5 py-3 text-sm"><small class="block"><i class="bi bi-journal-text"></i>
                Buku Besar Siswa</small><b>{{ $student['count'] }}
                Transaksi Valid</b></div>
    </div>

    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Akumulasi Bulan Ini"
            value="{{ $stats['monthlyWeight'] }}" description="{{ $stats['monthlyWeightDesc'] }}" icon="bi-recycle"
            accent="#92591f" /><x-nasabah.stat-card label="Konversi Nilai Tabungan"
            value="{{ $stats['monthlyIncome'] }}" description="{{ $stats['monthlyIncomeDesc'] }}" icon="bi-wallet2"
            desc-icon="bi-wallet2" accent="#bdcaa8" />
        <article class="rounded-2xl bg-[#5a270f] p-6 text-white"><span class="ns-label !text-[#dfc5af]">STATUS
                REKENING</span><strong class="mt-4 block text-2xl">{{ $student['number'] }} /
                {{ $student['class'] }}</strong>
            <p class="mt-2 text-sm text-[#e4c9b1]">Setoran terakhir tercatat pada {{ $student['last_deposit'] }}</p><b
                class="mt-5 block text-xs">Petugas Shift Aktif <span
                    class="float-right">{{ $stats['activeOfficers'] }}</span></b>
        </article>
    </section>

    {{-- Pencarian --}}
    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5">
            <label class="relative block w-full max-w-md">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-[#7d6c60]"></i>
                <input type="search" id="nasabah-riwayat-search" autocomplete="off"
                    placeholder="Cari transaksi, tanggal, jenis sampah, atau petugas..."
                    class="w-full rounded-lg bg-[#f8f1df] py-2.5 pl-9 pr-3 text-sm outline-none focus:ring-2 focus:ring-[#92591f]">
            </label>
        </div>
    </section>

    {{-- Tabel --}}
    <section class="ns-card mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1050px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide text-[#695b51]">
                    <tr>
                        <th class="px-5 py-5">No. Transaksi</th>
                        <th>Tanggal & Waktu</th>
                        <th>Jenis Sampah</th>
                        <th class="text-right">Berat<small
                                class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(kg)</small>
                        </th>
                        <th class="text-right">Harga / Kg<small
                                class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small>
                        </th>
                        <th class="text-right">Total Nilai<small
                                class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small>
                        </th>
                        <th>Petugas Validasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody data-nasabah-riwayat-rows>
                    @forelse ($transactions as $transaction)
                        <x-nasabah.transaction-row :transaction="$transaction" />
                    @empty
                        <tr data-page-ignore>
                            <td colspan="8" class="px-5 py-10 text-center text-sm text-[#695b51]">Belum ada setoran
                                tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <p data-nasabah-riwayat-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada setoran yang
            sesuai dengan pencarian.</p>

        {{-- Pagination --}}
        <div
            class="flex flex-wrap items-center justify-between gap-3 border-t border-[#eadfc9] px-5 py-4 text-sm text-[#695b51]">
            <span data-nasabah-riwayat-info></span>
            <div class="flex gap-2">
                <button type="button" data-nasabah-riwayat-prev
                    class="rounded-lg border border-[#d8cfc0] px-4 py-2 disabled:opacity-40">Sebelumnya</button>
                <button type="button" data-nasabah-riwayat-next
                    class="rounded-lg border border-[#d8cfc0] px-4 py-2 disabled:opacity-40">Berikutnya</button>
            </div>
        </div>
    </section>

    <x-nasabah.receipt-modal />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const PER_PAGE = 10;
            const input = document.getElementById('nasabah-riwayat-search');
            const tbody = document.querySelector('[data-nasabah-riwayat-rows]');
            const emptyMsg = document.querySelector('[data-nasabah-riwayat-empty]');
            const info = document.querySelector('[data-nasabah-riwayat-info]');
            const prev = document.querySelector('[data-nasabah-riwayat-prev]');
            const next = document.querySelector('[data-nasabah-riwayat-next]');
            if (!input || !tbody) return;

            const rows = [...tbody.querySelectorAll('tr:not([data-page-ignore])')];
            const normalize = s => s.toLowerCase().replace(/\s+/g, ' ').trim();
            const index = rows.map(r => normalize(r.textContent));

            let filtered = rows.slice();
            let page = 1;

            function render() {
                const pages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
                page = Math.min(Math.max(page, 1), pages);
                const start = (page - 1) * PER_PAGE;
                const visible = new Set(filtered.slice(start, start + PER_PAGE));

                rows.forEach(r => {
                    r.style.display = visible.has(r) ? '' : 'none';
                });

                const searching = input.value.trim() !== '';
                emptyMsg?.classList.toggle('hidden', !(searching && filtered.length === 0));

                if (info) {
                    info.textContent = filtered.length ?
                        `Menampilkan ${start + 1}–${Math.min(start + PER_PAGE, filtered.length)} dari ${filtered.length} setoran` :
                        'Tidak ada setoran';
                }
                if (prev) prev.disabled = page <= 1;
                if (next) next.disabled = page >= pages;
            }

            input.addEventListener('input', () => {
                const q = normalize(input.value);
                filtered = q ? rows.filter((_, i) => index[i].includes(q)) : rows.slice();
                page = 1;
                render();
            });
            prev?.addEventListener('click', () => {
                page--;
                render();
            });
            next?.addEventListener('click', () => {
                page++;
                render();
            });

            render();
        });
    </script>
</x-layouts.nasabah>
