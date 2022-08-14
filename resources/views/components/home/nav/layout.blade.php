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
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </li>
            <ul class="absolute rounded px-4 py-1 mt-5 bg-blue-400 selection:bg-transparent"
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
