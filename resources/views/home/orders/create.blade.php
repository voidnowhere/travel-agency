<x-admin.iframe.layout title="Add Order" :load-jquery="true" h-class-alternative="flex min-h-screen md:h-screen">
    <x-form.container
        title="Order"
        h-class-alternative="grow"
        :iframe-id-to-close="\App\Iframes\OrderIframe::$iframeCUId">
        <x-form.layout>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <x-form.input_text name="from" type="date" label="From"/>
                <x-form.input_text name="to" type="date" label="To"/>
                <x-country-select :active-only="true"
                                  on-change="getCities(); $('#residence').empty(); $('#housing').empty();"/>
                <x-city-select :country="\App\Models\Country::find(old('country')) ?? (new \App\Models\Country)"
                               :default="false" on-change="getResidences()"/>
                <x-residence-select :city="\App\Models\City::find(old('city')) ?? (new \App\Models\City)"
                                    :default="false" on-change="getHousings()"/>
                <x-housing-select
                    :residence="\App\Models\Residence::find(old('residence')) ?? (new \App\Models\Residence)"
                    :default="false"/>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 flex items-center">
                <x-housing-formula-select :value="old('formula') ?? ''" :active-only="true"/>
                <x-form.input_text name="for" type="text" label="For"/>
            </div>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-home.iframe.ajax.get_cities/>
    <x-home.iframe.ajax.get_residences/>
    <x-home.iframe.ajax.get_housings/>
</x-admin.iframe.layout>
