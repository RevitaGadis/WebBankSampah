@props(['admin'])

<aside
    id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-40 flex w-[268px] -translate-x-full flex-col bg-[#54220f] px-5 py-7 text-white transition-transform lg:translate-x-0"
>
    {{-- Logo --}}
    <a
        href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 border-b border-white/10 pb-6"
    >
        <span class="grid size-9 place-items-center rounded-xl bg-[#70401e]">
            <i class="bi bi-recycle"></i>
        </span>

        <span>
            <strong class="block text-lg leading-5">Bank Sampah</strong>
            <small class="text-[10px] font-semibold uppercase text-[#d8bba4]">
                SMKN 2 Cimahi
            </small>
        </span>
    </a>

    {{-- Menu --}}
    <p class="mt-5 text-[10px] font-bold tracking-wider text-[#c29f87]">
        MENU UTAMA
    </p>

    <nav class="mt-3 space-y-1">
        <a
            href="{{ route('admin.dashboard') }}"
            class="ns-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            <i class="bi bi-grid"></i>
            Dashboard
        </a>

        <a
            href="{{ route('admin.nasabah') }}"
            class="ns-nav-link {{ request()->routeIs('admin.nasabah') ? 'active' : '' }}"
        >
            <i class="bi bi-people"></i>
            Nasabah
        </a>

        <a
            href="{{ route('admin.jenis-sampah') }}"
            class="ns-nav-link {{ request()->routeIs('admin.jenis-sampah') ? 'active' : '' }}"
        >
            <i class="bi bi-recycle"></i>
            Jenis Sampah
        </a>

        <a
            href="{{ route('admin.akun') }}"
            class="ns-nav-link {{ request()->routeIs('admin.akun') ? 'active' : '' }}"
        >
            <i class="bi bi-person"></i>
            Akun
        </a>

        <a
            href="{{ route('admin.riwayat') }}"
            class="ns-nav-link {{ request()->routeIs('admin.riwayat') ? 'active' : '' }}"
        >
            <i class="bi bi-receipt"></i>
            Riwayat Transaksi
        </a>
    </nav>

    {{-- Admin Account --}}
    <div class="mt-auto rounded-xl border border-white/10 bg-[#421807] p-3">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-full bg-[#9a5d26] font-bold">
                {{ strtoupper(substr($admin['name'], 0, 2)) }}
            </span>

            <span>
                <strong class="block text-sm">
                    {{ $admin['name'] }}
                </strong>

                <small class="text-[11px] text-[#d8bba4]">
                    {{ $admin['role'] }}
                </small>
            </span>
        </div>

        <form
            method="POST"
            action="{{ route('admin.logout') }}"
        >
            @csrf

            <button
                type="submit"
                class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg bg-white/10 py-2.5 text-sm font-semibold transition hover:bg-white/20"
            >
                <i class="bi bi-box-arrow-right"></i>
                Keluar
            </button>
        </form>
    </div>
</aside>