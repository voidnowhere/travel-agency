<x-admin.layout.management name="Housing Formulas Management">
    <iframe id="{{ \App\Iframes\HousingFormulaIframe::$parentIframeId }}" class="w-full lg:w-1/2"
            src="{{ route('admin.housing.formulas') }}"></iframe>
    <iframe id="{{ \App\Iframes\HousingFormulaIframe::$iframeCUId }}"
            class="w-96 h-96 absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\HousingFormulaIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
