<x-admin.iframe.layout title="Delete Housing Category" :load-notiflix="true">
    <div class="hidden">
        <x-form.layout :delete="true">
            <x-form.submit>Delete</x-form.submit>
        </x-form.layout>
    </div>
    <x-admin.iframe.js.confirm_d_submit :message="$housingCategoryName . ' category'"
                                        :iframe-d-id="\App\Iframes\HousingCategoryIframe::$iframeDId"/>
</x-admin.iframe.layout>
