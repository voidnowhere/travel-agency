<x-admin.iframe.layout title="Add Country">
    <x-form.container title="Country" :iframe-id-to-close="\App\Iframes\CountryIframe::$iframeCUId">
        <x-form.layout>
            <x-form.input_text name="name" type="text" label="Name"/>
            <x-form.input_text name="order" type="text" label="Order"/>
            <x-form.input_check name="active" type="checkbox" label="Active" :required="false"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
