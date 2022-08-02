<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cynab Trips</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen flex bg-blue-100 space-x-5">
<aside class="flex flex-col items-center w-60 space-y-7 ml-5 font-mono">
    <h1 class="font-bold text-5xl mt-5 p-1 border-x-4 border-y-4 border-y-blue-400 hover:border-y-transparent hover:border-x-blue-500 transition-all duration-200 rounded-3xl">
        <a href="{{ route('home') }}" class="hover:cursor-pointer">Cynab</a>
    </h1>
    <x-admin.aside.sidenav/>
</aside>
<main class="w-full font-sans flex flex-col">
    {{ $slot }}
</main>
</body>
</html>
