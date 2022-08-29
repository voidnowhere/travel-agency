<x-admin.iframe.layout title="Delete Country">
    <x-form.layout :delete="true">
        <x-form.submit on-click="confirmDeleteSubmit(event)">Delete</x-form.submit>
    </x-form.layout>
    <x-admin.iframe.js.confirm_d_submit
        :message="($country->name . ' country' . (($country->cities()->count() > 0) ? ' and its linked cities' : ''))"/>
</x-admin.iframe.layout>
