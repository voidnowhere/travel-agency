<x-admin.iframe.layout title="Delete Residence Category" :load-notiflix="true">
    <div class="hidden">
        <x-form.layout :delete="true">
            <x-form.submit>Delete</x-form.submit>
        </x-form.layout>
    </div>
    <x-admin.iframe.js.confirm_d_submit :message="$residenceCategoryName . ' category'"
                                        :iframe-d-id="\App\Iframes\ResidenceCategoryIframe::$iframeDId"/>
</x-admin.iframe.layout>
