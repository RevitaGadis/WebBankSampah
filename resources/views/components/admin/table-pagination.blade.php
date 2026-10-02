@props(['rows', 'label' => 'data', 'perPage' => 10])
<footer data-table-pagination data-rows="{{ $rows }}" data-label="{{ $label }}" data-per-page="{{ $perPage }}"
    class="flex flex-wrap items-center justify-between gap-3 border-t border-[#eee8dc] px-5 py-4 text-xs text-[#695b51] sm:px-6">
    <div class="flex flex-wrap items-center gap-3">
        <p data-pagination-summary class="font-mono">Menampilkan 0 &ndash; 0 dari 0 {{ $label }}</p>
        <label class="flex items-center gap-1.5">
            <span>Tampilkan</span>
            <select data-pagination-per-page aria-label="Jumlah baris per halaman"
                class="cursor-pointer rounded-lg border border-[#e2d7c0] bg-white px-2 py-1 font-mono text-xs font-bold text-[#3d2417]"></select>
            <span>baris</span>
        </label>
    </div>
    <nav data-pagination-nav aria-label="Navigasi halaman" class="flex flex-wrap items-center gap-1"></nav>
</footer>
