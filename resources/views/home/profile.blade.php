<x-home.layout :load-jquery="true">
    <div class="flex justify-center items-center grow sm:grow-0">
        <form method="post" class="px-0 sm:px-5 pt-4 sm:pt-5 pb-2 shadow-lg rounded-lg bg-blue-100">
            @csrf
            <x-form.input_text name="last_name" type="text" label="Last name" :value="$user->last_name"/>
            <x-form.input_text name="first_name" type="text" label="First name" :value="$user->first_name"/>
            <x-country-select :active-only="true" on-change="getCities();" :value="$user->city->country_id"/>
            <x-city-select :country="\App\Models\Country::find(old('country')) ?? $user->city->country"
                           :default="false" :value="$user->city_id"/>
            <x-form.input_text name="address" type="text" label="Address" :value="$user->address"/>
            <x-form.input_text name="phone_number" type="text" label="Phone number" :value="$user->phone_number"/>
            <x-form.input_text name="email" type="email" label="Email" :value="$user->email"/>
            <x-form.input_text name="password" type="password" label="Password"/>
            <div class="text-center mt-1">
                <a href="{{ route('password-change') }}" class="underline text-gray-600 hover:text-gray-900">
                    Change password?
                </a>
            </div>
            <x-form.submit>Edit</x-form.submit>
        </form>
    </div>
    <x-home.iframe.ajax.get_cities/>
</x-home.layout>
