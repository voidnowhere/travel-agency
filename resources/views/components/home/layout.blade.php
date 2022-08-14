<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cynab Trips</title>
    @vite(['resources/css/app.css', 'resources/js/notiflix.js', 'resources/js/alpinejs.js'])
</head>
<body class="h-screen">
<header class="flex justify-center items-center font-mono h-[10%]">
    <x-home.nav.layout/>
</header>
<main class="min-h-[90%]">
    {{ $slot }}
</main>
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Notify.success("{{ session('success') }}", {
                cssAnimationStyle: 'from-bottom',
                position: 'center-bottom',
                fontFamily: 'mono',
                fontSize: '18px',
            });
        });
    </script>
@endif
</body>
</html>
