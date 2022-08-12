<x-admin.layout.management name="Residence Categories Management">
    <iframe id="{{ \App\Iframes\ResidenceCategoryIframe::$parentIframeId }}" class="w-full lg:w-1/2"
            src="{{ route('admin.residence.categories') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\ResidenceCategoryIframe::$iframeCUId"
                              width-class="w-96" height-class="h-96"/>
    <iframe id="{{ \App\Iframes\ResidenceCategoryIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
