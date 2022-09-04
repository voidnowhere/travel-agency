@props(['title', 'loadCSS' => true, 'loadJquery' => false, 'loadNotiflix' => false, 'hClassAlternative' => 'h-screen'])
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
    @if($loadNotiflix)
        <script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/dist/notiflix-aio-3.2.5.min.js"
                integrity="sha256-LQj8h+SKqntnw8M/FP7QM+3dTqgHvB1JzZMVPD868Rg=" crossorigin="anonymous"></script>
    @endif
</head>
<body class="{{ $hClassAlternative }}">
{{ $slot }}
</body>
</html>
