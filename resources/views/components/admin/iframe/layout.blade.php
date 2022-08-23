@props(['title', 'loadCSS' => true, 'loadJquery' => false, 'hClassAlternative' => 'h-screen'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @if($loadCSS)
        @vite('resources/css/app.css')
    @endif
    @if($loadJquery)
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/js/jquery.js')
    @endif
</head>
<body class="{{ $hClassAlternative }}">
{{ $slot }}
</body>
</html>
