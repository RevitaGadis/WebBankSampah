@props(['admin'])
<header class="sticky top-0 z-30 flex h-[88px] items-center justify-between border-b border-[#eee5d1] bg-[#fffaf0]/95 px-5 backdrop-blur lg:px-6">
    <div class="flex items-center gap-3">
        <span class="grid size-8 place-items-center rounded-lg bg-[#54220f] text-sm text-white"><i class="bi bi-recycle"></i></span>
        <span class="text-sm text-[#695b51]">Sistem Informasi Bank Sampah　›</span>
    </div>
    <div class="text-right text-sm"><b class="block">{{ $admin['name'] }}</b><small>{{ $admin['role'] }}</small></div>
</header>
