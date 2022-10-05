<x-admin.iframe.layout title="Add City">
    <x-form.container title="City" :iframe-id-to-close="\App\Iframes\CityIframe::$iframeCUId">
        <x-form.layout>
            <x-form.input_text name="name" type="text" label="Name"/>
            <x-form.input_text name="order" type="text" label="Order"/>
            <x-form.input_check name="active" type="checkbox" :required="false" label="Active"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
