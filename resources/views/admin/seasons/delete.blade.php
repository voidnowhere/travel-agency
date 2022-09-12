<x-admin.iframe.layout title="Delete Season" :load-notiflix="true">
    <div class="hidden">
        <x-form.layout :delete="true">
            <x-form.submit>Delete</x-form.submit>
        </x-form.layout>
    </div>
    <x-admin.iframe.js.confirm_d_submit :message="$seasonDetails . ' season'"
                                        :iframe-d-id="\App\Iframes\SeasonIframe::$iframeDId"/>
</x-admin.iframe.layout>
