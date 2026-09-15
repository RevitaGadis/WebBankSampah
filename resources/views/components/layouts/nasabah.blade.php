<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Portal Nasabah' }} — Bank Sampah</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body><x-nasabah.sidebar :student="$student" />
    <div class="min-h-screen lg:pl-72"><x-nasabah.navbar :student="$student" />
        <main class="mx-auto max-w-[1440px] p-5 lg:p-8">{{ $slot }}</main>
    </div><x-nasabah.logout-modal :student="$student" />
</body>

</html>
