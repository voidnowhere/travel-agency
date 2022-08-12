<x-admin.iframe.layout title="Delete Housing Formula">
    <x-form.layout :delete="true">
        <x-form.submit on-click="confirmDeleteSubmit(event)">Delete</x-form.submit>
    </x-form.layout>
    <x-admin.iframe.js.confirm_d_submit :message="$housingFormulaName . ' formula'"/>
</x-admin.iframe.layout>
