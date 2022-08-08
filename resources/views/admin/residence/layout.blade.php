<x-admin.layout.management name="Residences Management">
    <iframe id="{{ \App\Iframes\ResidenceIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.residences') }}"></iframe>
    <iframe id="{{ \App\Iframes\ResidenceIframe::$iframeCUId }}"
            class="w-2/3 h-screen absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\ResidenceIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
