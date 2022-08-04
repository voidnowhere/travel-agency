@props(['title', 'country' => null])
<x-admin.iframe.layout :title="$title" :load-c-s-s="false">
    <form method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="confirmDeleteSubmit(event)"></button>
    </form>
    <script>
        function confirmDeleteSubmit(event) {
            if (!confirm('Do you really want to delete this {{ ($country === null) ? 'city' : 'country' }}{{ ($country?->cities()->count() > 0) ? ' and its linked cities?' : '?' }}')) {
                event.preventDefault();
            }
        }

        document.querySelector('button').click();
    </script>
</x-admin.iframe.layout>
