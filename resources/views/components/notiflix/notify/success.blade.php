@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Notiflix.Notify.success("{{ session('success') }}", {
                cssAnimationStyle: 'from-bottom',
                position: 'center-bottom',
                fontFamily: 'mono',
                fontSize: '17px',
            });
        });
    </script>
@endif
