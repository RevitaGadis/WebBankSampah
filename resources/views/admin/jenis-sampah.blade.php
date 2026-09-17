<x-layouts.admin title="Jenis Sampah" :admin="$admin">
    @php
        $specifications = [
            'K-01' => 'PET bening, tutup botol & botol mineral bersih',
            'K-02' => 'Karton gelombang cokelat, kemasan kering & terikat',
            'K-03' => 'Buku tulis, kertas dokumen putih, majalah bebas staples',
            'K-04' => 'Botol kecap, sirup, saus tanpa retak dan sudah dibilas',
            'K-05' => 'Kaleng soft drink, piring seng lembaran, panci aluminium',
            'K-06' => 'Minyak goreng jelantah jernih disaring, wadah jerigen tertutup',
        ];
    @endphp

    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
        <div><p class="text-xs font-semibold text-[#92591f]">Beranda &nbsp;&rsaquo;&nbsp; Jenis Sampah</p><h1 class="mt-2 max-w-xl text-4xl font-bold leading-tight">Kelola Jenis Sampah &amp; Tarif Komoditas</h1><p class="mt-1 max-w-2xl text-[#695b51]">Atur katalog komoditas daur ulang yang diterima, perbarui tarif acuan beli per satuan.</p></div>
        <div class="flex flex-wrap gap-3"><button type="button" class="rounded-lg bg-[#f4ecd7] px-4 py-3 text-sm font-bold">Download Katalog SK (PDF)</button><button type="button" data-admin-waste-open="add" class="rounded-lg bg-[#92591f] px-4 py-3 text-sm font-bold text-white">+ Tambah Jenis Sampah</button></div>
    </div>

    <section class="mt-8 grid gap-4 md:grid-cols-3">
        <article class="ns-card border-t-4 border-[#92591f] p-6"><span class="ns-label">Total Kategori Aktif</span><strong class="mt-6 block text-3xl">{{ $stats['totalCategories'] ?? '6' }}<br>Komoditas</strong><small class="mt-2 block text-[#695b51]">&bull; {{ $stats['activeCategoriesDesc'] ?? '100% aktif di loket piket harian' }}</small></article>
        <article class="ns-card border-t-4 border-[#bdcaa8] p-6"><span class="ns-label">Tarif Rata-Rata</span><strong class="mt-7 block text-3xl">Rp {{ $stats['avgPrice'] ?? '3.160' }} <small class="text-base font-normal">/ Kg</small></strong><small class="mt-1 block text-[#695b51]">{{ $stats['avgPriceDesc'] ?? 'Penyesuaian SK 01 Sep 2026' }}</small></article>
        <article class="ns-card border-t-4 border-[#ffb980] p-6"><span class="ns-label">Komoditas Tertinggi</span><strong class="mt-7 block text-2xl">Rp {{ $stats['highestPrice'] ?? '6.000' }} <small class="text-base font-normal">/ Kg</small></strong><small class="mt-1 block font-semibold text-[#92591f]">{{ $stats['highestPriceItem'] ?? 'Kaleng & Aluminium' }}</small></article>
    </section>

    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5">
            <x-admin.table-search placeholder="Cari jenis sampah, tarif..." target="[data-admin-waste-rows] tr" empty="[data-admin-waste-empty]" />
        </div>
    </section>

    <section class="mt-4 overflow-hidden rounded-2xl bg-[#fffaf0] shadow-[0_12px_28px_rgba(75,40,13,.08)]">
        <header class="flex items-center justify-between bg-[#f8f1df] px-6 py-4"><h2 class="text-xl font-bold">Katalog Tarif &amp; Buku Mutasi Komoditas</h2><span class="rounded bg-[#eee8d7] px-3 py-1 text-xs font-semibold">{{ count($waste) }} Komoditas Terdaftar</span></header>
        <div class="overflow-x-auto"><table class="w-full min-w-[920px] table-fixed text-sm"><thead class="bg-[#fffaf0] text-left text-[10px] uppercase tracking-wide text-[#695b51]"><tr><th class="w-[5%] px-3 py-3 text-center">No</th><th class="w-[43%] px-4 py-3">Komoditas &amp; Spesifikasi</th><th class="w-[10%] px-3 py-3 text-center">Satuan</th><th class="w-[13%] px-3 py-3 text-right">Tarif Beli Acuan</th><th class="w-[12%] px-3 py-3 text-center">Timbangan Bln Ini</th><th class="w-[9%] px-3 py-3 text-center">Status</th><th class="w-[8%] px-3 py-3 text-center">Aksi</th></tr></thead><tbody data-admin-waste-rows>
            @foreach($waste as $i => $w)
                <tr data-search="{{ strtolower($w['code'].' '.$w['name'].' '.$w['price'].' '.$w['unit']) }}" class="border-t border-[#f0eadf] even:bg-[#fffdf8]"><td class="px-3 py-3.5 text-center">{{ $i + 1 }}</td><td class="px-4 py-3.5"><b class="block truncate"><span class="mr-1 rounded bg-[#f4ecd7] px-1.5 py-0.5 font-mono text-xs">{{ $w['code'] }}</span> {{ $w['name'] }}</b><small class="mt-0.5 block truncate text-[#695b51]">{{ $specifications[$w['code']] ?? '' }}</small></td><td class="px-3 py-3.5 text-center"><span class="rounded-full bg-[#f4ecd7] px-2 py-1 text-xs font-bold">/ {{ $w['unit'] }}</span></td><td class="px-3 py-3.5 text-right font-mono font-bold">Rp {{ $w['price'] }}</td><td class="px-3 py-3.5 text-center font-mono text-xs">{{ $w['month'] }} {{ $w['unit'] }}</td><td class="px-3 py-3.5 text-center"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; Aktif</span></td><td class="whitespace-nowrap px-3 py-3.5 text-center"><button type="button" title="Detail komoditas" aria-label="Detail {{ $w['name'] }}" data-admin-waste-open="detail" data-id="{{ $w['id'] }}" data-code="{{ $w['code'] }}" data-name="{{ $w['name'] }}" data-price="{{ $w['price'] }}" data-unit="{{ $w['unit'] }}" data-month="{{ $w['month'] }}" data-specification="{{ $specifications[$w['code']] ?? '' }}" class="inline-flex h-7 w-7 items-center justify-center rounded-md text-[#92591f] hover:bg-[#f4ecd7]"><i class="bi bi-eye"></i></button><button type="button" title="Ubah komoditas" aria-label="Ubah {{ $w['name'] }}" data-admin-waste-open="edit" data-id="{{ $w['id'] }}" data-code="{{ $w['code'] }}" data-name="{{ $w['name'] }}" data-price="{{ $w['price'] }}" data-unit="{{ $w['unit'] }}" data-month="{{ $w['month'] }}" data-specification="{{ $specifications[$w['code']] ?? '' }}" class="inline-flex h-7 w-7 items-center justify-center rounded-md text-[#92591f] hover:bg-[#f4ecd7]"><i class="bi bi-pencil"></i></button><button type="button" title="Hapus komoditas" aria-label="Hapus {{ $w['name'] }}" data-admin-waste-open="delete" data-id="{{ $w['id'] }}" data-code="{{ $w['code'] }}" data-name="{{ $w['name'] }}" data-price="{{ $w['price'] }}" data-unit="{{ $w['unit'] }}" data-month="{{ $w['month'] }}" data-specification="{{ $specifications[$w['code']] ?? '' }}" class="inline-flex h-7 w-7 items-center justify-center rounded-md text-red-600 hover:bg-red-50"><i class="bi bi-trash"></i></button></td></tr>
            @endforeach
        </tbody></table></div>
        <p data-admin-waste-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada komoditas yang sesuai dengan pencarian.</p>
        <footer class="flex items-center justify-between px-6 py-4 text-xs text-[#695b51]"><span>Menampilkan {{ count($waste) }} dari {{ $stats['totalCategories'] ?? count($waste) }} komoditas aktif &bull; Pembaruan terakhir oleh {{ $stats['lastUpdatedBy'] ?? 'Ibu Sri Wahyuni' }}</span><span>‹ Sebelumnya &nbsp;&nbsp; <b>1</b> &nbsp;&nbsp; Berikutnya ›</span></footer>
    </section>

    

{{-- Modal Tambah --}}
<div data-admin-waste-modal="add" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/80 p-4">
    <section role="dialog" aria-modal="true" class="w-full max-w-sm overflow-hidden rounded-xl bg-white shadow-2xl">
        <form method="POST" action="{{ route('admin.jenis-sampah.store') }}" class="p-6">
            @csrf
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-bold leading-tight">Formulir<br>Komoditas</h2>
                    <p class="text-xs text-[#92591f]">Mode: Tambah Data Baru</p>
                </div>
            </div>
            <div class="mt-5 space-y-3">
                <label class="block text-xs font-bold">Nama Jenis Sampah <span class="text-red-600">*</span>
                    <input type="text" name="nama_jenis" required class="mt-1 w-full rounded-lg bg-[#f8f1df] px-3 py-2.5 text-sm" placeholder="Contoh: Plastik Kresek / Kantong Bening">
                </label>
                <label class="block text-xs font-bold">Tarif Pembelian Resmi (per Kg) <span class="text-red-600">*</span>
                    <div class="mt-1 flex rounded-lg bg-[#f8f1df] px-3 py-2.5">
                        <b class="mr-3 text-sm">Rp</b>
                        <input type="number" name="harga_per_kg" min="0" step="0.01" required class="min-w-0 flex-1 bg-transparent text-sm outline-none">
                    </div>
                </label>
            </div>
            @if($errors->any())
                <div class="mt-3 rounded-lg bg-red-50 p-3 text-xs text-red-700">{{ $errors->first() }}</div>
            @endif
            <div class="mt-5 flex items-center justify-end gap-2">
                <button type="button" data-admin-waste-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button>
                <button type="submit" class="rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white">Simpan Komoditas</button>
            </div>
        </form>
    </section>
</div>

{{-- Modal Edit --}}
<div data-admin-waste-modal="edit" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/80 p-4">
    <section role="dialog" aria-modal="true" class="w-full max-w-sm overflow-hidden rounded-xl bg-white shadow-2xl">
        <form method="POST" action="" id="form-edit-waste" class="p-6">
            @csrf
            @method('PUT')
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-bold">Formulir Komoditas</h2>
                    <p class="text-xs text-[#92591f]">Mode: Perbarui Data</p>
                    <span data-aw-code class="mt-1 inline-block rounded bg-[#dce9c9] px-2 py-1 text-xs font-mono"></span>
                </div>
                <button type="button" data-admin-waste-close class="text-xl text-[#695b51]">&times;</button>
            </div>
            <div class="mt-5 space-y-3">
                <label class="block text-xs font-bold">Nama Jenis Sampah <span class="text-red-600">*</span>
                    <input type="text" name="nama_jenis" data-aw-input-name required class="mt-1 w-full rounded-lg bg-[#f8f1df] px-3 py-2.5 text-sm">
                </label>
                <label class="block text-xs font-bold">Tarif Pembelian Resmi (per Kg) <span class="text-red-600">*</span>
                    <div class="mt-1 flex rounded-lg bg-[#f8f1df] px-3 py-2.5">
                        <b class="mr-3 text-sm">Rp</b>
                        <input type="number" name="harga_per_kg" data-aw-input-price min="0" step="0.01" required class="min-w-0 flex-1 bg-transparent text-sm outline-none">
                    </div>
                </label>
            </div>
            <div class="mt-5 flex items-center justify-end gap-2">
                <button type="button" data-admin-waste-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button>
                <button type="submit" class="rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white">Simpan Komoditas</button>
            </div>
        </form>
    </section>
</div>

{{-- Modal Detail (biarin sama persis kayak sebelumnya, gak perlu diubah, cuma display doang) --}}
<div data-admin-waste-modal="detail" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/80 p-4"><section role="dialog" aria-modal="true" class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"><header class="flex items-start justify-between bg-[#fcf3dd] px-5 py-4"><div><h2 class="text-xl font-bold">Detail Komoditas</h2><p class="text-xs text-[#695b51]">Informasi tarif dan spesifikasi komoditas</p></div><button type="button" data-admin-waste-close class="text-xl text-[#695b51]">&times;</button></header><div class="space-y-4 p-5"><section class="rounded-xl bg-[#fff9ea] p-4"><span data-aw-code class="rounded bg-[#dce9c9] px-2 py-1 text-xs font-mono"></span><b data-aw-name class="mt-3 block text-lg"></b></section><div class="grid grid-cols-2 gap-3"><div class="rounded-lg border p-3"><small class="text-[#695b51]">Tarif Beli Acuan</small><b class="mt-1 block">Rp <span data-aw-price></span></b></div><div class="rounded-lg border p-3"><small class="text-[#695b51]">Satuan Timbang</small><b data-aw-unit class="mt-1 block"></b></div><div class="rounded-lg border p-3"><small class="text-[#695b51]">Timbangan Bulan Ini</small><b class="mt-1 block"><span data-aw-month></span> <span data-aw-unit></span></b></div><div class="rounded-lg border p-3"><small class="text-[#695b51]">Status</small><b class="mt-1 block text-[#587332]">&bull; Aktif</b></div></div></div><footer class="flex justify-end gap-2 border-t bg-[#fcf3dd] px-5 py-3"><button type="button" data-admin-waste-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Tutup</button><button type="button" data-admin-waste-open="edit" class="rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white">Ubah Komoditas</button></footer></section></div>

{{-- Modal Hapus --}}
<div data-admin-waste-modal="delete" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/80 p-4">
    <section role="dialog" aria-modal="true" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <header class="flex gap-3">
            <span class="grid h-12 w-12 place-items-center rounded-2xl bg-red-100 text-xl text-red-700"><i class="bi bi-exclamation-triangle"></i></span>
            <div>
                <small class="font-bold text-[#92591f]">PERINGATAN SISTEM</small>
                <h2 class="text-xl font-bold">Hapus Komoditas <span data-aw-code></span>?</h2>
            </div>
        </header>
        <div class="mt-4 rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-4 text-sm text-[#695b51]">
            Tindakan ini tidak dapat dibatalkan. Kalau komoditas <b data-aw-name class="text-[#3d2417]"></b> masih punya riwayat transaksi, sistem akan menolak penghapusan otomatis.
        </div>
        <form method="POST" action="" id="form-delete-waste" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full rounded-lg bg-[#54220f] py-3 text-sm font-bold text-white">Tetap Hapus</button>
        </form>
        <button type="button" data-admin-waste-close class="mt-2 w-full rounded-lg bg-[#f2ebdb] py-3 text-sm font-bold">Batal</button>
    </section>
</div>

</x-layouts.admin>