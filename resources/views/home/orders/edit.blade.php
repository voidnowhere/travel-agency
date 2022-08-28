<x-admin.iframe.layout title="Edit Order" :load-jquery="true" h-class-alternative="flex min-h-screen md:h-screen">
    <x-form.container
        title="Order"
        h-class-alternative="grow"
        :iframe-id-to-close="\App\Iframes\OrderIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <x-form.input_text name="from" type="date" label="From" :value="$order->date_from->toDateString()"/>
                <x-form.input_text name="to" type="date" label="To" :value="$order->date_to->toDateString()"/>
                <x-country-select on-change="getCities(); $('#residence').empty(); $('#housing').empty();"
                                  :active-only="true" :value="$order->residence->city->country_id"/>
                <x-city-select :country="\App\Models\Country::find(old('country')) ?? $order->residence->city->country"
                               :active-only="true" :default="false" :value="$order->residence->city_id"
                               on-change="getResidences()"/>
                <x-residence-select :city="\App\Models\City::find(old('city')) ?? $order->residence->city"
                                    :active-only="true" :default="false" on-change="getHousings()"/>
                <x-housing-select
                    :residence="\App\Models\Residence::find(old('residence')) ?? $order->residence"
                    :active-only="true" :default="false"/>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 flex items-center">
                <x-housing-formula-select :value="old('formula') ?? $order->formula->id" :active-only="true"/>
                <x-form.input_text name="for" type="text" label="For" :value="$order->for_count"/>
            </div>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <x-home.iframe.ajax.get_cities/>
    <x-home.iframe.ajax.get_residences/>
    <x-home.iframe.ajax.get_housings/>
</x-admin.iframe.layout>
