<x-home.layout :load-jquery="true">
    <div class="flex justify-center items-center grow sm:grow-0">
        <form method="post" class="px-0 sm:px-5 pt-4 sm:pt-5 pb-2 shadow-lg rounded-lg bg-blue-100">
            @csrf
            <x-form.input_text name="last_name" type="text" label="Last name"/>
            <x-form.input_text name="first_name" type="text" label="First name"/>
            <x-country-select :active-only="true" on-change="getCities();"/>
            <x-city-select :country="\App\Models\Country::find(old('country')) ?? (new \App\Models\Country)"
                           :default="false"/>
            <x-form.input_text name="address" type="text" label="Address"/>
            <x-form.input_text name="phone_number" type="text" label="Phone number"/>
            <x-form.input_text name="email" type="email" label="Email"/>
            <x-form.input_text name="password" type="password" label="Password"/>
            <x-form.input_text name="password_confirmation" type="password" label="Confirm"/>
            <x-form.submit>Register</x-form.submit>
        </form>
    </div>
    <x-home.iframe.ajax.get_cities/>
</x-home.layout>
