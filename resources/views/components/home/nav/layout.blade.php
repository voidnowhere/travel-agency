<nav class="relative px-2 md:px-0 w-full md:w-2/3 lg:w-1/2 flex justify-center" x-data="{ showMenu: false }">
    <div class="flex sm:hidden items-center grow">
        <h1 class="grow text-center text-2xl pb-1">
            <a class="border-b-4 border-b-blue-400 rounded-xl" href="{{ route('home') }}">Agency</a>
        </h1>
        <svg @click="showMenu = !showMenu"
             class="w-8 h-8 mr-2" fill="none" stroke="currentColor"
             viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </div>
    <div :class="showMenu ? 'block' : 'hidden'"
         class="absolute sm:static mt-14 sm:mt-0 w-11/12 sm:w-full p-2 sm:flex justify-between items-center rounded bg-blue-400 shadow-2xl font-mono">
        <ul class="flex flex-col sm:flex-row space-y-1 sm:space-y-0 sm:space-x-2 text-lg">
            <x-home.nav.item name="Home" :href="route('home')" :is-active="request()->routeIs('home')"/>
            @admin
            <x-home.nav.item name="Admin" :href="route('admin')"/>
            @endadmin
            @user
            <x-home.nav.item name="Orders" :href="route('orders.layout')"
                             :is-active="request()->routeIs('orders.layout')"/>
            @enduser
        </ul>
        @auth
            <ul class="relative flex justify-center" x-data="{ showProfile: false }"
                @click.outside="showProfile = false">
                <li class="flex items-center px-3 py-1 rounded cursor-pointer selection:bg-transparent space-x-2 hover:text-white transition-colors duration-150"
                    @click="showProfile = !showProfile">
                    <span>{{ Auth::user()->full_name }}</span>
                    <x-svg.user/>
                </li>
                <ul class="absolute w-full flex flex-col items-center justify-center space-y-1 mt-14"
                    x-show="showProfile" style="display: none">
                    <li class="w-[150px] hover:text-white transition-colors duration-150 bg-blue-400 rounded px-2 py-1">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full">Logout</button>
                        </form>
                    </li>
                    <li class="w-[150px] hover:text-white transition-colors duration-150 bg-blue-400 rounded px-2 py-1">
                        <a href="{{ route('user-profile') }}" class="block text-center w-full">Profile</a>
                    </li>
                </ul>
            </ul>
        @else
            <ul class="flex flex-col sm:flex-row mt-2 sm:mt-0 space-y-2 sm:space-y-0 sm:space-x-2 text-lg">
                <x-home.nav.item name="Login" :href="route('login')" :is-active="request()->routeIs('login')"/>
                <x-home.nav.item name="Register" :href="route('register')"
                                 :is-active="request()->routeIs('register')"/>
            </ul>
        @endguest
    </div>
</nav>
