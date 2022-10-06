<x-admin.iframe.layout title="Delete Country" :load-notiflix="true">
    <div class="hidden">
        <x-form.layout :delete="true">
            <x-form.submit>Delete</x-form.submit>
        </x-form.layout>
    </div>
    <x-admin.iframe.js.confirm_d_submit
        :message="$country->name . ' country'"
        :iframe-d-id="\App\Iframes\CountryIframe::$iframeDId"/>
</x-admin.iframe.layout>
