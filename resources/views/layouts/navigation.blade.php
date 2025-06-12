<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Recipe Guru</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->RoleID === 1)
                            <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                                {{ __('Admin Panel') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side of Navbar -->
            <div class="hidden sm:flex items-center space-x-4">
                @auth
                    <a href="{{ route('recipes.create') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-500 transition">Add Recipe</a>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-500 transition">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition">Logout</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-500 transition">Login</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-500 transition">Register</a>
                @endguest
            </div>

            <!-- Hamburger Menu -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-white dark:bg-gray-800 px-4 pt-4 pb-6 border-t dark:border-gray-700">
        <div class="space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @auth
                @if(Auth::user()->RoleID === 1)
                    <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                        {{ __('Admin Panel') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Auth Options -->
        <div class="mt-4 border-t border-gray-200 dark:border-gray-600 pt-4">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

