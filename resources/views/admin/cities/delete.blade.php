<x-admin.iframe.layout title="Delete Residence Category">
    <x-form.layout :delete="true">
        <x-form.submit on-click="confirmDeleteSubmit(event)">Delete</x-form.submit>
    </x-form.layout>
    <x-admin.iframe.js.confirm_d_submit
        :message="$city->name . ' city'"/>
</x-admin.iframe.layout>
