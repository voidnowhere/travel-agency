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
