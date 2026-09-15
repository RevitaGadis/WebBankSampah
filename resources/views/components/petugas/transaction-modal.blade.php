<div data-petugas-detail-modal class="fixed inset-0 z-[70] hidden items-center justify-center bg-[#4a1f0d]/75 p-4">
    <section class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl">
        <header class="flex items-center justify-between rounded-t-2xl bg-[#fcf3dd] p-6">
            <div>
                <h2 class="text-xl font-bold">Detail Transaksi Setoran <span
                        class="ml-2 rounded-full bg-[#dce9c9] px-2 py-1 text-xs">Sukses / Terverifikasi</span></h2>
                <p class="text-sm text-[#695b51]">Rincian bukti penerimaan sampah dan kredit saldo nasabah</p>
            </div><button data-petugas-detail-close class="text-2xl">×</button>
        </header>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-3 rounded-xl bg-[#fcf7e9] p-4 text-sm md:grid-cols-4"><span>ID SETORAN<b
                        data-pd-id class="block"></b></span><span>NASABAH<b data-pd-name
                        class="block"></b></span><span>BERAT<b><span data-pd-weight></span> Kg</b></span><span>PETUGAS<b
                        data-pd-officer class="block"></b></span></div>
            <div class="mt-5 rounded-xl border border-[#eee3cf] p-5"><span class="ns-label">ITEM PENIMBANGAN
                    SAMPAH</span>
                <div class="mt-4 flex flex-wrap justify-between gap-4">
                    <div><b data-pd-jenis class="block text-lg"></b><small>Kategori material daur ulang
                            terverifikasi</small></div>
                    <div>Tarif / Kg<b class="block">Rp <span data-pd-price></span></b></div>
                    <div>Subtotal<b class="block text-xl text-[#92591f]">Rp <span data-pd-total></span></b></div>
                </div>
                <div class="mt-5 rounded-lg bg-[#fff4ec] p-4">Saldo Sebelum Setor <span class="float-right">Rp
                        <span data-pd-balance-before></span></span><br><b>Total Saldo Akhir <span class="float-right text-xl">Rp <span data-pd-balance-after></span></span></b>
                </div>
            </div>
        </div>
        <footer class="flex justify-end border-t bg-[#fcf7e9] p-5"><button onclick="window.print()"
                class="rounded-lg bg-[#92591f] px-5 py-2 text-sm font-bold text-white">⇩ Unduh PDF</button></footer>
    </section>
</div>
