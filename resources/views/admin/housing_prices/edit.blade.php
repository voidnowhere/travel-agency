<x-admin.iframe.layout title="Edit Housing Price" :load-jquery="true">
    <x-form.container
        title="Housing Price"
        :iframe-id-to-close="\App\Iframes\HousingPriceIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <div class="grid grid-cols-2">
                <x-country-select on-change="getCities(); $('#residence').empty(); $('#housing').empty();"
                                  :value="$housingPrice->housing->residence->city->country_id"/>
                <x-city-select
                    :country="\App\Models\Country::find(old('country')) ?? $housingPrice->housing->residence->city->country"
                    :value="$housingPrice->housing->residence->city_id" :default="false" on-change="getResidences()"/>
                <x-residence-select
                    :city="\App\Models\City::find(old('city')) ?? $housingPrice->housing->residence->city"
                    :value="$housingPrice->housing->residence_id" :default="false" on-change="getHousings()"/>
                <x-housing-select
                    :residence="\App\Models\Residence::find(old('residence')) ?? $housingPrice->housing->residence"
                    :value="$housingPrice->housing_id" :default="false"/>
            </div>
            <div class="grid grid-cols-2">
                <x-housing-formula-select :value="old('formula') ?? $housingPrice->housing_formula_id"/>
                <x-form.select name="type" label="Type" :values="\App\Enums\SeasonTypes::values()"
                               :value="$housingPrice->type_SHML" :are-values-array="true"/>
            </div>
            <div class="grid grid-cols-2 flex items-center">
                <x-form.input_text name="one_price" type="text" label="Price"
                                   :value="$housingPrice->for_one_price"/>
                <div class="flex">
                    <x-form.input_text name="extra_price" type="text" label="Extra price"
                                       :value="$housingPrice->extra_price"/>
                    <div class="mt-[13px]">
                        <x-form.input_check_only name="extra_price_active" type="checkbox" :required="false"
                                                 :value="$housingPrice->extra_price_is_active"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div class="flex mr-5">
                    <x-form.input_text name="weekend_price" type="text" label="Weekend price"
                                       :value="$housingPrice->weekend_price"/>
                    <div class="mt-4">
                        <x-form.input_check_only name="weekend_active" type="checkbox"
                                                 :required="false" :value="$housingPrice->weekend_is_active"/>
                    </div>
                </div>
                <div class="flex">
                    <x-form.input_text name="kid_bed_price" type="text" label="Kid bed price"
                                       :value="$housingPrice->kid_bed_price"/>
                    <div class="mt-4">
                        <x-form.input_check_only name="kid_bed_active" type="checkbox"
                                                 :required="false" :value="$housingPrice->kid_bed_is_active"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div class="flex mr-5">
                    <x-form.input_text name="extra_bed_price" type="text" label="Extra bed price"
                                       :value="$housingPrice->extra_bed_price"/>
                    <div class="mt-4">
                        <x-form.input_check_only name="extra_bed_active" type="checkbox"
                                                 :required="false" :value="$housingPrice->extra_bed_is_active"/>
                    </div>
                </div>
                <x-form.input_text name="min_nights" type="text" label="Min nights" :value="$housingPrice->min_nights"/>
            </div>
            <div>
                <div class="p-2 flex flex-row items-center">
                    <x-form.label label="Weekends"/>
                    <div class="ml-1 flex justify-between grow">
                        @php
                            $weekends = explode(',', $housingPrice->weekends);
                            $weekendsNames = \App\Helpers\WeekdayHelper::weekdaysNames();
                        @endphp
                        @foreach(\App\Helpers\WeekdayHelper::$weekdays as $num => $name)
                            <div>
                                <span>{{ $name }}</span>
                                <input type="checkbox" name="{{ $name }}" class="hover:cursor-pointer"
                                       value="{{ $name }}" @checked(((old($name) !== null) ? in_array(old($name), $weekendsNames) : null) ?? in_array($num, $weekends))>
                            </div>
                        @endforeach
                    </div>
                </div>
                <x-form.input_error name="weekends"/>
            </div>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-admin.iframe.ajax.get_cities/>
    <x-admin.iframe.ajax.get_residences/>
    <x-admin.iframe.ajax.get_housings/>
</x-admin.iframe.layout>
