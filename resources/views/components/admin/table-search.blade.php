@props(['placeholder' => 'Cari data...', 'target', 'empty', 'icon' => true])

<label class="relative block w-full max-w-md">
    @if ($icon)
        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-[#7d6c60]"></i>
    @endif
    <input
        data-admin-global-search
        data-search-target="{{ $target }}"
        data-search-empty="{{ $empty }}"
        class="w-full rounded-lg bg-[#f8f1df] py-2.5 pr-3 text-sm outline-none {{ $icon ? 'pl-9' : 'pl-3' }}"
        placeholder="{{ $placeholder }}"
        aria-label="{{ $placeholder }}">
</label>
