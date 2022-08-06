<script>
    function focusTableTr(tabindex) {
        document.querySelectorAll('tr').forEach(tr => {
            tr.classList.remove('bg-blue-50');
        });
        document.querySelector(`tr[tabindex="${tabindex}"]`).classList.add('bg-blue-50');
    }
</script>
