@props(['title', 'loadCSS' => true])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @if($loadCSS)
        @vite('resources/css/app.css')
    @endif
</head>
<body class="h-screen">
{{ $slot }}
</body>
</html>
