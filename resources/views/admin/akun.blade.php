<x-layouts.admin title="Kelola Akun" :admin="$admin">
    <div class="flex flex-wrap justify-between gap-4"><div><h1 class="text-4xl font-bold">Kelola Akun &amp; Hak Akses Pengguna</h1><p class="mt-1 text-[#695b51]">Manajemen akun petugas piket timbang dan administrator sistem.</p></div><button type="button" data-admin-account-open="add" class="rounded-lg bg-[#92591f] px-5 py-3 text-sm font-bold text-white">+ Tambah Akun Baru</button></div>

    <section class="mt-6 grid gap-4 md:grid-cols-4">
        <x-nasabah.stat-card label="Total Akun Terdaftar" value="{{ $stats['totalAccounts'] ?? '0' }}"/>
        <x-nasabah.stat-card label="Nasabah Siswa" value="{{ $stats['totalStudentAccounts'] ?? '0' }}"/>
        <x-nasabah.stat-card label="Guru & Tendik" value="{{ $stats['totalTeacherAccounts'] ?? '0' }}"/>
        <x-nasabah.stat-card label="Petugas & Admin" value="{{ $stats['totalStaffAccounts'] ?? '0' }}"/>
    </section>

    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5"><x-admin.table-search placeholder="Cari nama, username, role..." target="[data-admin-account-rows] tr" empty="[data-admin-account-empty]" /></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase"><tr><th class="p-4">No</th><th>Nama</th><th>Username</th><th>Peran</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody data-admin-account-rows>
                    @foreach($accounts as $i => $a)
                        <tr data-search="{{ strtolower($a['name'].' '.$a['username'].' '.$a['role']) }}" class="border-b border-[#f0eadf]">
                            <td class="p-4">{{ $i + 1 }}</td>
                            <td><b>{{ $a['name'] }}</b></td>
                            <td class="font-mono text-xs">{{ $a['username'] }}</td>
                            <td><span class="rounded bg-[#eee8d7] px-2 py-1 text-xs">{{ $a['role'] }}</span></td>
                            <td><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; {{ $a['status'] }}</span></td>
                            <td class="space-x-2 whitespace-nowrap">
                                <button type="button" title="Edit akun" data-admin-account-open="edit" data-id="{{ $a['id'] }}" data-name="{{ $a['name'] }}" data-username="{{ $a['username'] }}" data-role="{{ $a['role'] }}" data-role-value="{{ $a['role_value'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#92591f] hover:bg-[#f4ecd7]"><i class="bi bi-pencil"></i></button>
                                <button type="button" title="Hapus akun" data-admin-account-open="delete" data-id="{{ $a['id'] }}" data-name="{{ $a['name'] }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-red-600 hover:bg-red-50"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p data-admin-account-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada akun yang sesuai dengan pencarian.</p>
    </section>

    {{-- Modal: Tambah Akun --}}
    <div data-admin-account-modal="add" class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-4">
        <section role="dialog" aria-modal="true" class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
            <header class="flex items-start justify-between bg-[#fcf3dd] px-6 py-5">
                <div><h2 class="text-xl font-bold">Tambah Akun Pengguna Baru</h2><p class="text-sm text-[#695b51]">Daftarkan akun petugas piket atau administrator</p></div>
                <button type="button" data-admin-account-close class="text-2xl text-[#695b51]">&times;</button>
            </header>
            <form method="POST" action="{{ route('admin.akun.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="role" value="petugas" data-admin-account-role-input>
                <label class="text-sm font-bold">Peran Akun <span class="text-[#92591f]">*</span></label>
                <div class="mt-2 grid grid-cols-2 gap-2 rounded-lg bg-[#f8f1df] p-1">
                    <button type="button" data-account-role="petugas" aria-pressed="true" class="rounded-md bg-[#92591f] py-2.5 text-sm font-bold text-white">Petugas Piket</button>
                    <button type="button" data-account-role="admin" aria-pressed="false" class="rounded-md py-2.5 text-sm font-medium text-[#3d2417]">Administrator</button>
                </div>
                <div class="mt-4"><label class="text-sm font-bold">Nama Lengkap <span class="text-[#92591f]">*</span></label><input name="nama" required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm" placeholder="cth. Siti Nurhaliza"></div>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div><label class="text-sm font-bold">Username <span class="text-[#92591f]">*</span></label><input name="username" required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm" placeholder="cth. petugas1"></div>
                    <div><label class="text-sm font-bold">Kata Sandi <span class="text-[#92591f]">*</span></label><input type="password" name="password" required minlength="6" class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm"></div>
                </div>
                @if($errors->any())
                    <div class="mt-3 rounded-lg bg-red-50 p-3 text-xs text-red-700">{{ $errors->first() }}</div>
                @endif
                <div class="mt-6 flex items-center justify-end gap-2"><button type="button" data-admin-account-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button><button type="submit" class="rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white">Buat Akun</button></div>
            </form>
        </section>
    </div>

    {{-- Modal: Edit Akun --}}
    <div data-admin-account-modal="edit" class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-4">
        <section role="dialog" aria-modal="true" class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
            <header class="flex items-start justify-between bg-[#54220f] px-6 py-5 text-white">
                <div><h2 class="text-xl font-bold">Edit Akun</h2><p class="text-sm text-white/70">Perbarui data akun pengguna</p></div>
                <button type="button" data-admin-account-close class="text-2xl text-white/70">&times;</button>
            </header>
            <form method="POST" action="" id="form-edit-akun" data-action-template="{{ route('admin.akun.update', '__ID__') }}" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="role" value="petugas" data-admin-account-role-input>
                <label class="text-sm font-bold">Peran Akun <span class="text-[#92591f]">*</span></label>
                <div class="mt-2 grid grid-cols-2 gap-2 rounded-lg bg-[#f8f1df] p-1">
                    <button type="button" data-account-role="petugas" aria-pressed="true" class="rounded-md py-2.5 text-sm font-medium text-[#3d2417]">Petugas Piket</button>
                    <button type="button" data-account-role="admin" aria-pressed="false" class="rounded-md py-2.5 text-sm font-medium text-[#3d2417]">Administrator</button>
                </div>
                <div class="mt-4"><label class="text-sm font-bold">Nama Lengkap <span class="text-[#92591f]">*</span></label><input name="nama" data-aa-input-name required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm"></div>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div><label class="text-sm font-bold">Username <span class="text-[#92591f]">*</span></label><input name="username" data-aa-input-username required class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm"></div>
                    <div><label class="text-sm font-bold">Kata Sandi Baru</label><input type="password" name="password" minlength="6" class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm" placeholder="Kosongkan jika tidak diubah"></div>
                </div>
                @if($errors->any())
                    <div class="mt-3 rounded-lg bg-red-50 p-3 text-xs text-red-700">{{ $errors->first() }}</div>
                @endif
                <div class="mt-6 flex items-center justify-end gap-2"><button type="button" data-admin-account-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button><button type="submit" class="rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white">Simpan Perubahan</button></div>
            </form>
        </section>
    </div>

    {{-- Modal: Hapus Akun --}}
    <div data-admin-account-modal="delete" class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-4">
        <section role="dialog" aria-modal="true" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <header class="flex gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-red-100 text-xl text-red-700"><i class="bi bi-exclamation-triangle"></i></span>
                <div><small class="font-bold text-[#92591f]">PERINGATAN SISTEM</small><h2 class="text-xl font-bold">Hapus Akun <span data-aa-name></span>?</h2></div>
            </header>
            <div class="mt-4 rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-4 text-sm text-[#695b51]">Tindakan ini tidak dapat dibatalkan. Kalau akun ini masih punya riwayat transaksi tercatat, sistem akan menolak penghapusan otomatis. Kamu juga tidak bisa menghapus akunmu sendiri.</div>
            <form method="POST" action="" id="form-delete-akun" data-action-template="{{ route('admin.akun.destroy', '__ID__') }}" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full rounded-lg bg-[#54220f] py-3 text-sm font-bold text-white">Tetap Hapus</button>
            </form>
            <button type="button" data-admin-account-close class="mt-2 w-full rounded-lg bg-[#f2ebdb] py-3 text-sm font-bold">Batal</button>
        </section>
    </div>
</x-layouts.admin>