<x-admin.iframe.layout title="Add Housing Formula">
    <x-form.container title="Housing Formula" :iframe-id-to-close="\App\Iframes\HousingFormulaIframe::$iframeCUId">
        <x-form.layout>
            <x-form.input_text name="name" type="text" label="Name"/>
            <x-form.input_text name="order" type="text" label="Order"/>
            <x-form.input_check name="active" type="checkbox" :required="false" label="Active"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
