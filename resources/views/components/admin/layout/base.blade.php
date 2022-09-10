@props(['loadJquery' => false, 'loadJqueryUI' => false])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cynab Trips</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/all.js'])
    @if($loadJqueryUI)
        @vite('resources/css/jquery-ui.css')
    @endif
</head>
<body class="bg-blue-100">
<script>0</script>
<x-loading/>
<div id="content" class="h-screen flex space-x-5 hidden">
    <aside class="flex flex-col items-center w-60 space-y-7 ml-5 font-mono">
        <h1 class="font-bold text-5xl mt-5 p-1 border-x-4 border-y-4 border-y-blue-400 hover:border-y-transparent hover:border-x-blue-500 transition-colors duration-200 rounded-3xl">
            <a href="{{ route('home') }}" class="hover:cursor-pointer">Cynab</a>
        </h1>
        <x-admin.aside.sidenav.layout/>
    </aside>
    <main class="w-full font-sans flex flex-col pr-5">
        {{ $slot }}
    </main>
</div>
@vite(['resources/js/alpinejs.js', 'resources/js/notiflix.js'])
<x-notiflix.notify.success/>
@if($loadJquery)
    @vite('resources/js/jquery.js')
    <x-js.ajax_setup_csrf_token/>
    @if($loadJqueryUI)
        @vite('resources/js/jquery-ui.js')
    @endif
@endif
</body>
</html>
