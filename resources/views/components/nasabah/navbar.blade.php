@props(['student'])
<header
    class="sticky top-0 z-30 flex h-[72px] items-center justify-between border-b border-[#e6dec9] bg-[#fffaf0]/95 px-5 backdrop-blur lg:px-8">
    <div class="flex items-center gap-3"><button type="button" data-sidebar-open
            class="rounded-lg border border-[#e1d7c1] p-2 lg:hidden">☰</button><span
            class="grid size-8 place-items-center rounded-lg bg-[#54220f] text-sm text-white">♧</span><span><small
                class="block text-[10px] font-bold tracking-wide text-[#695b51]">SMK NEGERI HIJAU LESTARI</small><strong
                class="block text-lg leading-5">Portal Nasabah Siswa</strong></span></div><a
        href="{{ route('nasabah.profil') }}"
        class="flex items-center gap-2 rounded-full bg-[#f3eddd] px-3 py-2 text-sm font-semibold"><span
            class="grid size-7 place-items-center rounded-full bg-[#3c1809] text-white">♙</span>{{ $student['name'] }}</a>
</header>