<x-admin.iframe.layout title="Edit Housing" :load-jquery="true">
    <x-form.container
        title="Housing"
        :iframe-id-to-close="\App\Iframes\HousingIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <div class="grid grid-cols-2 flex items-center">
                <x-form.input_text name="name" type="text" label="Name" :value="$housing->name"/>
                <x-housing-category-select :value="$housing->housing_category_id"/>
            </div>
            <div class="grid grid-cols-2">
                <x-country-select on-change="getCities(); $('#residence').empty();"
                                  :value="$housing->residence->city->country_id"/>
                <x-cities-select
                    :country="\App\Models\Country::find(old('country')) ?? \App\Models\Country::find($housing->residence->city->country_id)"
                    :value="$housing->residence->city_id" :default="false" on-change="getResidences()"/>
            </div>
            <div class="grid grid-cols-2 flex items-center">
                <x-residence-select
                    :city="\App\Models\City::find(old('city')) ?? \App\Models\City::find($housing->residence->city_id)"
                    :value="$housing->residence_id" :default="false"/>
                <x-form.input_check name="active" type="checkbox" :required="false" label="Active"
                                    :value="$housing->is_active"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="order" type="text" label="Order" :value="$housing->order_by"/>
                <x-form.input_text name="max" type="text" label="Max" :value="$housing->for_max"/>
            </div>
            <x-form.textarea name="description" label="Description" :value="$housing->description"/>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-admin.iframe.ajax.get_cities/>
    <x-admin.iframe.ajax.get_residences/>
</x-admin.iframe.layout>
