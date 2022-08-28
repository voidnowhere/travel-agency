<x-admin.iframe.layout title="Edit Housing Formula">
    <x-form.container title="Housing Formula" :iframe-id-to-close="\App\Iframes\HousingFormulaIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <x-form.input_text name="name" type="text" label="Name" :value="$housingFormula->name"/>
            <x-form.input_text name="order" type="text" label="Order" :value="$housingFormula->order_by"/>
            <x-form.input_check name="active" type="checkbox" :required="false" label="Active"
                                :value="$housingFormula->is_active"/>
            <x-form.submit>Edit</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
