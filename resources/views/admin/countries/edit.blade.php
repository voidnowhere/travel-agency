<x-admin.iframe.layout title="Edit Residence Category">
    <x-form.container
        title="Country"
        :iframe-id-to-close="\App\Iframes\CountryIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <x-form.input_text name="name" type="text" label="Name" :value="$country->name"/>
            <x-form.input_text name="order" type="text" label="Order" :value="$country->order_by"/>
            <x-form.input_check name="active" type="checkbox" :required="false" label="Active"
                                :value="$country->is_active"/>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
