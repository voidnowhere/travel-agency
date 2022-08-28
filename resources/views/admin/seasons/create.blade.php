<x-admin.iframe.layout title="Add Season">
    <x-form.container title="Season" :iframe-id-to-close="\App\Iframes\SeasonIframe::$iframeCUId">
        <x-form.layout>
            <div class="grid grid-cols-2">
                <x-form.input_text name="from" type="date" label="From"/>
                <x-form.input_text name="to" type="date" label="To"/>
            </div>
            <div class="grid grid-cols-2 flex items-center">
                <x-form.select name="type" label="Type" :values="\App\Enums\SeasonTypes::values()"
                               :are-values-array="true"/>
                <x-form.input_check name="active" type="checkbox" :required="false" label="Active"/>
            </div>
            <x-form.textarea name="description" label="Description"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
