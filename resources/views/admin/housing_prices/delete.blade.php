<x-admin.iframe.layout title="Delete Housing Price">
    <x-form.layout :delete="true">
        <x-form.submit on-click="confirmDeleteSubmit(event)">Delete</x-form.submit>
    </x-form.layout>
    <script>
        function confirmDeleteSubmit(event) {
            if (!confirm('Do you really want to delete ' + '{{ $housingPriceName }}' + ' housing price?')) {
                event.preventDefault();
            }
        }

        document.querySelector('button').click();
    </script>
</x-admin.iframe.layout>
