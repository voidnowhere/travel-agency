@props(['loadJquery' => false])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cynab Trips</title>
    @vite(['resources/css/app.css', 'resources/js/all.js', 'resources/js/notiflix.js', 'resources/js/alpinejs.js'])
    @if($loadJquery)
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/js/jquery.js')
    @endif
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
<x-notify.success/>
</body>
</html>
