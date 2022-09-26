<x-admin.iframe.layout title="Edit Season">
    <x-form.container title="Season" :iframe-id-to-close="\App\Iframes\SeasonIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <div class="grid grid-cols-2">
                <x-form.input_text name="from" type="date" label="From" :value="$season->date_from->toDateString()"/>
                <x-form.input_text name="to" type="date" label="To" :value="$season->date_to->toDateString()"/>
            </div>
            <div class="grid grid-cols-2 flex items-center">
                <x-form.select name="type" label="Type" :values="\App\Enums\SeasonTypes::values()"
                               :are-values-array="true" :value="$season->type_SHML"/>
                <x-form.input_check name="active" type="checkbox" :required="false" label="Active"
                                    :value="$season->is_active"/>
            </div>
            <x-form.textarea name="description" label="Description" :value="$season->description"/>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
