<x-admin.iframe.countries_cities.crud.layout
    title="Edit City"
    iframe-id-to-close="{{ \App\Iframes\CityIframe::$iframeCUId }}"
    operation="edit"
    :country-or-city="$city"
    :patch-method="true"/>
