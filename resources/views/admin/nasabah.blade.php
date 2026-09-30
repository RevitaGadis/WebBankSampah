<x-layouts.admin title="Data Nasabah" :admin="$admin">
    <div class="flex flex-wrap justify-between gap-4">
        <div><h1 class="text-4xl font-bold">Data Nasabah Bank Sampah</h1><p class="mt-1 max-w-2xl text-[#695b51]">Kelola data nasabah siswa dan guru aktif, informasi saldo tabungan, dan mutasi setoran sirkular sekolah.</p></div>
        <div class="flex gap-3"><button type="button" data-admin-nasabah-open="add" class="rounded-lg bg-[#92591f] px-4 py-3 text-sm font-bold text-white">+ Tambah Nasabah Baru</button></div>
    </div>

    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Siswa Terdaftar" value="{{ $stats['totalStudents'] ?? '228' }}" description="{{ $stats['totalStudentsDesc'] ?? '93% partisipasi per kelas kejuruan' }}"/><x-nasabah.stat-card label="Pendidik & Tenaga Kerja" value="{{ $stats['totalTeachers'] ?? '17' }}" description="{{ $stats['totalTeachersDesc'] ?? 'Nasabah Teladan' }}"/><x-nasabah.stat-card label="Total Saldo Terkumpul" value="{{ $stats['totalBalance'] ?? 'Rp 4.850.000' }}" description="{{ $stats['totalBalanceDesc'] ?? 'Tercatat di Buku Induk' }}"/></section>

    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5"><x-admin.table-search placeholder="Cari nama, no. nasabah, kelas..." target="[data-admin-nasabah-rows] tr" empty="[data-admin-nasabah-empty]" /></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[920px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide"><tr><th class="w-10 px-4 py-4">No</th><th class="px-3 py-4">No Nasabah</th><th class="px-3 py-4">Nama Lengkap</th><th class="px-3 py-4">Kelas</th><th class="px-3 py-4">Nomor WhatsApp</th><th class="px-3 py-4 text-center">Total Setor</th><th class="px-3 py-4 text-right">Saldo Tabungan</th><th class="px-3 py-4">Status</th><th class="px-4 py-4 text-center">Aksi</th></tr></thead>
                <tbody data-admin-nasabah-rows>
                    @foreach($students as $i => $s)
                        <tr data-search="{{ strtolower($s['name'].' '.$s['number'].' '.$s['class'].' '.$s['phone']) }}" data-class="{{ $s['class'] }}" class="border-b border-[#f0eadf] last:border-0">
                            <td class="px-4 py-4">{{ $i + 1 }}</td>
                            <td class="px-3 py-4 font-mono text-xs font-bold text-[#92591f]">{{ $s['number'] }}</td>
                            <td class="px-3 py-4"><b class="block">{{ $s['name'] }}</b><small class="text-[#695b51]">Nasabah {{ str_contains($s['class'], 'Guru') ? 'Guru' : 'Siswa' }}</small></td>
                            <td class="px-3 py-4"><span class="rounded bg-[#eee8d7] px-2 py-1 text-xs font-medium">{{ $s['class'] }}</span></td>
                            <td class="px-3 py-4 font-mono text-xs">{{ $s['phone'] }}</td>
                            <td class="px-3 py-4 text-center"><span class="rounded-full bg-[#f8f1df] px-2.5 py-1 text-xs">{{ $s['count'] }} Kali</span></td>
                            <td class="px-3 py-4 text-right font-bold">Rp {{ $s['balance'] }}</td>
                            <td class="px-3 py-4"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; {{ $s['status'] }}</span></td>
                            <td class="whitespace-nowrap px-4 py-4 text-center">
                                <button type="button" title="Detail nasabah" data-admin-nasabah-open="detail" data-id="{{ $s['id'] }}" data-name="{{ $s['name'] }}" data-number="{{ $s['number'] }}" data-class="{{ $s['class'] }}" data-phone="{{ $s['phone'] }}" data-balance="{{ $s['balance'] }}" data-count="{{ $s['count'] }}" data-initial="{{ $s['initial'] }}" data-status="{{ $s['status'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#92591f] hover:bg-[#f4ecd7]"><i class="bi bi-eye"></i></button>
                                <button type="button" title="Edit nasabah" data-admin-nasabah-open="edit" data-id="{{ $s['id'] }}" data-name="{{ $s['name'] }}" data-number="{{ $s['number'] }}" data-class="{{ $s['class'] }}" data-phone="{{ $s['phone'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#92591f] hover:bg-[#f4ecd7]"><i class="bi bi-pencil"></i></button>
                                <button type="button" title="Hapus nasabah" data-admin-nasabah-open="delete" data-id="{{ $s['id'] }}" data-name="{{ $s['name'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-red-600 hover:bg-red-50"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p data-admin-nasabah-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada nasabah yang sesuai dengan pencarian.</p>
    </section>

    {{-- Modal: Tambah Nasabah --}}
    <div data-admin-nasabah-modal="add" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/75 p-4">
        <section role="dialog" aria-modal="true" class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
            <header class="flex items-start justify-between bg-[#fcf3dd] px-6 py-5">
                <div><h2 class="text-2xl font-bold">Tambah Nasabah Baru</h2><p class="text-sm text-[#695b51]">No. nasabah dibuat otomatis oleh sistem</p></div>
                <button type="button" data-admin-nasabah-close class="text-2xl text-[#695b51]">&times;</button>
            </header>
            <form method="POST" action="{{ route('admin.nasabah.store') }}" class="p-6">
                @csrf
                <label class="text-sm font-bold">Nama Lengkap Nasabah <span class="text-[#92591f]">*</span></label>
                <input name="nama" required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm" placeholder="cth. Muhammad Rizky Pratama">
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div><label class="text-sm font-bold">Kelas / Rombel <span class="text-[#92591f]">*</span></label><input name="kelas" required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm" placeholder="cth. XII RPL B atau Guru"></div>
                    <div><label class="text-sm font-bold">Nomor WhatsApp / HP</label><input name="no_hp" class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm" placeholder="0812xxxxxxx"></div>
                </div>
                <div class="mt-4"><label class="text-sm font-bold">PIN Login Portal (4-6 digit) <span class="text-[#92591f]">*</span></label><input type="password" name="pin" inputmode="numeric" pattern="[0-9]{4,6}" required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm"></div>
                @if($errors->any())
                    <div class="mt-3 rounded-lg bg-red-50 p-3 text-xs text-red-700">{{ $errors->first() }}</div>
                @endif
                <div class="mt-6 flex items-center justify-end gap-2"><button type="button" data-admin-nasabah-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-sm font-bold">Batal</button><button type="submit" class="rounded-lg bg-[#54220f] px-5 py-2 text-sm font-bold text-white">Simpan Data Nasabah</button></div>
            </form>
        </section>
    </div>

    {{-- Modal: Detail Nasabah (tetap seperti semula, cuma lihat-lihat) --}}
    <div data-admin-nasabah-modal="detail" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/80 p-4">
        <section role="dialog" aria-modal="true" class="max-h-[calc(100vh-2rem)] w-full max-w-2xl overflow-y-auto rounded-2xl bg-[#fff9ea] shadow-2xl">
            <header class="flex items-start justify-between border-b border-[#eee3cf] bg-white px-6 py-5">
                <div><h2 class="text-2xl font-bold">Detail Data Nasabah <span data-an-number class="ml-2 rounded bg-[#ffe0ce] px-2 py-1 text-xs font-mono"></span></h2></div>
                <button type="button" data-admin-nasabah-close class="text-2xl text-[#695b51]">&times;</button>
            </header>
            <div class="space-y-4 p-6">
                <section class="flex items-center gap-4 rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-4">
                    <span data-an-initial class="grid h-14 w-14 place-items-center rounded-2xl bg-[#54220f] text-lg font-bold text-white"></span>
                    <div><b data-an-name class="text-lg"></b><small data-an-class class="mt-1 block text-[#92591f]"></small><small data-an-phone class="block font-mono text-xs"></small></div>
                </section>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl bg-[#54220f] p-4 text-white"><small class="text-[10px]">SALDO SAAT INI</small><b class="mt-2 block text-xl">Rp <span data-an-balance></span></b></div>
                    <div class="rounded-xl bg-white p-4 border"><small class="text-[10px] text-[#8b7e75]">FREKUENSI SETOR</small><b class="mt-2 block text-xl"><span data-an-count></span> Kali</b></div>
                </div>
            </div>
            <footer class="flex items-center justify-end gap-2 border-t border-[#eadcc5] px-6 py-4"><button type="button" data-admin-nasabah-close class="px-3 py-2 text-xs">Tutup</button><button type="button" data-admin-nasabah-open="edit" class="rounded-lg bg-[#54220f] px-4 py-2 text-xs font-bold text-white">Edit Data Nasabah</button></footer>
        </section>
    </div>

    {{-- Modal: Edit Nasabah --}}
    <div data-admin-nasabah-modal="edit" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/80 p-4">
        <section role="dialog" aria-modal="true" class="w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <header class="flex items-start justify-between border-b border-[#eadcc5] bg-[#fff9ea] px-5 py-3"><div><h2 class="text-lg font-bold">Edit Data Nasabah <span data-an-number class="ml-1 rounded bg-[#dce9c9] px-2 py-0.5 text-[10px]"></span></h2></div><button type="button" data-admin-nasabah-close class="text-xl text-[#695b51]">&times;</button></header>
            <form method="POST" action="" id="form-edit-nasabah" data-action-template="{{ route('admin.nasabah.update', '__ID__') }}" class="space-y-3 p-5">
                @csrf
                @method('PUT')
                <div><label class="text-xs font-bold">Nama Lengkap <span class="text-[#92591f]">*</span></label><input name="nama" data-an-input-name required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2 text-sm"></div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div><label class="text-xs font-bold">Kelas / Rombel <span class="text-[#92591f]">*</span></label><input name="kelas" data-an-input-class required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2 text-sm"></div>
                    <div><label class="text-xs font-bold">Nomor HP / WhatsApp</label><input name="no_hp" data-an-input-phone class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2 text-sm"></div>
                </div>
                <div><label class="text-xs font-bold">PIN Baru (opsional)</label><input type="password" name="pin" inputmode="numeric" pattern="[0-9]{4,6}" class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2 text-sm" placeholder="Kosongkan jika tidak diubah"></div>
                @if($errors->any())
                    <div class="rounded-lg bg-red-50 p-3 text-xs text-red-700">{{ $errors->first() }}</div>
                @endif
                <footer class="flex justify-end gap-2 border-t pt-3"><button type="button" data-admin-nasabah-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button><button type="submit" class="rounded-lg bg-[#54220f] px-4 py-2 text-xs font-bold text-white">Simpan Perubahan</button></footer>
            </form>
        </section>
    </div>

    {{-- Modal: Hapus Nasabah --}}
    <div data-admin-nasabah-modal="delete" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/80 p-4">
        <section role="dialog" aria-modal="true" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <header class="flex gap-4"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-red-100 text-xl text-red-700"><i class="bi bi-exclamation-triangle"></i></span><div><small class="font-bold text-[#92591f]">PERINGATAN SISTEM</small><h2 class="text-xl font-bold">Hapus Nasabah <span data-an-name></span>?</h2></div></header>
            <div class="mt-4 rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-4 text-sm text-[#695b51]">Tindakan ini tidak dapat dibatalkan. Kalau nasabah ini masih punya riwayat transaksi, sistem akan menolak penghapusan otomatis.</div>
            <form method="POST" action="" id="form-delete-nasabah" data-action-template="{{ route('admin.nasabah.destroy', '__ID__') }}" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full rounded-lg bg-[#54220f] py-3 text-sm font-bold text-white">Tetap Hapus</button>
            </form>
            <button type="button" data-admin-nasabah-close class="mt-2 w-full rounded-lg bg-[#f2ebdb] py-3 text-sm font-bold">Batal</button>
        </section>
    </div>
</x-layouts.admin>