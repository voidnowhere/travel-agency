@php
    // Residence
    $isResidences = request()->routeIs('admin.residences.layout');
    $isResidenceCategories = request()->routeIs('admin.residence.categories.layout');
    $residenceOpen = $isResidences || $isResidenceCategories;
    // Housing
    $isHousings = request()->routeIs('admin.housings.layout');
    $isHousingCategories = request()->routeIs('admin.housing.categories.layout');
    $isHousingFormulas = request()->routeIs('admin.housing.formulas.layout');
    $isHousingPrices = request()->routeIs('admin.housing.prices.layout');
    $housingOpen = $isHousings || $isHousingCategories || $isHousingFormulas || $isHousingPrices;
@endphp
<nav class="bg-blue-400 rounded p-2 shadow-2xl">
    <ul class="space-y-2" x-data="{ residenceOpen: '{{ $residenceOpen }}', housingOpen: '{{ $housingOpen }}' }">
        <x-admin.aside.sidenav.item name="Dashboard" :href="route('admin')" :is-active="request()->routeIs('admin')"/>
        <x-admin.aside.sidenav.item
            name="Residence" href="#" click="residenceOpen = !residenceOpen"
            :is-active="$residenceOpen"/>
        <x-admin.aside.sub_sidenav.layout x-show="residenceOpen">
            <x-admin.aside.sub_sidenav.item name="All" :href="route('admin.residences.layout')"
                                            :is-active="$isResidences"/>
            <x-admin.aside.sub_sidenav.item name="Categories" :href="route('admin.residence.categories.layout')"
                                            :is-active="$isResidenceCategories"/>
        </x-admin.aside.sub_sidenav.layout>
        <x-admin.aside.sidenav.item name="Season" :href="route('admin.seasons.layout')"
                                    :is-active="request()->routeIs('admin.seasons.layout')"/>
        <x-admin.aside.sidenav.item
            name="Housing" href="#" click="housingOpen = !housingOpen"
            :is-active="$housingOpen"/>
        <x-admin.aside.sub_sidenav.layout x-show="housingOpen">
            <x-admin.aside.sub_sidenav.item name="All" :href="route('admin.housings.layout')"
                                            :is-active="$isHousings"/>
            <x-admin.aside.sub_sidenav.item name="Categories" :href="route('admin.housing.categories.layout')"
                                            :is-active="$isHousingCategories"/>
            <x-admin.aside.sub_sidenav.item name="Formulas" :href="route('admin.housing.formulas.layout')"
                                            :is-active="$isHousingFormulas"/>
            <x-admin.aside.sub_sidenav.item name="Prices" :href="route('admin.housing.prices.layout')"
                                            :is-active="$isHousingPrices"/>
        </x-admin.aside.sub_sidenav.layout>
        <x-admin.aside.sidenav.item
            name="Countries & Cities"
            :is-active="request()->routeIs('admin.countries-cities')"
            :href="route('admin.countries-cities')"/>
    </ul>
</nav>
