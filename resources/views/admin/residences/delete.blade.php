<x-admin.iframe.layout title="Delete Residence" :load-notiflix="true">
    <div class="hidden">
        <x-form.layout :delete="true">
            <x-form.submit>Delete</x-form.submit>
        </x-form.layout>
    </div>
    <x-admin.iframe.js.confirm_d_submit :message="$residenceName . ' residence'"
                                        :iframe-d-id="\App\Iframes\ResidenceIframe::$iframeDId"/>
</x-admin.iframe.layout>
