<x-admin.iframe.countries_cities.crud.layout
    title="Create City"
    iframe-id-to-close="{{ \App\Iframes\CityIframe::$iframeCUId }}"
    operation="create"
    :country-is-active="$countryIsActive"/>
