<x-admin.iframe.layout title="Edit Residence Category">
    <x-form.container
        title="Residence Category"
        :iframe-id-to-close="\App\Iframes\ResidenceCategoryIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <x-form.input_text name="name" type="text" label="Name" :value="$residenceCategory->name"/>
            <x-form.input_text name="order" type="text" label="Order" :value="$residenceCategory->order_by"/>
            <x-form.input_check name="is_active" type="checkbox" :required="false" label="Active"
                                :value="$residenceCategory->is_active"/>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
