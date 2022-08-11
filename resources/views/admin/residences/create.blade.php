<x-admin.iframe.layout title="Add Residence" :load-jquery="true">
    <x-form.container
        title="Residence"
        :iframe-id-to-close="\App\Iframes\ResidenceIframe::$iframeCUId">
        <x-form.layout>
            <div class="grid grid-cols-2">
                <div class="mt-2">
                    <x-form.input_text name="name" type="text" label="Name"/>
                </div>
                <x-residence-category-select/>
            </div>
            <div class="grid grid-cols-2">
                <x-country-select on-change="getCities()"/>
                <x-city-select :country="\App\Models\Country::find(old('country')) ?? (new \App\Models\Country)"
                               :default="false"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="website" type="text" label="Website"/>
                <x-form.input_text name="email" type="email" label="Email"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="contact" type="text" label="Contact"/>
                <x-form.input_text name="order" type="text" label="Order"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="tax" type="text" label="Tax"/>
                <x-form.input_check name="active" type="checkbox" :required="false" label="Active"/>
            </div>
            <x-form.textarea name="description" label="Description"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-admin.iframe.ajax.get_cities/>
</x-admin.iframe.layout>
