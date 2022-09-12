<x-admin.iframe.layout title="Delete City" :load-notiflix="true">
    <div class="hidden">
        <x-form.layout :delete="true">
            <x-form.submit>Delete</x-form.submit>
        </x-form.layout>
    </div>
    <x-admin.iframe.js.confirm_d_submit :message="$city->name . ' city'"
                                        :iframe-d-id="\App\Iframes\CityIframe::$iframeDId"/>
</x-admin.iframe.layout>
