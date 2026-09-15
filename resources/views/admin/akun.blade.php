<x-layouts.admin title="Kelola Akun" :admin="$admin">
    <div class="flex flex-wrap justify-between gap-4"><div><h1 class="text-4xl font-bold">Kelola Akun &amp; Hak Akses Pengguna</h1><p class="mt-1 text-[#695b51]">Manajemen identitas, verifikasi akun nasabah, petugas loket timbang, serta administrator sistem.</p></div><button data-admin-account-open="add" class="rounded-lg bg-[#92591f] px-5 py-3 text-sm font-bold text-white">+ Tambah Akun Baru</button></div>
    <section class="mt-6 rounded-xl bg-[#f1ead9] p-5"><b>Integritas Buku Kas &amp; Saldo Nasabah</b><p class="text-sm">Akun dengan riwayat transaksi dan saldo aktif tidak dapat dihapus permanen.</p></section>
    <section class="mt-6 grid gap-4 md:grid-cols-4"><x-nasabah.stat-card label="Total Akun Terdaftar" value="{{ $stats['totalAccounts'] ?? '248' }}"/><x-nasabah.stat-card label="Nasabah Siswa" value="{{ $stats['totalStudentAccounts'] ?? '216' }}"/><x-nasabah.stat-card label="Guru & Tendik" value="{{ $stats['totalTeacherAccounts'] ?? '24' }}"/><x-nasabah.stat-card label="Petugas & Admin" value="{{ $stats['totalStaffAccounts'] ?? '8' }}"/></section>
    <section class="ns-card mt-8 overflow-hidden"><div class="p-5"><x-admin.table-search placeholder="Cari nama, username, role..." target="[data-admin-account-rows] tr" empty="[data-admin-account-empty]" /></div><div class="overflow-x-auto"><table class="w-full min-w-[1000px] text-sm"><thead class="bg-[#f8f1df] text-left text-[10px] uppercase"><tr><th class="p-4">No</th><th>Pengguna &amp; Identitas</th><th>Peran</th><th>Rombel / Unit Kerja</th><th>Kontak WA</th><th>Status Akun</th><th>Terakhir Masuk</th><th>Aksi</th></tr></thead><tbody data-admin-account-rows>@foreach($accounts as $i => $a)<tr data-search="{{ strtolower($a['name'].' '.$a['username'].' '.$a['role'].' '.$a['class'].' '.$a['phone']) }}" class="border-b border-[#f0eadf]"><td class="p-4">{{ $i + 1 }}</td><td><b>{{ $a['name'] }}</b><small class="block">{{ $a['username'] }}</small></td><td>{{ $a['role'] }}</td><td>{{ $a['class'] }}</td><td>{{ $a['phone'] }}</td><td><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; {{ $a['status'] }}</span></td><td>Hari ini, 08:14 WIB</td>                <td class="space-x-3"><button data-admin-account-open="detail" data-number="{{ $a['number'] }}" data-name="{{ $a['name'] }}" data-username="{{ $a['username'] }}" data-role="{{ $a['role'] }}" data-class="{{ $a['class'] }}" data-phone="{{ $a['phone'] }}" data-status="{{ $a['status'] }}" data-initial="{{ strtoupper(substr($a['name'],0,2)) }}" class="text-[#92591f]"><i class="bi bi-eye"></i></button><button data-admin-account-open="edit" data-number="{{ $a['number'] }}" data-name="{{ $a['name'] }}" data-username="{{ $a['username'] }}" data-role="{{ $a['role'] }}" data-class="{{ $a['class'] }}" data-phone="{{ $a['phone'] }}" data-status="{{ $a['status'] }}" data-initial="{{ strtoupper(substr($a['name'],0,2)) }}" class="text-[#92591f]"><i class="bi bi-pencil"></i></button><button data-admin-account-open="delete" data-number="{{ $a['number'] }}" data-name="{{ $a['name'] }}" data-username="{{ $a['username'] }}" data-role="{{ $a['role'] }}" data-class="{{ $a['class'] }}" data-phone="{{ $a['phone'] }}" data-status="{{ $a['status'] }}" data-initial="{{ strtoupper(substr($a['name'],0,2)) }}" class="text-red-600"><i class="bi bi-person-x"></i></button></td></tr>@endforeach</tbody></table></div><p data-admin-account-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada akun yang sesuai dengan pencarian.</p></section>

    {{-- Modal Tambah Akun --}}
    <div data-admin-account-modal="add" class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-4">
        <section role="dialog" aria-modal="true" aria-labelledby="account-add-title" class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <header class="flex items-start justify-between bg-[#fcf3dd] px-6 py-5">
                <div class="flex items-start gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#f4ecd7] text-lg text-[#92591f]"><i class="bi bi-person-plus"></i></span>
                    <div><h2 id="account-add-title" class="text-xl font-bold">Tambah Akun Pengguna Baru</h2><p class="text-sm text-[#695b51]">Daftarkan akun nasabah siswa, guru, atau petugas piket loket</p></div>
                </div>
                <button type="button" data-admin-account-close class="text-2xl text-[#695b51]">&times;</button>
            </header>
            <form class="p-6" onsubmit="return false">
                <label class="text-sm font-bold">Pilihan Peran Akun <span class="text-[#92591f]">*</span></label>
                <div class="mt-2 grid grid-cols-3 gap-2 rounded-lg bg-[#f8f1df] p-1">
                    <button type="button" data-account-role="siswa" aria-pressed="true" class="flex items-center justify-center gap-2 rounded-md bg-[#92591f] py-2.5 text-sm font-bold text-white"><i class="bi bi-mortarboard"></i> Siswa Nasabah</button>
                    <button type="button" data-account-role="guru" aria-pressed="false" class="flex items-center justify-center gap-2 rounded-md py-2.5 text-sm font-medium text-[#3d2417]"><i class="bi bi-person-badge"></i> Guru / Tendik</button>
                    <button type="button" data-account-role="petugas" aria-pressed="false" class="flex items-center justify-center gap-2 rounded-md py-2.5 text-sm font-medium text-[#3d2417]"><i class="bi bi-person-workspace"></i> Petugas Loket</button>
                </div>
                <div class="mt-5"><label class="text-sm font-bold">Nama Lengkap <span class="text-[#92591f]">*</span></label><input class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm" placeholder="cth. Siti Nurhaliza"></div>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div><label class="text-sm font-bold">Nomor Nasabah <span class="text-[#92591f]">*</span></label><input class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 font-mono text-sm" placeholder="0068192831"></div>
                    <div><label class="text-sm font-bold">Rombel / Kelas atau Unit Kerja <span class="text-[#92591f]">*</span></label><select class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm"><option>XII RPL B</option><option>XII RPL A</option><option>X TKJ A</option></select></div>
                </div>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div><label class="text-sm font-bold">Nomor Handphone / WhatsApp <span class="text-[#92591f]">*</span></label><div class="mt-1 flex rounded-lg border border-[#decfb8]"><span class="flex items-center border-r border-[#decfb8] bg-[#f8f1df] px-3 text-sm">+62</span><input class="min-w-0 flex-1 px-3 py-2.5 text-sm outline-none" placeholder="812-3456-7890"></div></div>
                    <div><label class="text-sm font-bold">Kata Sandi Sementara</label><div class="mt-1 flex rounded-lg border border-[#decfb8]"><input type="password" value="BS-Smk2026!" class="min-w-0 flex-1 px-3 py-2.5 text-sm outline-none"><button type="button" class="px-3 text-[#695b51]"><i class="bi bi-eye"></i></button></div></div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-2"><button type="button" data-admin-account-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button><button type="button" class="flex items-center gap-2 rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white"><i class="bi bi-plus-circle"></i> Buat Akun Sekarang</button></div>
            </form>
        </section>
    </div>

    {{-- Modal Detail Akun --}}
    <div data-admin-account-modal="detail" class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-4">
        <section role="dialog" aria-modal="true" aria-labelledby="account-detail-title" class="max-h-[calc(100vh-2rem)] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <header class="flex items-center justify-between bg-[#54220f] px-6 py-4 text-white">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/15 text-lg"><i class="bi bi-person"></i></span>
                    <div><h2 id="account-detail-title" class="text-lg font-bold">Detail Informasi Pengguna</h2><p class="text-xs text-white/60">Informasi profil terintegrasi tabel database <code class="rounded bg-white/15 px-1 py-0.5 text-[10px]">nasabah</code> &amp; mutasi kas</p></div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="rounded bg-white/20 px-2 py-0.5 text-[10px] font-mono">id_nasabah: #<span data-aa-id></span></span>
                    <span class="flex items-center gap-1 rounded-full bg-[#dce9c9] px-2 py-0.5 text-[10px] font-bold text-[#3d2417]">&bull; <span data-aa-status></span></span>
                    <button type="button" data-admin-account-close class="ml-2 flex h-7 w-7 items-center justify-center rounded-lg text-white/60 hover:bg-white/10 hover:text-white">&times;</button>
                </div>
            </header>
            <div class="space-y-4 p-5">
                <section class="flex items-center gap-4 rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-4">
                    <span data-aa-initial class="grid h-14 w-14 place-items-center rounded-2xl bg-[#54220f] text-lg font-bold text-white"></span>
                    <div>
                        <div class="flex items-center gap-2"><b data-aa-name class="text-lg"></b><span class="flex items-center gap-1 rounded bg-[#eee8d7] px-2 py-0.5 text-[10px]"><i class="bi bi-mortarboard"></i> <span data-aa-role></span></span></div>
                        <small class="mt-0.5 block text-[#695b51]">Kelas <span data-aa-class></span></small>
                        <small class="mt-0.5 flex items-center gap-1 text-xs text-[#587332]"><i class="bi bi-patch-check-fill"></i> Terverifikasi</small>
                    </div>
                </section>
                <section class="rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-4">
                    <h3 class="flex items-center gap-1.5 text-xs font-bold text-[#92591f]"><i class="bi bi-person-lines-fill"></i> DATA NASABAH</h3>
                    <div class="mt-3 grid gap-2 sm:grid-cols-3">
                        <div class="rounded-lg bg-white p-3 text-[11px] text-[#8b7e75]">ID Nasabah<b class="mt-1 block text-sm text-[#3d2417]">#<span data-aa-id></span></b></div>
                        <div class="rounded-lg bg-white p-3 text-[11px] text-[#8b7e75]">No. Nasabah<b class="mt-1 block font-mono text-sm text-[#92591f]"><span data-aa-number></span></b></div>
                        <div class="rounded-lg bg-white p-3 text-[11px] text-[#8b7e75]">Nama Lengkap<b data-aa-name class="mt-1 block text-sm text-[#3d2417]"></b></div>
                        <div class="rounded-lg bg-white p-3 text-[11px] text-[#8b7e75]">Kelas / Rombel<b data-aa-class class="mt-1 block text-sm text-[#3d2417]"></b></div>
                        <div class="rounded-lg bg-white p-3 text-[11px] text-[#8b7e75]">Nomor HP / WA<b class="mt-1 block font-mono text-sm text-[#3d2417]"><span data-aa-phone></span></b></div>
                        <div class="rounded-lg border border-[#dce9c9] bg-[#f0f7e6] p-3 text-[11px] font-bold text-[#587332]">Saldo Tabungan<b class="mt-1 block text-base text-[#3d2417]">Rp <span data-aa-balance></span></b></div>
                    </div>
                </section>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                    <div class="rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-3"><small class="text-[10px] font-bold uppercase text-[#92591f]">Saldo Tabungan</small><b class="mt-1 block text-lg">Rp <span data-aa-balance></span></b><small class="text-[10px] text-[#695b51]"><i class="bi bi-wallet2"></i> Buku Kas Aktif</small></div>
                    <div class="rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-3"><small class="text-[10px] font-bold uppercase text-[#92591f]">Total Sampah</small><b class="mt-1 block text-lg"><span data-aa-total-weight>68.4</span> Kg</b><small class="text-[10px] text-[#695b51]"><i class="bi bi-recycle"></i> Tereduksi</small></div>
                    <div class="rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-3"><small class="text-[10px] font-bold uppercase text-[#92591f]">Frekuensi Timbang</small><b class="mt-1 block text-lg"><span data-aa-frequency>14</span> Kali</b><small class="text-[10px] text-[#695b51]"><i class="bi bi-arrow-repeat"></i> Transaksi</small></div>
                    <div class="rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-3"><small class="text-[10px] font-bold uppercase text-[#92591f]">Terakhir Setor</small><b class="mt-1 block text-sm"><span data-aa-last-deposit>Hari ini, 08:14</span></b><small class="text-[10px] text-[#695b51]" data-aa-last-item></small></div>
                </div>
                <section>
                    <h3 class="flex items-center gap-1.5 text-sm font-bold text-[#92591f]"><i class="bi bi-clock-history"></i> Riwayat Transaksi Terakhir</h3>
                    <div class="mt-3 space-y-2" data-aa-transaction-history>
                        <div class="flex items-center justify-between rounded-lg border border-[#eadcc5] bg-[#fcf3dd] px-4 py-3"><div class="flex items-center gap-3"><span class="grid h-9 w-9 place-items-center rounded-lg bg-[#dce9c9] text-sm text-[#587332]"><i class="bi bi-recycle"></i></span><div><b class="text-sm" data-aa-history-1-desc></b><small class="mt-0.5 block text-[11px] text-[#695b51]" data-aa-history-1-meta></small></div></div><b class="text-sm text-[#587332]" data-aa-history-1-amount></b></div>
                    </div>
                </section>
                <div class="rounded-lg bg-[#f8f1df] px-4 py-2.5 text-xs text-[#695b51]">Terdaftar sejak: <span data-aa-registered>14 Juli 2025</span></div>
            </div>
            <footer class="flex items-center justify-between border-t border-[#eadcc5] bg-[#fcf3dd] px-5 py-3">
                <button type="button" class="flex items-center gap-1.5 rounded-lg border border-[#decfb8] px-3 py-2 text-xs font-bold"><i class="bi bi-printer"></i> Cetak Kartu / Tabungan</button>
                <div class="flex items-center gap-2"><button type="button" data-admin-account-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Tutup</button><button type="button" data-admin-account-open="edit" class="flex items-center gap-1.5 rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white"><i class="bi bi-pencil"></i> Edit Akun</button></div>
            </footer>
        </section>
    </div>

    {{-- Modal Edit Akun --}}
    <div data-admin-account-modal="edit" class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-4">
        <section role="dialog" aria-modal="true" aria-labelledby="account-edit-title" class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <header class="flex items-start justify-between bg-[#54220f] px-6 py-5 text-white">
                <div class="flex items-start gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/15 text-lg"><i class="bi bi-person-gear"></i></span>
                    <div>
                        <div class="flex items-center gap-2"><h2 id="account-edit-title" class="text-xl font-bold">Edit Akun Pengguna</h2><span class="rounded bg-white/20 px-2 py-0.5 text-[10px] font-mono" data-aa-number></span></div>
                        <p class="mt-0.5 text-sm text-white/70">Perbarui data identitas, kontak, dan status akun nasabah</p>
                    </div>
                </div>
                <button type="button" data-admin-account-close class="text-2xl text-white/70 hover:text-white">&times;</button>
            </header>
            <form class="p-6" onsubmit="return false">
                <section class="flex items-center justify-between rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-3">
                    <div class="flex items-center gap-2.5">
                        <span data-aa-initial class="grid h-10 w-10 place-items-center rounded-full bg-[#54220f] text-sm font-bold text-white"></span>
                        <div class="flex items-center gap-2"><b data-aa-name class="text-sm"></b><span class="flex items-center gap-1 rounded-full bg-[#dce9c9] px-1.5 py-0.5 text-[10px]">&bull; <span data-aa-status></span></span><small data-aa-username class="block text-[11px] text-[#695b51]"></small></div>
                    </div>
                    <span class="flex items-center gap-1 rounded bg-[#eee8d7] px-2 py-1 text-xs"><i class="bi bi-mortarboard"></i> <span data-aa-role></span></span>
                </section>
                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div><label class="text-xs font-bold">Nomor Nasabah</label><input data-aa-input-number readonly class="mt-1 w-full rounded-lg bg-[#f2eee5] px-3 py-2.5 font-mono text-sm"></div>
                    <div><label class="text-xs font-bold">Nama Lengkap <span class="text-[#92591f]">*</span></label><input data-aa-input-name class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm"></div>
                    <div><label class="text-xs font-bold">Rombel / Kelas <span class="text-[#92591f]">*</span></label><select class="mt-1 w-full rounded-lg border border-[#decfb8] px-3 py-2.5 text-sm"><option>XII RPL B</option><option>XII RPL A</option><option>X TKJ A</option></select></div>
                    <div><label class="text-xs font-bold">Kontak WhatsApp <span class="text-[#92591f]">*</span></label><div class="mt-1 flex rounded-lg border border-[#decfb8]"><span class="flex items-center border-r border-[#decfb8] bg-[#f8f1df] px-3 text-sm">+62</span><input data-aa-input-phone class="min-w-0 flex-1 px-3 py-2.5 text-sm outline-none"></div></div>
                </div>
                <div class="mt-4"><label class="text-xs font-bold">Status Akun</label>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        <button type="button" data-account-status="aktif" aria-pressed="true" class="flex items-center justify-center gap-2 rounded-lg bg-[#92591f] py-3 text-sm font-bold text-white"><i class="bi bi-check-circle-fill"></i> Aktif</button>
                        <button type="button" data-account-status="nonaktif" aria-pressed="false" class="flex items-center justify-center gap-2 rounded-lg border border-[#decfb8] bg-white py-3 text-sm font-medium text-[#3d2417]"><i class="bi bi-x-circle"></i> Nonaktif</button>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-2"><button type="button" data-admin-account-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button><button type="button" class="flex items-center gap-2 rounded-lg bg-[#92591f] px-4 py-2 text-xs font-bold text-white"><i class="bi bi-check2"></i> Simpan Perubahan</button></div>
            </form>
        </section>
    </div>

    {{-- Modal Hapus / Nonaktif --}}
    <div data-admin-account-modal="delete" class="fixed inset-0 z-[80] hidden items-center justify-center bg-[#4a1f0d]/80 p-4">
        <section role="dialog" aria-modal="true" aria-labelledby="account-delete-title" class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
            <header class="flex items-start justify-between bg-[#fcf3dd] px-6 py-5">
                <div class="flex items-start gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-red-100 text-lg text-red-700"><i class="bi bi-exclamation-triangle"></i></span>
                    <div><h2 id="account-delete-title" class="text-xl font-bold">Konfirmasi Hapus / Nonaktif</h2><p class="text-sm text-[#695b51]">Tindakan berisiko pada akun nasabah terdaftar</p></div>
                </div>
                <button type="button" data-admin-account-close class="text-2xl text-[#695b51]">&times;</button>
            </header>
            <div class="space-y-3 p-5">
                <section class="flex items-center gap-3 rounded-xl border border-[#eadcc5] bg-[#fcf3dd] p-4">
                    <span data-aa-initial class="grid h-11 w-11 place-items-center rounded-full bg-[#54220f] text-sm font-bold text-white"></span>
                    <div><b data-aa-name class="text-sm"></b> <span class="text-xs text-[#695b51]"><span data-aa-role></span></span><small class="mt-0.5 block font-mono text-[11px] text-[#695b51]">No nasabah: <span data-aa-number></span> &bull; Kelas <span data-aa-class></span></small></div>
                </section>
                <section class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start gap-2"><span class="mt-0.5 text-lg text-red-500"><i class="bi bi-shield-x"></i></span><div><b class="text-sm text-red-700">Peringatan Audit &amp; Integritas Kas</b><p class="mt-1 text-xs text-[#695b51]">Akun ini memiliki <b>Saldo Aktif Rp <span data-aa-balance></span></b> dan tercatat dalam <b><span data-aa-frequency></span> riwayat transaksi penimbangan sampah</b>. Menghapus akun secara permanen dapat merusak rantai audit kas dan ketidaksinkronan buku besar kas sekolah.</p></div></div>
                </section>
                <section class="rounded-xl border border-[#dce9c9] bg-[#f0f7e6] p-4">
                    <div class="flex items-start gap-2"><span class="mt-0.5 text-lg text-[#587332]"><i class="bi bi-gear"></i></span><div><b class="text-sm">Rekomendasi Sistem (Protokol Audit v2.4)</b><p class="mt-1 text-xs text-[#695b51]">Disarankan memilih "Nonaktifkan Akun". Siswa tidak lagi dapat masuk ataupun menimbang di loket, namun seluruh rekaman mutasi kas, saldo riil, serta rekapitulasi pelaporan tetap terpelihara aman.</p></div></div>
                </section>
                <button type="button" class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#bdcaa8] py-3 text-sm font-bold"><i class="bi bi-person-x"></i> Nonaktifkan Saja (Disarankan)</button>
                <footer class="flex items-center justify-end gap-2"><button type="button" data-admin-account-close class="rounded-lg border border-[#decfb8] px-4 py-2 text-xs font-bold">Batal</button><button type="button" class="flex items-center gap-2 rounded-lg bg-[#54220f] px-4 py-2 text-xs font-bold text-white"><i class="bi bi-trash"></i> Tetap Hapus Permanen</button></footer>
            </div>
        </section>
    </div>
</x-layouts.admin>
