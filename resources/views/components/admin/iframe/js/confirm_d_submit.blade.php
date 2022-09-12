@props(['message', 'iframeDId'])
<script>
    let iframeD = parent.document.getElementById('{{ $iframeDId }}');
    iframeD.classList.remove('hidden');
    document.addEventListener('DOMContentLoaded', function () {
        Confirm.show(
            'Confirm',
            'Do you really want to delete ' + '{{ $message }}' + '?',
            'Yes',
            'No',
            () => {
                document.querySelector('button').click();
            },
            () => {
                iframeD.classList.add('hidden');
            },
            {
                backOverlay: false,
            },
        );
    });
</script>
