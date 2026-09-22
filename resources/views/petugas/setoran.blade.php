<x-layouts.petugas title="Setoran" :officer="$officer">
    <section class="rounded-2xl bg-[#f5edda] p-6"><span class="rounded-full bg-[#ece4d2] px-3 py-1 text-xs font-bold">▣
            {{ $stats['currentDate'] }}</span>
        <div class="mt-3 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">Setoran</h1>
                <p class="text-[#695b51]">Panel operasional timbang dan tabungan bank sampah sekolah hari ini.</p>
            </div><button data-setoran-open class="rounded-lg bg-[#92591f] px-6 py-3 text-sm font-bold text-white">⊕ +
                Tambah Setoran Baru</button>
        </div>
    </section>
    <section class="ns-card mt-4 p-6">
        <div class="flex justify-between">
            <div>
                <h2 class="text-xl font-bold">Komposisi Sampah Terpilah Hari Ini</h2>
                <p class="text-sm text-[#695b51]">Distribusi perolehan material daur ulang terakumulasi</p>
            </div><b class="self-center rounded-full bg-[#f4ecd7] px-3 py-1 text-xs">Total {{ $stats['todayWeight'] ?? '297.2 Kg' }}</b>
        </div>
        <div class="mt-5 flex h-4 overflow-hidden rounded-full"><span class="w-[40%] bg-[#48200e]"></span><span
                class="w-[32%] bg-[#955a25]"></span><span class="w-[17%] bg-[#bdcaa8]"></span><span
                class="w-[11%] bg-[#ddd8c5]"></span></div>
        <div class="mt-5 grid gap-3 sm:grid-cols-2">@foreach(array_slice($waste, 0, 4) as $item)
            <div class="rounded-xl bg-[#fcf3dd] p-4"><b>{{ $item['name'] }}</b><span
                    class="float-right font-bold">{{ $item['month'] }} Kg</span><small
                    class="block text-[#695b51]">Tarif Rp {{ $item['price'] }} / {{ $item['unit'] }}</small></div>
        @endforeach
        </div>
    </section>
    <section class="ns-card mt-4 overflow-hidden">
        <div class="p-5">
            <x-admin.table-search placeholder="Cari ID, nasabah, kelas..." target="[data-admin-setoran-rows] tr" empty="[data-admin-setoran-empty]" />
        </div>
        <div class="overflow-x-auto"><x-petugas.transaction-table :transactions="$transactions" /></div>
        <p data-admin-setoran-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada transaksi yang sesuai dengan pencarian.</p>
    </section><x-petugas.setoran-modal :waste="$waste" /><x-petugas.transaction-modal />
</x-layouts.petugas>
