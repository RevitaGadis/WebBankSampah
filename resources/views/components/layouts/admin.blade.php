<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — Bank Sampah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <x-admin.sidebar :admin="$admin"/>
    <div class="min-h-screen lg:pl-[268px]">
        <x-admin.navbar :admin="$admin"/>
        <main class="mx-auto max-w-[1320px] p-5 lg:p-8">
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
    </div>
</body>
</html>