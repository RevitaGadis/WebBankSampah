<x-layouts.petugas title="Data Nasabah" :officer="$officer">
    <h1 class="text-4xl font-bold">Data Nasabah Bank Sampah</h1>
    <p class="mt-1 text-[#695b51]">Kelola data nasabah siswa dan guru aktif, informasi saldo tabungan, dan mutasi setoran sirkular sekolah.</p>
    <section class="mt-8 grid gap-4 md:grid-cols-3">
        <x-nasabah.stat-card label="Siswa Terdaftar" value="{{ $stats['totalStudents'] ?? '228' }}" description="{{ $stats['totalStudentsDesc'] ?? '93% partisipasi per kelas kejuruan' }}" icon="bi-people" accent="#92591f" />
        <x-nasabah.stat-card label="Pendidik & Tenaga Kerja" value="{{ $stats['totalTeachers'] ?? '17' }}" description="{{ $stats['totalTeachersDesc'] ?? 'Nasabah Teladan' }}" icon="bi-person-badge" accent="#bdcaa8" />
        <x-nasabah.stat-card label="Total Saldo Terkumpul" value="{{ $stats['totalBalance'] ?? 'Rp 4.850.000' }}" description="{{ $stats['totalBalanceDesc'] ?? 'Tercatat di Buku Induk' }}" icon="bi-wallet2" desc-icon="bi-wallet2" accent="#ffb980" />
    </section>
    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5">
            <x-admin.table-search :icon="false" placeholder="Cari nama, no. nasabah, kelas..." target="[data-admin-nasabah-rows] tr" empty="[data-admin-nasabah-empty]" />
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide text-[#695b51]">
                    <tr>
                        <th class="w-[6%] px-4 py-4 text-center">No</th>
                        <th class="w-[24%] px-3 py-4">Nama Lengkap</th>
                        <th class="w-[15%] px-3 py-4">Kelas / Gugus</th>
                        <th class="w-[15%] px-3 py-4">No. WhatsApp</th>
                        <th class="w-[10%] px-3 py-4 text-center">Total Setor</th>
                        <th class="w-[14%] px-3 py-4 text-right">Saldo Tabungan<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                        <th class="w-[9%] px-3 py-4">Status</th>
                        <th class="w-[7%] px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody data-admin-nasabah-rows>
                    @forelse ($students as $i => $s)
                        <tr data-search="{{ strtolower($s['name'].' '.$s['number'].' '.$s['class'].' '.$s['phone']) }}" data-class="{{ $s['class'] }}" class="border-b border-[#f0eadf] even:bg-[#fffdf8] last:border-0">
                            <td class="px-4 py-4 text-center font-mono text-xs text-[#695b51]">{{ $i + 1 }}</td>
                            <td class="px-3 py-4"><b class="block">{{ $s['name'] }}</b><small class="mt-0.5 block text-[#695b51]">Nasabah {{ str_contains($s['class'], 'Guru') ? 'Guru' : 'Siswa' }}</small></td>
                            <td class="px-3 py-4"><span class="rounded bg-[#eee8d7] px-2 py-1 text-xs font-medium">{{ $s['class'] }}</span></td>
                            <td class="px-3 py-4 font-mono text-xs">{{ $s['phone'] }}</td>
                            <td class="px-3 py-4 text-center"><b class="block font-mono text-sm">{{ $s['count'] }}</b><small class="mt-0.5 block text-[10px] text-[#695b51]">kali setor</small></td>
                            <td class="px-3 py-4 text-right font-mono text-xs font-bold">{{ $s['balance'] }}</td>
                            <td class="px-3 py-4"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">{{ $s['status'] }}</span></td>
                            <td class="whitespace-nowrap px-4 py-4 text-center">
                                <button type="button" title="Detail nasabah {{ $s['name'] }}" data-nasabah-detail-open @foreach ($s as $key => $value) data-nd-{{ $key }}="{{ $value }}" @endforeach class="rounded-lg bg-[#f4ecd7] px-2.5 py-1.5 text-[10px] font-bold text-[#713b18] hover:bg-[#eadcc5]">Lihat</button>
                            </td>
                        </tr>
                    @empty
                        <tr data-page-ignore><td colspan="8" class="px-4 py-10 text-center text-sm text-[#695b51]">Belum ada data nasabah.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p data-admin-nasabah-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada nasabah yang sesuai dengan pencarian.</p>
        <x-admin.table-pagination rows="[data-admin-nasabah-rows] tr" label="nasabah" />
    </section>
    <x-petugas.nasabah-modal />
</x-layouts.petugas>
