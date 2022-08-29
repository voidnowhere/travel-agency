<x-admin.layout.management name="Users Management">
    <iframe id="{{ \App\Iframes\UserIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.users') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\UserIframe::$iframeCUId" width-class="w-2/3" height-class="h-2/3"/>
</x-admin.layout.management>
