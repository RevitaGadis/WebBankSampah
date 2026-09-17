<x-layouts.petugas title="Data Nasabah" :officer="$officer">
    <h1 class="text-4xl font-bold">Data Nasabah Bank Sampah</h1>
    <p class="mt-1 text-[#695b51]">Kelola data nasabah siswa dan guru aktif, informasi saldo tabungan, dan mutasi
        setoran sirkular sekolah.</p>
    <section class="mt-8 grid gap-4 md:grid-cols-3"><x-nasabah.stat-card label="Siswa Terdaftar" value="{{ $stats['totalStudents'] ?? '228' }}"
            description="{{ $stats['totalStudentsDesc'] ?? '93% partisipasi per kelas kejuruan' }}" /><x-nasabah.stat-card label="Pendidik & Tenaga Kerja"
            value="{{ $stats['totalTeachers'] ?? '17' }}" description="{{ $stats['totalTeachersDesc'] ?? 'Nasabah Teladan' }}" /><x-nasabah.stat-card label="Total Saldo Terkumpul"
            value="{{ $stats['totalBalance'] ?? 'Rp 4.850.000' }}" description="{{ $stats['totalBalanceDesc'] ?? 'Tercatat di Buku Induk' }}" /></section>
    <section class="ns-card mt-8 overflow-hidden">
        <div class="p-5">
            <x-admin.table-search placeholder="Cari nama, no. nasabah, kelas..." target="[data-admin-nasabah-rows] tr" empty="[data-admin-nasabah-empty]" />
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide">
                    <tr>
                        <th class="w-10 px-4 py-4">No</th>
                        <th class="px-3 py-4">Nama Lengkap</th>
                        <th class="px-3 py-4">Kelas / Gugus</th>
                        <th class="px-3 py-4">No. WhatsApp</th>
                        <th class="px-3 py-4 text-center">Total Setor</th>
                        <th class="px-3 py-4 text-right">Saldo Tabungan</th>
                        <th class="px-3 py-4">Status</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody data-admin-nasabah-rows>@foreach($students as $i => $s)
                    <tr data-search="{{ strtolower($s['name'].' '.$s['number'].' '.$s['class'].' '.$s['phone']) }}" data-class="{{ $s['class'] }}" class="border-b border-[#f0eadf]">
                        <td class="px-4 py-4">{{ $i + 1 }}</td>
                        <td class="px-3 py-4"><b class="block">{{ $s['name'] }}</b><small class="text-[#695b51]">Nasabah {{ str_contains($s['class'], 'Guru') ? 'Guru' : 'Siswa' }}</small></td>
                        <td class="px-3 py-4"><span class="rounded bg-[#eee8d7] px-2 py-1 text-xs font-medium">{{ $s['class'] }}</span></td>
                        <td class="px-3 py-4 font-mono text-xs">{{ $s['phone'] }}</td>
                        <td class="px-3 py-4 text-center"><span class="rounded-full bg-[#f8f1df] px-2.5 py-1 text-xs">{{ $s['count'] }} Kali</span></td>
                        <td class="px-3 py-4 text-right font-bold">Rp {{ $s['balance'] }}</td>
                        <td class="px-3 py-4"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-xs">&bull; {{ $s['status'] }}</span></td>
                        <td class="whitespace-nowrap px-4 py-4 text-center"><button type="button" data-nasabah-detail-open data-detail-label="Detail" @foreach($s as $key => $value) data-nd-{{ $key }}="{{ $value }}" @endforeach class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-[#f4ecd7] text-sm font-bold text-[#713b18] hover:bg-[#eadcc5]"><i class="bi bi-eye"></i></button></td>
                </tr>@endforeach
                </tbody>
            </table>
        </div>
        <p data-admin-nasabah-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada nasabah yang sesuai dengan pencarian.</p>
    </section><x-petugas.nasabah-modal />
</x-layouts.petugas>
