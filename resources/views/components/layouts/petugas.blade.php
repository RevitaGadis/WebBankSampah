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
        <main class="petugas-content mx-auto max-w-[1320px] p-5 lg:p-8">{{ $slot }}</main>
    </div><x-petugas.logout-modal :officer="$officer" />
</body>

</html>
