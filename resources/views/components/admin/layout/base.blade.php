@props(['loadJquery' => false, 'loadJqueryUI' => false])
    <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cynab Trips</title>
    @vite(['resources/css/app.css', 'resources/js/all.js'])
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"
            integrity="sha512-P0Ms+SM3w8aSbPa5U/nFoprxlUzG2FSz9h/A+2xhhE1hcH6RmGYK3dImFCvcSYuioM3UbbAtMbAopAuHLr94pA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/dist/notiflix-aio-3.2.5.min.js"
            integrity="sha256-LQj8h+SKqntnw8M/FP7QM+3dTqgHvB1JzZMVPD868Rg=" crossorigin="anonymous"></script>
    @if($loadJquery)
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"
                integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    @endif
    @if($loadJqueryUI && $loadJquery)
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
                integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
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
<x-notify.success/>
</body>
</html>
