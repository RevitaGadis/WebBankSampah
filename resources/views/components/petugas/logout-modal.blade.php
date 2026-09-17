@props(['officer'])
<div data-petugas-logout-modal class="fixed inset-0 z-[70] hidden items-center justify-center bg-[#1c0b04]/60 p-4">
    <section class="w-full max-w-md rounded-2xl bg-white p-7 text-center shadow-2xl"><span
            class="mx-auto grid size-14 place-items-center rounded-full bg-[#fbecdf] text-2xl text-[#8c4f20]">↪</span>
        <h2 class="mt-4 text-2xl font-bold">Keluar dari Sistem?</h2>
        <p class="mt-2 text-sm text-[#695b51]">Sesi petugas akan diakhiri. Pastikan seluruh pencatatan setoran sudah
            tersimpan.</p>
        <div class="mt-5 rounded-xl bg-[#fcf3dd] p-4 text-left"><b
                class="block">{{ $officer['name'] }}</b><small>{{ $officer['role'] }} • Unit SMK Hijau</small></div>
        <div class="mt-5 grid grid-cols-2 gap-3"><button data-petugas-logout-close
                class="rounded-lg bg-[#eee6d2] py-3 text-sm font-bold">Batal</button>
            <form method="POST" action="{{ route('petugas.logout') }}">@csrf<button
                    class="w-full rounded-lg bg-[#481805] py-3 text-sm font-bold text-white">Ya, Keluar</button></form>
        </div>
    </section>
</div>