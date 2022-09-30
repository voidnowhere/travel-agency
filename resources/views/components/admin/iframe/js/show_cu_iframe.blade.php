@props(['iframeIdToCLose' => null])
<script>
    function showCUIframe(id, src) {
        @if($iframeIdToCLose)
            parent.document.getElementById('{{ $iframeIdToCLose }}').classList.add('hidden');
        @endif
        let iframe = parent.document.getElementById(id);
        iframe.src = src;
        iframe.classList.remove('hidden');
    }
</script>
