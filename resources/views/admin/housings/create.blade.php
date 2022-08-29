<x-admin.iframe.layout title="Add Housing" :load-jquery="true">
    <x-form.container title="Housing" :iframe-id-to-close="\App\Iframes\HousingIframe::$iframeCUId">
        <x-form.layout>
            <div class="grid grid-cols-2 flex items-center">
                <x-form.input_text name="name" type="text" label="Name"/>
                <x-housing-category-select/>
            </div>
            <div class="grid grid-cols-2">
                <x-country-select on-change="getCities(); $('#residence').empty();"/>
                <x-city-select :country="\App\Models\Country::find(old('country')) ?? (new \App\Models\Country)"
                               :default="false" on-change="getResidences()"/>
            </div>
            <div class="grid grid-cols-2 flex items-center">
                <x-residence-select :city="\App\Models\City::find(old('city')) ?? (new \App\Models\City)"
                                    :default="false"/>
                <x-form.input_check name="active" type="checkbox" :required="false" label="Active"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="order" type="text" label="Order"/>
                <x-form.input_text name="max" type="text" label="Max"/>
            </div>
            <x-form.textarea name="description" label="Description"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-admin.iframe.ajax.get_cities/>
    <x-admin.iframe.ajax.get_residences/>
</x-admin.iframe.layout>
