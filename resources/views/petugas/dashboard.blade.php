<x-layouts.petugas title="Dashboard Petugas" :officer="$officer">
    <section class="rounded-2xl bg-[#f5edda] p-6"><span class="rounded-full bg-[#ece4d2] px-3 py-1 text-xs font-bold">▣
            {{ $stats['currentDate'] }}</span>
        <div class="mt-3 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">Dashboard Pengelola</h1>
                <p class="text-[#695b51]">Selamat datang kembali, {{ $officer['name'] }} • Panel operasional timbang dan
                    tabungan bank sampah sekolah hari ini.</p>
            </div><button data-setoran-open class="rounded-lg bg-[#92591f] px-6 py-3 text-sm font-bold text-white">⊕ +
                Catat Setoran Baru</button>
        </div>
    </section>
    <section class="mt-3 grid gap-4 md:grid-cols-2"><x-nasabah.stat-card label="Setoran Hari Ini" value="{{ $stats['todayDeposits'] ?? '23 Setoran' }}"
            description="{{ $stats['todayDepositsDesc'] ?? 'Naik 5 setoran dari kemarin' }}" /><x-nasabah.stat-card label="Berat Terpilah Hari Ini"
            value="{{ $stats['todayWeight'] ?? '148.6 Kg' }}" description="{{ $stats['todayWeightDesc'] ?? 'Rata-rata 6.5 kg / setoran' }}" /><x-nasabah.stat-card label="Transaksi Hari Ini"
            value="{{ $stats['todayTransactions'] ?? '21 Transaksi' }}" description="{{ $stats['todayTransactionsDesc'] ?? 'Semua sudah dibayar tunai' }}" /><x-nasabah.stat-card
            label="Total Kas & Saldo Hari Ini" value="{{ $stats['todayBalance'] ?? 'Rp 412.500' }}" description="{{ $stats['todayBalanceDesc'] ?? 'Naik Rp 68.000 dari kemarin' }}" /></section>
    <section class="ns-card mt-4 overflow-hidden">
        <div class="p-5">
            <x-admin.table-search placeholder="Cari ID, nasabah, kelas..." target="[data-admin-dashboard-rows] tr" empty="[data-admin-dashboard-empty]" />
        </div>
        <div class="overflow-x-auto"><x-petugas.transaction-table :transactions="$transactions" /></div>
        <p data-admin-dashboard-empty class="hidden p-6 text-center text-sm text-[#695b51]">Tidak ada transaksi yang sesuai dengan pencarian.</p>
    </section><x-petugas.setoran-modal :waste="$waste" /><x-petugas.transaction-modal />
</x-layouts.petugas>