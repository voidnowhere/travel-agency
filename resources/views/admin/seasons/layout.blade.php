<x-admin.layout.management name="Seasons Management">
    <iframe id="{{ \App\Iframes\SeasonIframe::$parentIframeId }}" class="w-full lg:w-3/4"
            src="{{ route('admin.seasons') }}"></iframe>
    <iframe id="{{ \App\Iframes\SeasonIframe::$iframeCUId }}"
            class="w-2/3 h-2/3 absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\SeasonIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
