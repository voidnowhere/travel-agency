<x-admin.layout.management name="Housing Categories Management">
    <iframe id="{{ \App\Iframes\HousingCategoryIframe::$parentIframeId }}" class="w-full lg:w-1/2"
            src="{{ route('admin.housing.categories') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\HousingCategoryIframe::$iframeCUId" width-class="w-96"
                              height-class="h-96"/>
    <x-admin.iframe.d.layout :id="\App\Iframes\HousingCategoryIframe::$iframeDId"/>
</x-admin.layout.management>
