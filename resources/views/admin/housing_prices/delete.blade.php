<x-admin.iframe.layout title="Delete Housing Price" :load-notiflix="true">
    <div class="hidden">
        <x-form.layout :delete="true">
            <x-form.submit>Delete</x-form.submit>
        </x-form.layout>
    </div>
    <x-admin.iframe.js.confirm_d_submit :message="$housingPriceName . ' housing price'"
                                        :iframe-d-id="\App\Iframes\HousingPriceIframe::$iframeDId"/>
</x-admin.iframe.layout>
