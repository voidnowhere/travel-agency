@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Report.failure(
                'Error',
                '{{ session('error') }}',
                'Okay',
                {
                    backOverlay: false,
                },
            );
        });
    </script>
@endif
