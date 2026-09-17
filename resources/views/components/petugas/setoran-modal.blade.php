@props(['waste'])
<div data-setoran-modal class="fixed inset-0 z-[70] hidden overflow-y-auto bg-[#4a1f0d]/75 p-4">
    <section class="mx-auto my-5 w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
        <header class="flex items-center justify-between border-b p-6">
            <div>
                <h2 class="text-xl font-bold"><i class="bi bi-postcard-heart mr-2"></i>Input Setoran Sampah</h2>
                <p class="text-sm text-[#695b51]">Catat penimbangan dan kalkulasi setoran sampah nasabah ke buku tabungan</p>
            </div>
            <button type="button" data-setoran-close class="text-2xl"><i class="bi bi-x-lg"></i></button>
        </header>

        <form method="POST" action="{{ route('petugas.setoran.store') }}" class="p-6" id="form-setoran">
            @csrf

            <label class="ns-label">Pilih Nasabah *</label>
            <div class="relative mt-2">
                <input type="text" id="setoran-cari-nasabah" autocomplete="off" placeholder="Ketik nama atau no. nasabah..."
                    class="ns-input">
                <input type="hidden" name="id_nasabah" id="setoran-id-nasabah" required>

                <div id="setoran-hasil-cari" class="absolute z-10 mt-1 hidden w-full rounded-xl border border-[#e0d6c1] bg-white shadow-lg max-h-48 overflow-y-auto"></div>

                <div id="setoran-nasabah-terpilih" class="mt-2 hidden rounded-xl border border-[#e0d6c1] bg-[#fcf3dd] p-4">
                    <b id="snt-nama"></b>
                    <small class="block" id="snt-kelas"></small>
                    <span class="mt-1 block text-right text-xs">Saldo saat ini: Rp <b id="snt-saldo"></b></span>
                </div>
            </div>

            <label class="ns-label mt-6 block">Jenis Sampah Disetor *</label>
            <input type="hidden" name="id_jenis" id="setoran-id-jenis" required>
            <div class="mt-2 grid gap-2 sm:grid-cols-3">
                @foreach($waste as $index => $item)
                    <button type="button" data-waste-choice
                        data-id="{{ $item['id'] }}"
                        data-price="{{ str_replace('.', '', $item['price']) }}"
                        class="rounded-xl border border-[#ded3bd] bg-[#faf6ec] p-3 text-left">
                        <b class="block text-xs">{{ $item['code'] }}</b>
                        <strong class="mt-2 block text-sm">{{ $item['name'] }}</strong>
                        <span class="mt-3 block text-xs">Rp {{ $item['price'] }} /{{ $item['unit'] }}</span>
                    </button>
                @endforeach
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="ns-label">Berat / Volume Timbangan (Kg) *</label>
                    <input type="number" name="berat" id="setoran-berat" min="0.01" step="0.01" required class="ns-input mt-2">
                </div>
                <div>
                    <label class="ns-label">Harga Pembelian / Satuan</label>
                    <div class="mt-2 rounded-xl bg-[#eee8da] px-4 py-3 font-bold">Rp <span id="setoran-harga-tampil">0</span> / Kg</div>
                </div>
            </div>

            <div class="mt-5 rounded-xl bg-[#f1eadc] p-5">
                <span class="ns-label">Total Nilai Setoran</span>
                <strong class="block text-3xl">Rp <span id="setoran-total-tampil">0</span></strong>
            </div>

            @if($errors->any())
                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-xs text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <footer class="mt-6 flex justify-end gap-3">
                <button type="button" data-setoran-close class="rounded-lg border px-5 py-3 text-sm font-bold">Batal</button>
                <button type="submit" class="rounded-lg bg-[#54220f] px-5 py-3 text-sm font-bold text-white">
                    <i class="bi bi-save mr-2"></i>Simpan Setoran
                </button>
            </footer>
        </form>
    </section>
</div>
