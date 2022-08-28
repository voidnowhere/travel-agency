<x-admin.iframe.layout title="Edit User" :load-jquery="true">
    <x-form.container title="User" :iframe-id-to-close="\App\Iframes\UserIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <div class="grid grid-cols-2">
                <x-form.input_text name="last_name" type="text" label="Last name" :value="$user->last_name"/>
                <x-form.input_text name="first_name" type="text" label="First name" :value="$user->first_name"/>
                <x-form.input_text name="email" type="email" label="Email" :value="$user->email"/>
                <x-form.input_text name="phone_number" type="text" label="Phone number" :value="$user->phone_number"/>
                <x-country-select :active-only="true" :value="$user->city->country_id" on-change="getCities();"/>
                <x-city-select :country="\App\Models\Country::find(old('country')) ?? $user->city->country"
                               :value="$user->city_id" :default="false"/>
            </div>
            <x-form.input_text name="address" type="text" label="Address" :value="$user->address"/>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-admin.iframe.ajax.get_cities/>
</x-admin.iframe.layout>
