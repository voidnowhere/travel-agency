<x-admin.layout.management name="Housing Formulas Management">
    <iframe id="{{ \App\Iframes\HousingFormulaIframe::$parentIframeId }}" class="w-full lg:w-1/2"
            src="{{ route('admin.housing.formulas') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\HousingFormulaIframe::$iframeCUId"
                              width-class="w-96" height-class="h-96"/>
    <x-admin.iframe.d.layout :id="\App\Iframes\HousingFormulaIframe::$iframeDId"/>
</x-admin.layout.management>
