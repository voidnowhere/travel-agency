@props(['message'])
<script>
    function confirmDeleteSubmit(event) {
        if (!confirm('Do you really want to delete ' + '{{ $message }}' + '?')) {
            event.preventDefault();
        }
    }

    document.querySelector('button').click();
</script>
