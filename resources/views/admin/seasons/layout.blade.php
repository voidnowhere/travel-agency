<x-admin.layout.management name="Seasons Management">
    <iframe id="{{ \App\Iframes\SeasonIframe::$parentIframeId }}" class="w-full lg:w-3/4"
            src="{{ route('admin.seasons') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\SeasonIframe::$iframeCUId"
                              width-class="w-2/3" height-class="h-2/3"/>
    <iframe id="{{ \App\Iframes\SeasonIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
