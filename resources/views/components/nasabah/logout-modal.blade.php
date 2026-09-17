@props(['student'])
<div data-logout-modal class="fixed inset-0 z-[60] hidden items-center justify-center bg-[#1c0b04]/50 p-4">
    <section class="w-full max-w-lg rounded-2xl bg-white p-7 text-center shadow-2xl" role="dialog" aria-modal="true"
        aria-labelledby="logout-title"><span
            class="mx-auto grid size-14 place-items-center rounded-full bg-[#fbecdf] text-2xl text-[#8c4f20]">↪</span>
        <h2 id="logout-title" class="mt-4 text-2xl font-bold">Keluar dari Portal Nasabah?</h2>
        <p class="mt-1 text-sm leading-6 text-[#68584e]">Apakah kamu yakin ingin mengakhiri sesi akun ini? Kamu perlu
            memasukkan username dan kata sandi kembali untuk masuk.</p>
        <div class="mt-5 flex items-center gap-3 rounded-xl bg-[#fcf3dd] p-4 text-left"><span
                class="grid size-11 place-items-center rounded-full bg-[#955a25] font-bold text-white">BS</span><span><strong
                    class="block">{{ $student['name'] }}</strong><small class="font-semibold text-[#67584d]">Nomor
                    Induk: {{ $student['number'] }} • {{ $student['class'] }}</small></span><b
                class="ml-auto rounded-full bg-[#dce9c9] px-2 py-1 text-[10px]">Aktif</b></div>
        <p class="mt-3 rounded-lg bg-[#f3eddd] p-3 text-left text-xs leading-5">♢ Semua perubahan profil dan riwayat
            setoran telah tersimpan aman di server sekolah.</p>
        <div class="mt-4 grid grid-cols-2 gap-3"><button type="button" data-logout-close
                class="rounded-lg bg-[#eee6d2] py-2.5 text-sm font-bold">Batal</button>
            <form method="POST" action="{{ route('nasabah.logout') }}">@csrf<button
                    class="w-full rounded-lg bg-[#481805] py-2.5 text-sm font-bold text-white">↪ Ya, Keluar
                    Akun</button></form>
        </div>
    </section>
</div>