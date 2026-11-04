@props(['officer'])
<header class="sticky top-0 z-30 flex h-[88px] items-center justify-between border-b border-[#eee5d1] bg-[#fffaf0]/95 px-5 backdrop-blur lg:px-6">
    <div class="flex items-center gap-5">
        <button data-petugas-sidebar-open aria-label="Buka menu" class="rounded-lg border p-2 lg:hidden"><i class="bi bi-list"></i></button>
        <span class="grid size-8 place-items-center rounded-lg bg-[#54220f] text-sm text-white"><i class="bi bi-recycle"></i></span>
        <span class="hidden text-sm text-[#695b51] sm:block">Sistem Informasi Bank Sampah　›</span>
    </div>
    <div class="text-right text-sm"><b class="block">{{ $officer['name'] }}</b><small>{{ $officer['role'] }}</small></div>
</header>
