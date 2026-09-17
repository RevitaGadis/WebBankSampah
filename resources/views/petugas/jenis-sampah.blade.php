<x-layouts.petugas title="Jenis Sampah" :officer="$officer">
    <div class="flex flex-wrap justify-between gap-4">
        <div><h1 class="text-4xl font-bold">Kelola Jenis Sampah & Tarif Komoditas</h1><p class="mt-1 max-w-2xl text-[#695b51]">Atur katalog komoditas daur ulang yang diterima, perbarui tarif acuan beli per satuan.</p></div>
        <button type="button" class="rounded-lg bg-[#f4ecd7] px-4 py-3 text-sm font-bold">Download Katalog SK (PDF)</button>
    </div>
    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5">
            <x-admin.table-search placeholder="Cari jenis sampah, tarif..." target="[data-admin-waste-rows] tr" empty="[data-admin-waste-empty]" />
        </div>
    </section>
    <section class="ns-card mt-4 overflow-hidden">
        <header class="flex items-center justify-between bg-[#f8f1df] px-6 py-4"><h2 class="text-xl font-bold">Katalog Tarif & Buku Mutasi Komoditas</h2><span class="rounded bg-[#eee8d7] px-3 py-1 text-xs font-semibold">{{ count($waste) }} Komoditas Terdaftar</span></header>
        <div class="overflow-x-auto"><table class="w-full min-w-[850px] text-sm"><thead class="bg-[#fffaf0] text-left text-[10px] uppercase tracking-wide text-[#695b51]"><tr><th class="w-[5%] px-4 py-3 text-center">No</th><th class="w-[43%] px-4 py-3">Komoditas & Spesifikasi</th><th class="w-[10%] px-3 py-3 text-center">Satuan</th><th class="w-[13%] px-3 py-3 text-right">Tarif Beli Acuan</th><th class="w-[12%] px-3 py-3 text-center">Timbangan Bln Ini</th><th class="w-[9%] px-3 py-3 text-center">Status</th></tr></thead><tbody data-admin-waste-rows>
            @foreach($waste as $i=>$item)
                <tr data-search="{{ strtolower($item['code'].' '.$item['name'].' '.$item['price'].' '.$item['unit']) }}" class="border-t border-[#f0eadf] even:bg-[#fffdf8]"><td class="px-4 py-3.5 text-center">{{ $i+1 }}</td><td class="px-4 py-3.5"><b class="block truncate"><span class="mr-1 rounded bg-[#f4ecd7] px-1.5 py-0.5 font-mono text-xs">{{ $item['code'] }}</span> {{ $item['name'] }}</b><small class="mt-0.5 block truncate text-[#695b51]">{{ $item['detail'] ?? '' }}</small></td><td class="px-3 py-3.5 text-center"><span class="rounded-full bg-[#f4ecd7] px-2 py-1 text-xs font-bold">/ {{ $item['unit'] }}</span></td><td class="px-3 py-3.5 text-right font-mono font-bold">Rp {{ $item['price'] }}</td><td class="px-3 py-3.5 text-center font-mono text-xs">{{ $item['month'] }} {{ $item['unit'] }}</td><td class="px-3 py-3.5 text-center"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; Aktif</span></td></tr>
            @endforeach
        </tbody></table></div>
        <p data-admin-waste-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada komoditas yang sesuai dengan pencarian.</p>
        <footer class="flex items-center justify-between px-6 py-4 text-xs text-[#695b51]"><span>Menampilkan {{ count($waste) }} dari {{ count($waste) }} komoditas aktif</span><span>‹ Sebelumnya &nbsp;&nbsp; <b>1</b> &nbsp;&nbsp; Berikutnya ›</span></footer>
    </section>
</x-layouts.petugas>
