<x-admin.iframe.layout title="Add Client" :load-jquery="true">
    <x-form.container title="Client" :iframe-id-to-close="\App\Iframes\UserIframe::$iframeCUId">
        <x-form.layout>
            <div class="grid grid-cols-2">
                <x-form.input_text name="last_name" type="text" label="Last name"/>
                <x-form.input_text name="first_name" type="text" label="First name"/>
                <x-form.input_text name="email" type="email" label="Email"/>
                <x-form.input_text name="phone_number" type="text" label="Phone number"/>
                <x-country-select :active-only="true" on-change="getCities();"/>
                <x-city-select :country="\App\Models\Country::find(old('country')) ?? (new \App\Models\Country)"
                               :default="false"/>
            </div>
            <x-form.input_text name="address" type="text" label="Address"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-admin.iframe.ajax.get_cities/>
</x-admin.iframe.layout>
