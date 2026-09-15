<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Bank Sampah Sekolah</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#faf6ea]">
    <header class="flex h-[74px] items-center border-b border-[#e4dcc7] bg-white px-8"><span
            class="grid size-10 place-items-center rounded-xl bg-[#54220f] text-white">♧</span><span
            class="ml-3"><strong class="block text-lg leading-5">Bank Sampah Sekolah</strong><small
                class="text-[#92591f]">SMKN 2 Cimahi • Unit Mandiri</small></span></header>
    <main class="px-4 py-8 lg:px-8">
        <section
            class="mx-auto grid max-w-7xl overflow-hidden rounded-[22px] border border-[#ded6c3] bg-white shadow-[0_14px_32px_rgba(76,44,19,.08)] lg:grid-cols-[40%_60%]">
            <div class="relative min-h-[500px] overflow-hidden bg-[#54220f] p-10 text-[#fff8ed] lg:p-12">
                <div class="absolute -right-20 -top-20 size-64 rounded-full border border-white/15"></div>
                <div class="absolute -left-12 bottom-28 size-64 rounded-full border border-white/10"></div>
                <h1 class="relative max-w-sm text-4xl font-bold leading-[1.1]">Kelola Sampah,<br>Tumbuhkan Tabungan.
                </h1>
                <p class="relative mt-14 max-w-sm text-sm leading-6 text-[#e0c7b2]">Platform tata kelola timbang sampah
                    terpadu untuk menanamkan literasi sirkular ekonomi dan tabungan masa depan warga SMK Negeri Hijau
                    Lestari.</p>
                <div class="relative mt-16 space-y-4">
                    <div class="rounded-2xl border border-white/15 bg-[#6b351a] p-4"><b class="block text-sm">◉ &nbsp;
                            Penimbangan Terverifikasi ISO</b><small class="ml-6 block text-[#d9b9a0]">Timbangan digital
                            langsung terhubung ke mutasi buku tabungan.</small></div>
                    <div class="rounded-2xl border border-white/15 bg-[#6b351a] p-4"><b class="block text-sm">◉ &nbsp;
                            Kompensasi Transparan Real-Time</b><small class="ml-6 block text-[#d9b9a0]">Total Rp
                            dihitung otomatis (Berat × Tarif acuan resmi per kg).</small></div>
                </div>
                <div
                    class="absolute bottom-6 left-9 right-9 flex justify-between border-t border-white/15 pt-6 text-xs text-[#d8bba4]">
                    <span>Versi Sistem 2.4.0–PROD</span><span>SMKN 2 Cimahi © 2026</span></div>
            </div>
            <div class="flex items-center justify-center p-8 lg:p-16">
                <form class="w-full max-w-md" onsubmit="return false">
                    <h2 class="text-center text-3xl font-bold">Masuk ke Sistem</h2>
                    <div
                        class="mt-12 rounded-xl border border-[#e1d8c2] bg-[#f8f4e8] p-4 text-xs font-semibold leading-4">
                        ◉ &nbsp; Akses Operasional: Digunakan oleh petugas piket, koordinator bank sampah, dan
                        administrator sekolah.</div><label class="ns-label mt-7 block">Username</label><input
                        class="ns-input mt-2" value="budi.santoso" name="username" autocomplete="username">
                    <div class="mt-4 flex justify-between"><label class="ns-label">Kata Sandi</label><a href="#"
                            class="text-xs text-[#92591f]">Lupa Kata Sandi?</a></div>
                    <div class="relative mt-2"><input id="password" class="ns-input pr-12" type="password"
                            value="BankSampah2026!" name="password" autocomplete="current-password"><button
                            data-password-toggle type="button"
                            class="absolute inset-y-0 right-3 text-[#92591f]">◉</button></div><a
                        href="{{ route('nasabah.dashboard') }}"
                        class="mt-4 block rounded-xl bg-[#a66a35] py-3 text-center text-sm font-bold text-white shadow-md">Masuk
                        ke Sistem &nbsp; →</a>
                    <hr class="my-6 border-[#eee7d8]">
                    <div class="rounded-xl border border-[#e5ddca] bg-[#faf7ed] p-4 text-xs leading-5"><b>● &nbsp; Belum
                            memiliki akun nasabah?</b><br><span class="ml-5">Buku tabungan dan akses akun digital
                            diterbitkan di ruang piket Bank Sampah Gedung C oleh pengurus sekolah.</span></div>
                </form>
            </div>
        </section>
    </main>
    <footer class="bg-[#54220f] px-8 py-4 text-xs text-[#f5e8db]">© 2026 Bank Sampah SMKN 2 Cimahi. Seluruh
        hak cipta dilindungi.</footer>
    <script>document.querySelector('[data-password-toggle]').onclick = () => { const e = document.querySelector('#password'); e.type = e.type === 'password' ? 'text' : 'password' }</script>
</body>

</html>