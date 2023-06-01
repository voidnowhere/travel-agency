@props(['loadJquery' => false])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Agency</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/all.js'])
</head>
<body class="bg-blue-50">
<x-loading/>
<div id="content" class="h-screen hidden">
    <header class="h-[10%] flex items-center justify-center selection:bg-none">
        <x-home.nav.layout/>
    </header>
    <main class="min-h-[90%] sm:pt-16 flex flex-col">
        {{ $slot }}
    </main>
</div>
@vite(['resources/js/alpinejs.js', 'resources/js/notiflix.js'])
<x-notiflix.notify.success/>
<x-notiflix.report.error/>
@if($loadJquery)
    @vite('resources/js/jquery.js')
    <x-js.ajax_setup_csrf_token/>
@endif
</body>
</html>
