@props(['transactions', 'rows' => 'data-petugas-transaction-rows', 'perPage' => 10])
<div class="overflow-x-auto">
    <table class="w-full min-w-[1180px] text-sm">
        <thead class="bg-[#f8f1df] text-left text-[10px] uppercase tracking-wide text-[#695b51]">
            <tr>
                <th class="w-[8%] px-5 py-4">No. Transaksi</th>
                <th class="w-[11%] px-3 py-4">Waktu &amp; Tanggal</th>
                <th class="w-[16%] px-3 py-4">Identitas Nasabah</th>
                <th class="w-[13%] px-3 py-4">Komoditas Sampah</th>
                <th class="w-[7%] px-3 py-4 text-right">Berat<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(kg)</small></th>
                <th class="w-[9%] px-3 py-4 text-right">Tarif / Kg<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                <th class="w-[11%] px-3 py-4 text-right">Total Nilai<small class="mt-0.5 block text-[9px] font-medium normal-case tracking-normal">(Rp)</small></th>
                <th class="w-[12%] px-3 py-4">Petugas Validasi</th>
                <th class="w-[7%] px-3 py-4 text-center">Status</th>
                <th class="w-[6%] px-5 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody {{ $rows }}>
            @forelse ($transactions as $t)
                <tr data-search="{{ strtolower($t['id'].' '.$t['name'].' '.$t['number'].' '.$t['class'].' '.$t['jenis'].' '.$t['officer']) }}" class="border-b border-[#f0eadf] even:bg-[#fffdf8] last:border-0">
                    <td class="px-5 py-4 font-mono text-xs font-bold text-[#713b18]">{{ $t['id'] }}</td>
                    <td class="px-3 py-4"><span class="block">{{ $t['date'] }}</span><small class="mt-1 block text-[#695b51]">{{ $t['time'] }}</small></td>
                    <td class="px-3 py-4"><b class="block">{{ $t['name'] }}</b><small class="mt-0.5 block text-[#695b51]">{{ $t['number'] }} &bull; {{ $t['class'] }}</small></td>
                    <td class="px-3 py-4"><span class="inline-block max-w-full truncate rounded-full bg-[#f4ecd7] px-3 py-1 text-xs font-semibold">{{ $t['jenis'] }}</span></td>
                    <td class="px-3 py-4 text-right font-mono text-xs font-bold">{{ $t['weight'] }}</td>
                    <td class="px-3 py-4 text-right font-mono text-xs">{{ $t['price'] }}</td>
                    <td class="px-3 py-4 text-right font-mono text-xs font-bold text-[#92591f]">{{ $t['total'] }}</td>
                    <td class="px-3 py-4 text-xs">{{ $t['officer'] }}</td>
                    <td class="px-3 py-4 text-center"><span class="rounded-full bg-[#dce9c9] px-2 py-1 text-[10px] font-bold">{{ $t['status'] }}</span></td>
                    <td class="whitespace-nowrap px-5 py-4 text-center"><button type="button" title="Lihat detail transaksi {{ $t['id'] }}" data-petugas-detail-open data-id="{{ $t['id'] }}" data-name="{{ $t['name'] }}" data-jenis="{{ $t['jenis'] }}" data-weight="{{ $t['weight'] }}" data-price="{{ $t['price'] }}" data-total="{{ $t['total'] }}" data-officer="{{ $t['officer'] }}" data-balance-before="{{ $t['balance_before'] ?? '' }}" data-balance-after="{{ $t['balance_after'] ?? '' }}" class="rounded-lg bg-[#f4ecd7] px-2.5 py-1.5 text-[10px] font-bold text-[#713b18] hover:bg-[#eadcc5]">Lihat</button></td>
                </tr>
            @empty
                <tr data-page-ignore><td colspan="10" class="px-5 py-10 text-center text-sm text-[#695b51]">Belum ada transaksi setoran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-admin.table-pagination rows="[{{ $rows }}] tr" label="transaksi" :per-page="$perPage" />
