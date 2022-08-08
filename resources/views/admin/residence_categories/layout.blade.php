<x-admin.layout.management name="Residence Categories Management">
    <iframe id="{{ \App\Iframes\ResidenceCategoryIframe::$parentIframeId }}" class="w-full lg:w-1/2"
            src="{{ route('admin.residence.categories') }}"></iframe>
    <iframe id="{{ \App\Iframes\ResidenceCategoryIframe::$iframeCUId }}"
            class="w-96 h-60 absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\ResidenceCategoryIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
