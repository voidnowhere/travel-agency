<x-admin.iframe.layout title="Delete Housing Price">
    <x-form.layout :delete="true">
        <x-form.submit on-click="confirmDeleteSubmit(event)">Delete</x-form.submit>
    </x-form.layout>
    <x-admin.iframe.js.confirm_d_submit :message="$housingPriceName . ' housing price'"/>
</x-admin.iframe.layout>
