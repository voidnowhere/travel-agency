<x-admin.iframe.layout title="Add Residence Category">
    <x-form.container
        title="Country"
        :iframe-id-to-close="\App\Iframes\CountryIframe::$iframeCUId">
        <x-form.layout>
            <x-form.input_text name="name" type="text" label="Name"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
</x-admin.iframe.layout>
