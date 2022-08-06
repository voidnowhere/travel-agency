<script>
    function showCUIframe(id, src) {
        let iframe = parent.document.getElementById(id);
        iframe.src = src;
        iframe.classList.remove('hidden');
    }
</script>
