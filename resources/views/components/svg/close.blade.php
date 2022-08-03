@props(['class', 'iframeIdToClose'])
<svg class="{{ $class }}"
     onclick="closeIframe()"
     fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
</svg>
<script>
    function closeIframe() {
        const iframe = parent.document.getElementById('{{ $iframeIdToClose }}');
        iframe.classList.add('hidden');
        iframe.src = '';
    }
</script>
