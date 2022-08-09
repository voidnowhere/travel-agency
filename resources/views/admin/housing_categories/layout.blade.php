<x-admin.layout.management name="Housing Categories Management">
    <iframe id="{{ \App\Iframes\HousingCategoryIframe::$parentIframeId }}" class="w-full lg:w-1/2"
            src="{{ route('admin.housing.categories') }}"></iframe>
    <iframe id="{{ \App\Iframes\HousingCategoryIframe::$iframeCUId }}"
            class="w-96 h-96 absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\HousingCategoryIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
