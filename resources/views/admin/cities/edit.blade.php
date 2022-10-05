<x-admin.iframe.layout title="Edit City">
    <x-form.container title="City" :iframe-id-to-close="\App\Iframes\CityIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <x-form.input_text name="name" type="text" label="Name" :value="$city->name"/>
            <x-form.input_text name="order" type="text" label="Order" :value="$city->order_by"/>
            <x-form.input_check name="active" type="checkbox" :required="false" label="Active"
                                :value="$city->is_active"/>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
