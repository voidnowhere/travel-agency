<x-admin.iframe.layout title="Add Housing Price" :load-jquery="true">
    <x-form.container
        title="Housing Price"
        :iframe-id-to-close="\App\Iframes\HousingPriceIframe::$iframeCUId">
        <x-form.layout>
            <div class="grid grid-cols-2">
                <x-country-select on-change="getCities(); $('#residence').empty(); $('#housing').empty();"/>
                <x-city-select :country="\App\Models\Country::find(old('country')) ?? (new \App\Models\Country)"
                               :default="false" on-change="getResidences()"/>
                <x-residence-select :city="\App\Models\City::find(old('city')) ?? (new \App\Models\City)"
                                    :default="false" on-change="getHousings()"/>
                <x-housing-select
                    :residence="\App\Models\Residence::find(old('residence')) ?? (new \App\Models\Residence)"
                    :default="false"/>
            </div>
            <div class="grid grid-cols-2">
                <x-housing-formula-select :value="old('formula') ?? ''"/>
                <x-form.select name="type" label="Type" :values="\App\Enums\SeasonTypes::values()"
                               :are-values-array="true"/>
            </div>
            <div class="grid grid-cols-2 flex items-center">
                <x-form.input_text name="one_price" type="text" label="Price"/>
                <div class="flex">
                    <x-form.input_text name="extra_price" type="text" label="Extra price"/>
                    <div class="mt-[13px]">
                        <x-form.input_check_only name="extra_price_active" type="checkbox" :required="false"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div class="flex mr-5">
                    <x-form.input_text name="weekend_price" type="text" label="Weekend price"/>
                    <div class="mt-[13px]">
                        <x-form.input_check_only name="weekend_active" type="checkbox" :required="false"/>
                    </div>
                </div>
                <div class="flex">
                    <x-form.input_text name="kid_bed_price" type="text" label="Kid bed price"/>
                    <div class="mt-[13px]">
                        <x-form.input_check_only name="kid_bed_active" type="checkbox" :required="false"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div class="flex mr-5">
                    <x-form.input_text name="extra_bed_price" type="text" label="Extra bed price"/>
                    <div class="mt-[13px]">
                        <x-form.input_check_only name="extra_bed_active" type="checkbox" :required="false"/>
                    </div>
                </div>
                <x-form.input_text name="min_nights" type="text" label="Min nights"/>
            </div>
            <div>
                <div class="p-2 flex flex-row items-center">
                    <x-form.label label="Weekends"/>
                    <div class="ml-1 flex justify-between grow">
                        @foreach(\App\Helpers\WeekdayHelper::weekdaysNames() as $name)
                            <div>
                                <span>{{ $name }}</span>
                                <input type="checkbox" name="{{ $name }}" class="hover:cursor-pointer"
                                       value="{{ $name }}" @checked(((old($name) !== null) ? old($name) === $name : null) ?? ($loop->first | $loop->last))>
                            </div>
                        @endforeach
                    </div>
                </div>
                <x-form.input_error name="weekends"/>
            </div>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-admin.iframe.ajax.get_cities/>
    <x-admin.iframe.ajax.get_residences/>
    <x-admin.iframe.ajax.get_housings/>
</x-admin.iframe.layout>
