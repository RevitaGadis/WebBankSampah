<div data-receipt-modal class="fixed inset-0 z-[60] hidden overflow-y-auto bg-[#1c0b04]/50 p-3 sm:p-8">
    <section class="relative mx-auto my-4 max-w-3xl rounded-2xl bg-white p-5 shadow-2xl sm:p-8" role="dialog"
        aria-modal="true" aria-labelledby="receipt-title">
        <button type="button" data-receipt-close
            class="absolute right-4 top-4 grid size-9 place-items-center rounded-full bg-[#f3eddd] text-lg">×</button>
        <header class="flex flex-wrap items-center justify-between gap-4 rounded-xl bg-[#fcf3dd] p-5">
            <div class="flex items-center gap-3"><span
                    class="grid size-14 place-items-center rounded-xl bg-[#54220f] text-2xl text-white">♧</span><span>
                    <h2 id="receipt-title" class="text-xl font-bold">Bank Sampah Sekolah</h2>
                    <p class="text-sm font-semibold text-[#695b51]">SMKN 2 Cimahi</p><b
                        class="text-xs uppercase text-[#92591f]">Bukti penerimaan setoran sampah daur ulang</b>
                </span></div>
            <div class="text-right text-sm"><small>Waktu Penimbangan</small><strong data-receipt-date
                    class="block text-xl"></strong><span data-receipt-time></span></div>
        </header>
        <section class="mt-6 rounded-2xl bg-[#5a270f] p-6 text-white"><span class="ns-label !text-[#dfc5af]">TOTAL NILAI
                PEROLEHAN SETORAN</span><strong class="mt-3 block text-4xl">+ Rp <span data-receipt-total></span> <small
                    class="text-sm font-normal">IDR</small></strong>
            <p class="mt-3 rounded-full bg-white/10 px-4 py-2 text-sm">✿ Saldo bertambah Rp <span
                    data-receipt-total-copy></span> ke buku tabungan digitalmu</p>
        </section>
        <section class="mt-6">
            <div class="flex justify-between gap-4">
                <h3 class="text-xl font-bold">Rincian Timbangan & Nilai</h3><b class="text-xs text-[#695b51]">AUDIT KODE
                    #<span data-receipt-id></span></b>
            </div>
            <div class="mt-3 overflow-hidden rounded-xl bg-[#f8f1df]">
                <div class="grid grid-cols-3 bg-[#e9e0c9] p-3 text-center text-[10px] font-bold uppercase">
                    <span>Parameter / Item</span><span>Spesifikasi & Satuan</span><span>Subtotal / Hasil</span></div>
                <div class="grid grid-cols-3 gap-y-5 p-5 text-sm"><b>● Kategori Sampah</b><b data-receipt-jenis
                        class="text-[#92591f]"></b><span data-receipt-detail></span><b>Berat Bersih (Netto)</b><strong
                        class="text-xl"><span data-receipt-weight></span> Kg</strong><span>Timbangan Digital Loket
                        A</span><b>Tarif Resmi Sekolah</b><span>Rp <span data-receipt-price></span> /
                        Kg</span><span>Katalog SK September 2026</span></div>
                <div class="grid grid-cols-3 border-t border-[#eee2cb] p-5 font-bold"><span>Kalkulasi
                        Konversi</span><span class="font-mono"><span data-receipt-weight-copy></span> Kg × Rp <span
                            data-receipt-price-copy></span></span><span class="text-right text-xl text-[#92591f]">Rp
                        <span data-receipt-total-third></span></span></div>
            </div>
        </section>
        <section class="mt-6 grid gap-4 rounded-xl bg-[#fcf3dd] p-5 md:grid-cols-2">
            <div><span class="ns-label">Saldo Sebelum Setor</span><strong class="block text-2xl">Rp
                    <span data-receipt-balance-before></span></strong><small>Posisi buku tabungan awal</small></div>
            <div class="rounded-lg bg-white p-3"><span class="ns-label text-[#92591f]">Saldo Akhir Setelah
                    Setor</span><strong class="block text-2xl">Rp <span
                        data-receipt-balance></span></strong><small>Terkumulasi secara otomatis</small></div>
        </section>
        <section class="mt-6 rounded-xl bg-[#f8f6f1] p-5"><span class="ns-label">PETUGAS VERIFIKATOR</span><strong
                data-receipt-officer class="block"></strong><small>Piket Timbangan Loket A</small></section><button
            type="button" onclick="window.print()"
            class="mt-8 rounded-xl bg-[#955a25] px-5 py-3 text-sm font-bold text-white">▣ Cetak Salinan Struk
            (PDF)</button>
    </section>
</div>