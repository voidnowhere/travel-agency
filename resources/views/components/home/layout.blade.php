@props(['loadJquery' => false])
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
