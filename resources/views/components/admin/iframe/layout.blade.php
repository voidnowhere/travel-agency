@props(['title', 'loadCSS' => true, 'loadJquery' => false, 'loadNotiflix' => false, 'hClassAlternative' => 'h-screen'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($loadCSS)
        @vite('resources/css/app.css')
    @endif
</head>
<body class="{{ $hClassAlternative }}">
{{ $slot }}
@if($loadNotiflix)
    @vite('resources/js/notiflix.js')
@endif
@if($loadJquery)
    @vite('resources/js/jquery.js')
    <x-js.ajax_setup_csrf_token/>
@endif
</body>
</html>
