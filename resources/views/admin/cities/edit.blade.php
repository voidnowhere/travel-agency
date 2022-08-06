<x-admin.iframe.layout title="Edit Residence Category">
    <x-form.container
        title="City"
        :iframe-id-to-close="\App\Iframes\CityIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <x-form.input_text name="name" type="text" label="Name" :value="$city->name"/>
            @if($city->country->is_active)
                <x-form.input_check name="is_active" type="checkbox" :required="false" label="Active"
                                    :value="$city->is_active"/>
            @endif
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
