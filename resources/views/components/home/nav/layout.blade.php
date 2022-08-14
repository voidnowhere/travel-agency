<nav class="flex justify-between bg-blue-400 rounded p-2 shadow-2xl w-1/2 text-lg">
    <ul class="flex space-x-2">
        <x-home.nav.item name="Home" :href="route('home')" :is-active="request()->routeIs('home')"/>
        @admin
        <x-home.nav.item name="Admin" :href="route('admin')" :is-active="false"/>
        @endadmin
    </ul>
    @auth
        <ul class="relative" x-data="{ open: false }" @click.outside="open = false">
            <li class="flex items-center px-3 py-1 rounded cursor-pointer selection:bg-transparent space-x-2 hover:text-white transition-colors duration-150"
                @click="open = !open">
                <span>{{ Auth::user()->name }}</span>
                <x-svg.user/>
            </li>
            <ul class="absolute mt-14 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded px-4 py-1 mt-5 bg-blue-400 selection:bg-transparent"
                x-show="open" style="display: none">
                <li class="hover:text-white transition-colors duration-150">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button>Logout</button>
                    </form>
                </li>
            </ul>
        </ul>
    @else
        <ul class="flex space-x-2">
            <x-home.nav.item name="Login" :href="route('login')" :is-active="request()->routeIs('login')"/>
            <x-home.nav.item name="Register" :href="route('register')" :is-active="request()->routeIs('register')"/>
        </ul>
    @endguest
</nav>
