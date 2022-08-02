<nav class="bg-blue-400 rounded p-2 shadow-2xl">
    <ul class="space-y-2">
        <x-admin.aside.sidenav-item name="Dashboard" :href="route('admin')"/>
        <x-admin.aside.sidenav-item name="Residence" :href="'#'"/>
        <x-admin.aside.sidenav-item name="Countries & Cities" :href="route('admin.countries-cities')"/>
    </ul>
</nav>
