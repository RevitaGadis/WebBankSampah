<x-layouts.nasabah title="Profil Nasabah" :student="$student">
    <h1 class="text-4xl font-bold">Profil Nasabah</h1>
    <p class="mt-1 max-w-xs text-[#695b51]">Informasi identitas akun nasabah terdaftar di SMKN 2 Cimahi.</p>
    <section class="mt-8 grid gap-8 xl:grid-cols-[290px_1fr]">
        <article class="ns-card overflow-hidden text-center">
            <div class="h-28 bg-[#5a270f]"></div><span
                class="-mt-12 mx-auto grid size-24 place-items-center rounded-full border-4 border-white bg-[#d2ae83] text-3xl font-bold text-white">BS</span>
            <h2 class="mt-4 text-2xl font-bold">{{ $student['name'] }}</h2>
            <p class="font-mono text-sm">ID: {{ $student['number'] }}</p><b
                class="mt-4 inline-block rounded-full bg-[#dce9c9] px-3 py-1 text-xs">● Nasabah (Siswa Aktif)</b>
            <div class="m-7 grid grid-cols-1 gap-3 text-left"><div class="rounded-xl bg-[#fcf3dd] p-4"><small class="ns-label">Buku
                        Tabungan</small><b class="block text-xl">Rp {{ $student['balance'] ?? '42.500' }}</b><small>Terkunci di Kas</small></div><div class="rounded-xl bg-[#fcf3dd] p-4"><small class="ns-label">Total Penyetoran</small><b
                        class="block text-xl">{{ $student['total_weight'] ?? '18.4 Kg' }}</b><small>Daur Ulang Tertimbang</small></div></div>
        </article>
        <div class="space-y-6">
            <article class="ns-card p-8">
                <h2 class="text-2xl font-bold">Informasi Akun Lengkap</h2>
                <p class="text-sm text-[#695b51]">Detail data pokok nasabah terverifikasi buku kas induk.</p>
                <div class="mt-8 grid gap-5 md:grid-cols-2">
                    @foreach([['Nama Lengkap', $student['name']], ['Nomor Nasabah', $student['number']], ['Kelas / Jurusan', $student['class']], ['Nomor Handphone / WhatsApp', $student['phone']], ['Username Login', $student['username']], ['Peran Akun', 'Nasabah Siswa']] as [$label, $value])
                        <div><span class="ns-label">{{ $label }}</span>
                            <div class="mt-1 rounded-lg bg-[#fcf3dd] px-4 py-3 text-sm font-medium">{{ $value }}</div>
                    </div>@endforeach
                </div>
                <div class="mt-8 rounded-xl bg-[#fcf3dd] p-5 text-sm leading-6"><b>⬟ &nbsp; Catatan Keamanan</b>
                    <p class="mt-1 pl-6 text-[#695b51]">Nomor nasabah, riwayat transaksi, saldo tabungan (Rp {{ $student['balance'] ?? '42.500' }}),
                        dan peran akun dikunci oleh sistem administrasi sekolah demi integritas data buku kas.</p>
                </div><button data-logout-open
                    class="mt-8 float-right rounded-lg bg-[#54220f] px-5 py-3 text-sm font-bold text-white">↪ Keluar
                    dari Akun</button>
                <div class="clear-both"></div>
            </article>
            <article class="ns-card p-6">
                <h2 class="text-xl font-bold">◴ Aktivitas Terakhir</h2>
                <div class="mt-4 rounded-xl bg-[#fcf8ee] p-4"><b>♻ &nbsp; {{ $student['last_activity_desc'] ?? 'Penyetoran 2.5 Kg Plastik PET' }}</b>
                    <p class="ml-6 mt-1 text-sm text-[#695b51]">{{ $student['last_activity_time'] ?? 'Konfirmasi Loket A • Kemarin, 13:40 WIB' }}</p>
                </div>
            </article>
        </div>
    </section>
</x-layouts.nasabah>
