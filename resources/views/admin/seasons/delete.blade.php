<x-admin.iframe.layout title="Delete Season">
    <x-form.layout :delete="true">
        <x-form.submit on-click="confirmDeleteSubmit(event)">Delete</x-form.submit>
    </x-form.layout>
    <script>
        function confirmDeleteSubmit(event) {
            if (!confirm('Do you really want to delete ' + '{{ $seasonDetails }}' + ' season?')) {
                event.preventDefault();
            }
        }

        document.querySelector('button').click();
    </script>
</x-admin.iframe.layout>
