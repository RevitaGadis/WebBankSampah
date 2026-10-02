<x-layouts.admin title="Data Nasabah" :admin="$admin">
    <div class="flex flex-wrap justify-between gap-4">
        <div><h1 class="text-4xl font-bold">Data Nasabah Bank Sampah</h1><p class="mt-1 max-w-2xl text-[#695b51]">Kelola data nasabah siswa dan guru aktif, informasi saldo tabungan, dan mutasi setoran sirkular sekolah.</p></div>
        <div class="flex gap-3"><button type="button" data-admin-nasabah-open="add" class="rounded-lg bg-[#92591f] px-4 py-3 text-sm font-bold text-white">+ Tambah Nasabah Baru</button></div>
    </div>

    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Siswa Terdaftar" value="{{ $stats['totalStudents'] ?? '228' }}" description="{{ $stats['totalStudentsDesc'] ?? '93% partisipasi per kelas kejuruan' }}" icon="bi-people" accent="#92591f" /><x-nasabah.stat-card label="Pendidik & Tenaga Kerja" value="{{ $stats['totalTeachers'] ?? '17' }}" description="{{ $stats['totalTeachersDesc'] ?? 'Nasabah Teladan' }}" icon="bi-person-badge" accent="#bdcaa8" /><x-nasabah.stat-card label="Total Saldo Terkumpul" value="{{ $stats['totalBalance'] ?? 'Rp 4.850.000' }}" description="{{ $stats['totalBalanceDesc'] ?? 'Tercatat di Buku Induk' }}" icon="bi-wallet2" desc-icon="bi-wallet2" accent="#ffb980" /></section>

    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5"><x-admin.table-search placeholder="Cari nama, no. nasabah, kelas..." target="[data-admin-nasabah-rows] tr" empty="[data-admin-nasabah-empty]" /></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[920px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide text-[#695b51]"><tr><th class="w-[5%] px-4 py-4 text-center">No</th><th class="w-[12%] px-3 py-4">No Nasabah</th><th class="w-[20%] px-3 py-4">Nama Lengkap</th><th class="w-[11%] px-3 py-4">Kelas</th><th class="w-[13%] px-3 py-4">Nomor WhatsApp</th><th class="w-[9%] px-3 py-4 text-center">Total Setor</th><th class="w-[13%] px-3 py-4 text-right">Saldo Tabungan<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th><th class="w-[9%] px-3 py-4">Status</th><th class="w-[8%] px-4 py-4 text-center">Aksi</th></tr></thead>
                <tbody data-admin-nasabah-rows>
                    @foreach($students as $i => $s)
                        <tr data-search="{{ strtolower($s['name'].' '.$s['number'].' '.$s['class'].' '.$s['phone']) }}" data-class="{{ $s['class'] }}" class="border-b border-[#f0eadf] even:bg-[#fffdf8] last:border-0">
                            <td class="px-4 py-4 text-center font-mono text-xs text-[#695b51]">{{ $i + 1 }}</td>
                            <td class="px-3 py-4 font-mono text-xs font-bold text-[#92591f]">{{ $s['number'] }}</td>
                            <td class="px-3 py-4"><b class="block">{{ $s['name'] }}</b><small class="mt-0.5 block text-[#695b51]">Nasabah {{ str_contains($s['class'], 'Guru') ? 'Guru' : 'Siswa' }}</small></td>
                            <td class="px-3 py-4"><span class="rounded bg-[#eee8d7] px-2 py-1 text-xs font-medium">{{ $s['class'] }}</span></td>
                            <td class="px-3 py-4 font-mono text-xs">{{ $s['phone'] }}</td>
                            <td class="px-3 py-4 text-center"><b class="block font-mono text-sm">{{ $s['count'] }}</b><small class="mt-0.5 block text-[10px] text-[#695b51]">kali setor</small></td>
                            <td class="px-3 py-4 text-right font-mono font-bold">{{ $s['balance'] }}</td>
                            <td class="px-3 py-4"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; {{ $s['status'] }}</span></td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <button type="button" title="Detail nasabah" data-admin-nasabah-open="detail" data-id="{{ $s['id'] }}" data-name="{{ $s['name'] }}" data-number="{{ $s['number'] }}" data-class="{{ $s['class'] }}" data-phone="{{ $s['phone'] }}" data-balance="{{ $s['balance'] }}" data-count="{{ $s['count'] }}" data-initial="{{ $s['initial'] }}" data-status="{{ $s['status'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#92591f] hover:bg-[#f4ecd7]"><i class="bi bi-eye"></i></button>
                                    <button type="button" title="Edit nasabah" data-admin-nasabah-open="edit" data-id="{{ $s['id'] }}" data-name="{{ $s['name'] }}" data-number="{{ $s['number'] }}" data-class="{{ $s['class'] }}" data-phone="{{ $s['phone'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#92591f] hover:bg-[#f4ecd7]"><i class="bi bi-pencil"></i></button>
                                    <button type="button" title="Hapus nasabah" data-admin-nasabah-open="delete" data-id="{{ $s['id'] }}" data-name="{{ $s['name'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-red-600 hover:bg-red-50"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p data-admin-nasabah-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada nasabah yang sesuai dengan pencarian.</p>
        <x-admin.table-pagination rows="[data-admin-nasabah-rows] tr" label="nasabah" />
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

    {{-- Modal: Detail Nasabah --}}
    <div data-admin-nasabah-modal="detail" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/75 p-4">
        <section role="dialog" aria-modal="true" class="max-h-[calc(100vh-2rem)] w-full max-w-2xl overflow-y-auto rounded-2xl bg-[#fffaf0] shadow-2xl">
            <header class="flex items-start justify-between border-b border-[#e5dcc8] bg-white p-6">
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-2xl font-bold">Detail Data Nasabah</h2>
                        <b data-an-number class="rounded bg-[#ffdcca] px-3 py-1 font-mono text-xs"></b>
                        <span class="rounded-full bg-[#dce9c9] px-3 py-1 text-xs font-bold">&bull; <span data-an-status></span></span>
                    </div>
                    <p class="mt-1 text-sm text-[#695b51]">Informasi rekening buku tabungan, identitas siswa, dan statistik penimbangan terverifikasi.</p>
                </div>
                <button type="button" aria-label="Tutup" data-admin-nasabah-close class="text-xl text-[#7a695e]">&times;</button>
            </header>

            <div class="p-6" data-an-ringkas>
                <p class="py-10 text-center text-sm text-[#695b51]">Memuat rincian nasabah&hellip;</p>
            </div>

            <footer class="flex flex-wrap items-center justify-between gap-3 border-t border-[#e5dcc8] bg-[#fcf3dd] p-5">
                <button type="button" onclick="window.print()" class="rounded-lg border border-[#d8c5a8] bg-white px-4 py-2 text-sm">Cetak data nasabah</button>
                <div class="flex items-center gap-2">
                    <button type="button" data-admin-nasabah-close class="px-4 py-2 text-sm">Tutup</button>
                    <button type="button" data-admin-nasabah-open="edit" class="rounded-lg bg-[#54220f] px-4 py-2 text-sm font-bold text-white">Edit Data Nasabah</button>
                </div>
            </footer>
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