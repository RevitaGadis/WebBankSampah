<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'Petugas' }} — Bank Sampah</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body><x-petugas.sidebar :officer="$officer" />
    <div class="min-h-screen lg:pl-[268px]"><x-petugas.navbar :officer="$officer" />
    <main class="petugas-content mx-auto max-w-[1320px] p-5 lg:p-8">
        @if(session('sukses'))
            <div data-flash class="mb-4 rounded-xl bg-[#dce9c9] p-4 text-sm font-semibold text-[#2f4a12]">
                {{ session('sukses') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-xl bg-red-50 p-4 text-sm font-semibold text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        {{ $slot }}
    </main>
    </div><x-petugas.logout-modal :officer="$officer" />
</body>

</html>
