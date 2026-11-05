<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Bank Sampah Sekolah — Tabung Sampah, Tumbuhkan Manfaat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    {{-- NAVBAR --}}
    <header class="sticky top-0 z-30 border-b border-[#eee5d2] bg-[#fffdf7]/95 backdrop-blur">
        <div class="page-width flex items-center justify-between gap-4 py-3.5">
            <a href="#beranda" class="shrink-0">
                <strong class="block text-[14px] leading-none tracking-tight">Bank Sampah Sekolah</strong>
                <small class="mt-1 block text-[9px] text-[#8b7e75]">Sistem Informasi &amp; Tabungan Sampah</small>
            </a>

            <nav class="hidden items-center gap-8 text-[11px] font-semibold text-[#66584b] md:flex">
                <a href="#beranda" class="text-[#92591f]">Beranda</a>
                <a href="#transparansi" class="hover:text-[#92591f]">Transparansi</a>
                <a href="#tarif" class="hover:text-[#92591f]">Tarif Sampah</a>
                <a href="#cara-kerja" class="hover:text-[#92591f]">Cara Kerja</a>
            </nav>

            <a href="{{ route('login') }}" class="brown-button !rounded-lg !px-5 !py-2.5 !text-[11px]">Masuk</a>
        </div>
    </header>

    {{-- HERO --}}
    <section id="beranda" class="page-width grid items-center gap-8 pb-14 pt-14 md:grid-cols-2 md:gap-12 md:pb-16 md:pt-16">
        <div class="max-w-[540px]">
            <h1 class="text-[clamp(36px,4.5vw,54px)] font-extrabold leading-[1.08] tracking-[-.055em]">
                Tabung Sampah,<br>
                <span class="text-[#87512b]">Tumbuhkan Manfaat</span>
            </h1>
            <p class="mt-5 max-w-[490px] text-[13px] leading-[1.8] text-[#76685b]">
                Setiap setoran tercatat, setiap harga terbuka, setiap saldo bisa dipantau. Mengubah sisa konsumsi sekolah menjadi portofolio tabungan siswa yang terukur dan terpercaya.
            </p>

            <div class="mt-6 flex flex-wrap gap-2.5">
                <a href="{{ route('login') }}" class="brown-button">Masuk ke Akun <i class="bi bi-arrow-right"></i></a>
                <a href="#transparansi" class="light-button"><i class="bi bi-bar-chart-line"></i> Lihat Transparansi</a>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-x-5 gap-y-3">
                <div>
                    <strong class="block text-[18px] font-extrabold">100%</strong>
                    <span class="text-[10px] text-[#8b7e75]">Audit Digital</span>
                </div>
                <div class="h-8 w-px bg-[#e5dac6]"></div>
                <div>
                    <strong class="block text-[18px] font-extrabold">0 Potongan</strong>
                    <span class="text-[10px] text-[#8b7e75]">Biaya Layanan</span>
                </div>
                <div class="h-8 w-px bg-[#e5dac6]"></div>
                <div>
                    <strong class="block text-[18px] font-extrabold">Presisi</strong>
                    <span class="text-[10px] text-[#8b7e75]">Timbangan Digital</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center md:justify-end">
            <img src="{{ asset('images/hero-sampah.png') }}" alt="Ilustrasi tempat sampah daur ulang"
                 class="w-full max-w-[440px] object-contain">
        </div>
    </section>

    {{-- TRANSPARANSI --}}
    <section id="transparansi" class="bg-[#f7f0dc] py-12 md:py-14">
        <div class="page-width">
            <div class="grid items-end gap-3 md:grid-cols-2">
                <div>
                    <span class="eyebrow"><i class="bi bi-bar-chart-fill"></i> Data Real-Time Sistem</span>
                    <h2 class="section-title">Transparansi dalam Angka</h2>
                </div>
                <p class="section-copy max-w-[390px] md:justify-self-end">
                    Semua catatan akumulasi agregat dapat dilihat oleh komite sekolah, wali murid, dan seluruh civitas akademika untuk menjaga keterbukaan.
                </p>
            </div>

            <div class="mt-7 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div class="ns-card p-5">
                    <span class="icon-tile"><i class="bi bi-people-fill"></i></span>
                    <strong class="mt-4 block text-[27px] font-extrabold leading-none">{{ $stats['totalNasabah'] }}</strong>
                    <span class="mt-2 block text-[12px] font-semibold">Total Nasabah</span>
                    <small class="mt-1 block text-[10px] text-[#a39789]">Siswa &amp; Guru Terdaftar</small>
                </div>
                <div class="ns-card p-5">
                    <span class="icon-tile !bg-[#e8efd9] !text-[#5e7d42]"><i class="bi bi-recycle"></i></span>
                    <strong class="mt-4 block text-[27px] font-extrabold leading-none">{{ $stats['totalBerat'] }} <span class="text-[15px]">Kg</span></strong>
                    <span class="mt-2 block text-[12px] font-semibold">Total Sampah Terkumpul</span>
                    <small class="mt-1 block text-[10px] text-[#a39789]">Tercatat Sejak Sistem Berjalan</small>
                </div>
                <div class="ns-card p-5">
                    <span class="icon-tile !bg-[#f8e4cf] !text-[#ae7137]"><i class="bi bi-cash-stack"></i></span>
                    <strong class="mt-4 block text-[25px] font-extrabold leading-none">Rp {{ $stats['totalNilai'] }}</strong>
                    <span class="mt-2 block text-[12px] font-semibold">Total Nilai Setoran</span>
                    <small class="mt-1 block text-[10px] text-[#a39789]">Akumulasi Nilai Setoran</small>
                </div>
                <div class="ns-card p-5">
                    <span class="icon-tile !bg-[#eee7d8] !text-[#80623e]"><i class="bi bi-calendar-check-fill"></i></span>
                    <strong class="mt-4 block text-[27px] font-extrabold leading-none">{{ $stats['setoranBulanIni'] }} <span class="text-[15px]">Sesi</span></strong>
                    <span class="mt-2 block text-[12px] font-semibold">Setoran Bulan Ini</span>
                    <small class="mt-1 block text-[10px] text-[#a39789]">{{ now()->translatedFormat('F Y') }}</small>
                </div>
            </div>

            <p class="mt-5 flex items-center justify-center gap-2 text-center text-[10px] text-[#a39789]">
                <i class="bi bi-info-circle"></i>
                Angka diperbarui otomatis berdasarkan data nasabah dan transaksi yang tercatat.
            </p>
        </div>
    </section>

    {{-- TARIF SAMPAH --}}
    <section id="tarif" class="page-width py-14 md:py-16">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="eyebrow"><i class="bi bi-patch-check-fill"></i> Standar Harga Resmi</span>
                <h2 class="section-title">Tarif Sampah</h2>
                <p class="mt-1 text-[12px] text-[#817367]">Harga Transparan per Kilogram</p>
            </div>
            <p class="max-w-[330px] rounded-xl bg-[#f5edda] px-4 py-3 text-[10px] leading-relaxed text-[#817367]">
                <strong class="text-[#62452d]">Jaminan Kepastian:</strong> harga yang tercantum adalah tarif resmi dan berlaku untuk setiap kategori sampah.
            </p>
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <button type="button" data-tarif-filter="semua" class="tarif-filter active">Semua Kategori</button>
            <button type="button" data-tarif-filter="plastik" class="tarif-filter">Plastik</button>
            <button type="button" data-tarif-filter="kertas" class="tarif-filter">Kertas &amp; Kardus</button>
            <button type="button" data-tarif-filter="logam" class="tarif-filter">Logam</button>
            <button type="button" data-tarif-filter="minyak" class="tarif-filter">Minyak</button>
        </div>

        <div data-tarif-rows class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($waste as $item)
                @php
                    $kategoriLabel = match ($item['category']) {
                        'plastik' => 'Kemasan Terpilah',
                        'kertas' => 'Kertas & Kardus',
                        'logam' => 'Logam & Kaleng',
                        'minyak' => 'Limbah Cair',
                        default => 'Kategori Lainnya',
                    };
                    $kategoriIcon = match ($item['category']) {
                        'plastik' => 'bi-recycle',
                        'kertas' => 'bi-file-earmark-text',
                        'logam' => 'bi-box-seam',
                        'minyak' => 'bi-droplet',
                        default => 'bi-trash',
                    };
                    $kategoriWarna = match ($item['category']) {
                        'logam' => 'bg-[#f8e5d2] text-[#a66a37]',
                        'minyak' => 'bg-[#e8efd9] text-[#5e7d42]',
                        default => 'bg-[#f8e8d4] text-[#95602b]',
                    };
                @endphp
                <article data-tarif-item data-category="{{ $item['category'] }}" class="tarif-card">
                    <div class="flex items-center justify-between gap-2">
                        <span class="rounded-md bg-[#f6efdf] px-2 py-1 text-[8px] font-extrabold tracking-wide text-[#80603b]">{{ $item['code'] }}</span>
                        <span class="text-right text-[8px] font-bold text-[#8b7e75]">{{ $kategoriLabel }}</span>
                    </div>

                    <div class="mt-3 flex min-w-0 items-start gap-2.5">
                        <span class="tarif-icon {{ $kategoriWarna }}"><i class="bi {{ $kategoriIcon }}"></i></span>
                        <div class="min-w-0">
                            <strong class="block text-[12px] font-extrabold leading-snug text-[#3c281b]">{{ $item['name'] }}</strong>
                            <p class="mt-1 text-[9px] leading-[1.45] text-[#8a7c6e]">
                                {{ $item['category'] === 'plastik' ? 'Material plastik yang dipilah dan disetorkan sesuai jenisnya.' : '' }}
                                {{ $item['category'] === 'kertas' ? 'Kertas dan kemasan karton yang sudah dipisahkan.' : '' }}
                                {{ $item['category'] === 'logam' ? 'Material logam dan kaleng yang dapat didaur ulang.' : '' }}
                                {{ $item['category'] === 'minyak' ? 'Minyak jelantah yang dikumpulkan dalam wadah tertutup.' : '' }}
                                {{ $item['category'] === 'lainnya' ? 'Jenis sampah yang diterima sesuai ketentuan bank sampah.' : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="tarif-price">
                        <span class="text-[9px] font-medium text-[#817367]">Tarif Nasabah</span>
                        <strong class="whitespace-nowrap text-[13px] font-extrabold text-[#542511]">
                            Rp {{ $item['price'] }}<span class="ml-0.5 text-[9px] font-semibold text-[#817367]">/ Kg</span>
                        </strong>
                    </div>
                </article>
            @endforeach
        </div>
        <p data-tarif-empty class="mt-6 hidden text-center text-[12px] text-[#8b7e75]">Belum ada jenis sampah pada kategori ini.</p>
    </section>

    {{-- CARA KERJA --}}
    <section id="cara-kerja" class="bg-[#f4edd9] py-14 md:py-16">
        <div class="page-width">
            <div class="text-center">
                <span class="eyebrow"><i class="bi bi-signpost-split-fill"></i> Alur Sederhana &amp; Terbuka</span>
                <h2 class="section-title">Cara Kerja Bank Sampah</h2>
                <p class="section-copy mx-auto mt-2 max-w-[520px]">
                    Empat tahapan terstruktur yang memastikan setiap kontribusi sampah menjadi manfaat nyata.
                </p>
            </div>

            <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['icon' => 'bi-box-seam-fill', 'title' => 'Kumpulkan Sampah', 'desc' => 'Pilah sampah anorganik sesuai kategori yang sudah ditetapkan sekolah.'],
                    ['icon' => 'bi-shop', 'title' => 'Setor ke Petugas', 'desc' => 'Bawa sampah ke loket piket untuk ditimbang oleh petugas yang bertugas.'],
                    ['icon' => 'bi-calculator-fill', 'title' => 'Sistem Hitung Otomatis', 'desc' => 'Berat dikali tarif resmi saat itu juga dan langsung tercatat ke sistem.'],
                    ['icon' => 'bi-wallet2', 'title' => 'Pantau Saldo Online', 'desc' => 'Saldo bertambah otomatis dan bisa dipantau kapan saja lewat portal.'],
                ] as $i => $step)
                    <article class="ns-card step-card p-5">
                        <span class="step-number">{{ $i + 1 }}</span>
                        <i class="bi {{ $step['icon'] }} mt-4 block text-[22px] text-[#a16d37]"></i>
                        <strong class="mt-3 block text-[13px] font-bold">{{ $step['title'] }}</strong>
                        <p class="mt-2 text-[10px] leading-[1.7] text-[#817367]">{{ $step['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- AKTIVITAS SETORAN --}}
    <section class="page-width py-14 md:py-16">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <span class="eyebrow"><i class="bi bi-journal-text"></i> Catatan Setoran Terbuka</span>
                <h2 class="section-title">Aktivitas Setoran Terbaru</h2>
            </div>
            <small class="text-[10px] text-[#8b7e75]"><i class="bi bi-shield-lock"></i> Nama disamarkan untuk menjaga privasi.</small>
        </div>

        <div class="ns-card mt-5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Identitas Nasabah</th>
                            <th>Jenis Komoditas</th>
                            <th>Gramasi</th>
                            <th class="text-right">Nilai Rupiah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $t)
                            @php
                                $jenisLower = strtolower($t['jenis']);
                                $jenisLabel = str_contains($jenisLower, 'plastik') || str_contains($jenisLower, 'botol')
                                    ? 'PLASTIK'
                                    : (str_contains($jenisLower, 'kertas') || str_contains($jenisLower, 'kardus') || str_contains($jenisLower, 'dupleks')
                                        ? 'KERTAS'
                                        : (str_contains($jenisLower, 'kaleng') || str_contains($jenisLower, 'alumin') || str_contains($jenisLower, 'logam')
                                            ? 'LOGAM'
                                            : (str_contains($jenisLower, 'minyak') ? 'MINYAK' : 'LAINNYA')));
                            @endphp
                            <tr>
                                <td class="text-[#8b7e75]"><i class="bi bi-clock mr-1"></i>{{ $t['time'] }}</td>
                                <td>
                                    <strong class="font-extrabold text-[#493326]">{{ $t['identity'] }}</strong>
                                    <small class="ml-1 text-[9px] text-[#a39789]">({{ $t['class'] }})</small>
                                </td>
                                <td>
                                    <span class="activity-code">{{ $jenisLabel }}</span>
                                    <span class="font-semibold text-[#594638]">{{ $t['jenis'] }}</span>
                                </td>
                                <td class="font-semibold text-[#594638]">{{ $t['weight'] }}</td>
                                <td class="text-right">
                                    <span class="activity-money"><i class="bi bi-plus-lg mr-1 text-[8px]"></i>Rp {{ $t['total'] }}</span>
                                </td>
                                <td>
                                    <span class="status-pill"><i class="bi bi-check-circle-fill"></i> Terverifikasi Lunas</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-[#8b7e75]">Belum ada transaksi yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- PERAN & HAK AKSES --}}
    <section class="bg-[#f7f0df] py-14 md:py-16">
        <div class="page-width">
            <div class="text-center">
                <span class="eyebrow"><i class="bi bi-shield-lock-fill"></i> Peran &amp; Hak Akses</span>
                <h2 class="section-title">Dirancang untuk Seluruh Warga Sekolah</h2>
                <p class="section-copy mx-auto mt-2 max-w-[540px]">
                    Pemisahan modul berlapis agar setiap pengguna hanya mengakses fitur yang relevan dengan tugasnya.
                </p>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <article class="ns-card p-5">
                    <span class="icon-tile"><i class="bi bi-person-badge-fill"></i></span>
                    <strong class="mt-4 block text-[15px] font-bold">Admin</strong>
                    <p class="mt-2 text-[11px] leading-[1.7] text-[#817367]">Mengelola seluruh data pengguna, mengatur harga komoditas, dan mengawasi monitoring secara menyeluruh.</p>
                    <a href="{{ route('login') }}" class="mt-4 inline-flex items-center gap-1 text-[10px] font-extrabold text-[#92591f]">Modul Master &amp; Akses Admin <i class="bi bi-arrow-right"></i></a>
                </article>

                <article class="ns-card p-5">
                    <span class="icon-tile"><i class="bi bi-person-workspace"></i></span>
                    <strong class="mt-4 block text-[15px] font-bold">Petugas Loket</strong>
                    <p class="mt-2 text-[11px] leading-[1.7] text-[#817367]">Melakukan pencatatan penimbangan, input setoran, dan pemutakhiran saldo nasabah secara langsung.</p>
                    <a href="{{ route('login') }}" class="mt-4 inline-flex items-center gap-1 text-[10px] font-extrabold text-[#92591f]">Modul Operasional Timbang <i class="bi bi-arrow-right"></i></a>
                </article>

                <article class="ns-card p-5">
                    <span class="icon-tile !bg-[#e8efd9] !text-[#5e7d42]"><i class="bi bi-wallet-fill"></i></span>
                    <strong class="mt-4 block text-[15px] font-bold">Nasabah (Siswa &amp; Guru)</strong>
                    <p class="mt-2 text-[11px] leading-[1.7] text-[#817367]">Melihat saldo tabungan secara mandiri, memantau riwayat setoran berkala, dan mengecek buku tabungan.</p>
                    <a href="{{ route('login') }}" class="mt-4 inline-flex items-center gap-1 text-[10px] font-extrabold text-[#92591f]">Modul Portofolio Tabungan <i class="bi bi-arrow-right"></i></a>
                </article>
            </div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section class="page-width py-14 text-center md:py-16">
        <span class="eyebrow"><i class="bi bi-award-fill"></i> Akuntabilitas Tingkat Tinggi</span>
        <h2 class="section-title">Keunggulan Sistem Bank Sampah</h2>
        <p class="section-copy mx-auto mt-2 max-w-[540px]">
            Pondasi arsitektur perangkat lunak yang dirancang untuk menjaga kepercayaan dan cara olah limbah.
        </p>

        <div class="mt-8 grid gap-4 text-left sm:grid-cols-3">
            <article class="ns-card p-5">
                <span class="icon-tile"><i class="bi bi-calculator"></i></span>
                <strong class="mt-4 block text-[13px] font-bold">Perhitungan Otomatis</strong>
                <p class="mt-2 text-[10px] leading-[1.7] text-[#817367]">Nilai setoran dihitung sistem saat itu juga, mengurangi risiko salah hitung manual.</p>
            </article>
            <article class="ns-card p-5">
                <span class="icon-tile"><i class="bi bi-lock-fill"></i></span>
                <strong class="mt-4 block text-[13px] font-bold">Data Aman dan Terenkripsi</strong>
                <p class="mt-2 text-[10px] leading-[1.7] text-[#817367]">Kata sandi dan PIN disimpan secara aman, tidak tersimpan sebagai teks biasa.</p>
            </article>
            <article class="ns-card p-5">
                <span class="icon-tile"><i class="bi bi-clock-history"></i></span>
                <strong class="mt-4 block text-[13px] font-bold">Riwayat Terjaga</strong>
                <p class="mt-2 text-[10px] leading-[1.7] text-[#817367]">Setiap transaksi tersimpan dan dapat ditelusuri kapan saja oleh pihak berwenang.</p>
            </article>
        </div>
    </section>

    {{-- CTA --}}
    <section class="page-width pb-14 md:pb-16">
        <div class="overflow-hidden rounded-[22px] bg-gradient-to-r from-[#431b0e] via-[#542511] to-[#754126] px-6 py-10 text-white shadow-lg md:px-12 md:py-12">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[9px] font-bold uppercase tracking-wider text-[#f0d5a8]">
                <i class="bi bi-rocket-takeoff-fill"></i> Mulai Setoran Pertamamu di Sini
            </span>
            <h2 class="mt-4 text-[26px] font-extrabold leading-tight tracking-tight md:text-[32px]">Mulai Menabung Sampah Hari Ini</h2>
            <p class="mt-2 max-w-[490px] text-[12px] leading-[1.8] text-white/70">
                Ubah sampah sekolah menjadi saldo tabungan nyata dengan sistem pencatatan yang transparan dan akuntabel.
            </p>
            <a href="{{ route('login') }}" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-[#fff9ec] px-5 py-3 text-[11px] font-extrabold text-[#542511] transition hover:bg-white">
                Masuk ke Akun Bank Sampah <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-[#eee5d2] bg-[#f7f0df] py-9">
        <div class="page-width grid gap-7 sm:grid-cols-2">
            <div>
                <strong class="flex items-center gap-2 text-[13px]"><i class="bi bi-recycle text-[#95602b]"></i> Bank Sampah Sekolah</strong>
                <p class="mt-2 max-w-[390px] text-[10px] leading-[1.8] text-[#817367]">
                    Platform tata kelola dan edukasi lingkungan sekolah. Mengubah limbah bernilai menjadi tabungan siswa yang akuntabel dan terukur.
                </p>
            </div>
            <div>
                <strong class="text-[13px]">Pemberitahuan Transparansi</strong>
                <p class="mt-2 max-w-[390px] text-[10px] leading-[1.8] text-[#817367]">
                    Data agregat di halaman ini diperbarui berdasarkan catatan transaksi dan data nasabah yang tersimpan di sistem.
                </p>
            </div>
        </div>
        <div class="page-width mt-7 border-t border-[#e9dfca] pt-4 text-[9px] text-[#968a7b]">
            &copy; {{ date('Y') }} Bank Sampah Sekolah. Semua hak dilindungi.
        </div>
    </footer>

    <script>
        document.querySelectorAll('[data-tarif-filter]').forEach((button) => {
            button.addEventListener('click', () => {
                document.querySelectorAll('[data-tarif-filter]').forEach((item) => {
                    item.classList.remove('active');
                });
                button.classList.add('active');

                const kategori = button.dataset.tarifFilter;
                const items = [...document.querySelectorAll('[data-tarif-item]')];
                let visibleCount = 0;

                items.forEach((item) => {
                    const cocok = kategori === 'semua' || item.dataset.category === kategori;
                    item.classList.toggle('hidden', !cocok);
                    if (cocok) visibleCount += 1;
                });

                document.querySelector('[data-tarif-empty]').classList.toggle('hidden', visibleCount !== 0);
            });
        });
    </script>
</body>
</html>
