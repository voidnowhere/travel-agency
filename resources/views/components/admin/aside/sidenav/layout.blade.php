<nav class="bg-blue-400 rounded p-2 shadow-2xl"
     x-data="{ residenceOpen: '{{ request()->routeIs('admin.residence.categories.layout') || request()->routeIs('admin.residences.layout') }}' }">
    <ul class="space-y-2">
        <x-admin.aside.sidenav.item name="Dashboard" :href="route('admin')" :is-active="request()->routeIs('admin')"/>
        <x-admin.aside.sidenav.item
            name="Residence" href="#" click="residenceOpen = !residenceOpen"
            :is-active="request()->routeIs('admin.residence.categories.layout') || request()->routeIs('admin.residences.layout')"/>
        <x-admin.aside.sub_sidenav.layout x-show="residenceOpen">
            <x-admin.aside.sub_sidenav.item name="All" :href="route('admin.residences.layout')"
                                            :is-active="request()->routeIs('admin.residences.layout')"/>
            <x-admin.aside.sub_sidenav.item name="Categories" :href="route('admin.residence.categories.layout')"
                                            :is-active="request()->routeIs('admin.residence.categories.layout')"/>
        </x-admin.aside.sub_sidenav.layout>
        <x-admin.aside.sidenav.item
            name="Countries & Cities"
            :is-active="request()->routeIs('admin.countries-cities')"
            :href="route('admin.countries-cities')"/>
    </ul>
</nav>
