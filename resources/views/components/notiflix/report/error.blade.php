@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Notiflix.Report.failure(
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
