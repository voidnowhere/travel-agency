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
<nav class="flex flex-col justify-between grow">
    <ul class="bg-blue-400 rounded p-2 shadow-2xl space-y-2"
        x-data="{ residenceOpen: '{{ $residenceOpen }}', housingOpen: '{{ $housingOpen }}' }">
        <x-admin.aside.sidenav.item name="Dashboard" :href="route('admin')" :is-active="request()->routeIs('admin')"/>
        <x-admin.aside.sidenav.item name="Clients" :href="route('admin.users.layout')"
                                    :is-active="request()->routeIs('admin.users.layout')"/>
        <x-admin.aside.sidenav.item name="Orders" :href="route('admin.orders.layout')"
                                    :is-active="request()->routeIs('admin.orders.layout')"/>
        <x-admin.aside.sidenav.item name="Residence" href="#" click="residenceOpen = !residenceOpen"
                                    :is-active="$residenceOpen"/>
        <x-admin.aside.sub_sidenav.layout x-show="residenceOpen">
            <x-admin.aside.sub_sidenav.item name="All" :href="route('admin.residences.layout')"
                                            :is-active="$isResidences"/>
            <x-admin.aside.sub_sidenav.item name="Categories" :href="route('admin.residence.categories.layout')"
                                            :is-active="$isResidenceCategories"/>
        </x-admin.aside.sub_sidenav.layout>
        <x-admin.aside.sidenav.item name="Seasons" :href="route('admin.seasons.layout')"
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
    <ul class="mb-5" x-data="{ openProfile: false }" @click.outside="openProfile = false">
        <ul class="selection:bg-transparent flex flex-col items-center justify-center mb-3 space-y-1"
            x-show="openProfile">
            <li class="w-[150px] hover:text-white transition-colors duration-150 bg-blue-400 rounded py-1">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full">Logout</button>
                </form>
            </li>
            <li class="w-[150px] text-center hover:text-white transition-colors duration-150 bg-blue-400 rounded py-1">
                <a href="{{ route('user-profile') }}" class="block w-full">Profile</a>
            </li>
            <li class="w-[150px] text-center hover:text-white transition-colors duration-150 bg-blue-400 rounded py-1">
                <a href="{{ route('password-change') }}" class="block w-full">Change password</a>
            </li>
        </ul>
        <li class="flex items-center justify-center rounded cursor-pointer selection:bg-transparent hover:text-white transition-colors duration-150"
            @click="openProfile = !openProfile">
            <span class="bg-blue-400 rounded flex px-4 py-2 space-x-2">
                <span>{{ Auth::user()->full_name }}</span>
                <x-svg.user/>
            </span>
        </li>
    </ul>
</nav>
