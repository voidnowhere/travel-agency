<x-admin.iframe.countries_cities.cu.layout
    title="Edit Country"
    iframe-id-to-close="{{ \App\Iframes\CountryIframe::$iframeCUId }}"
    operation="edit"
    :country-or-city="$country"
    :patch-method="true"/>
