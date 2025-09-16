<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'CRM Dashboard')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <div class="flex">
            <!-- Mobile sidebar overlay -->
            <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
                class="fixed inset-0 z-20 bg-black opacity-50 lg:hidden"></div>

            <!-- Sidebar -->
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-white shadow-lg lg:translate-x-0 lg:static lg:inset-0">

                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="mx-2 text-2xl font-semibold text-gray-800">O24 Dashboard</span>
                    </div>
                </div>

                <nav class="mt-10">
                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('dashboard') ? 'text-gray-100 bg-blue-600' : 'text-gray-500 hover:bg-gray-200 hover:text-gray-700' }}"
                        href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span class="mx-3">Dashboard</span>
                    </a>

                    @if (Auth::user()->hasRole('admin'))
                        <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('users.*') ? 'text-gray-100 bg-blue-600' : 'text-gray-500 hover:bg-gray-200 hover:text-gray-700' }}"
                            href="{{ route('users.index') }}">
                            <i class="fas fa-users w-5 h-5"></i>
                            <span class="mx-3">Users</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('roles.*') ? 'text-gray-100 bg-blue-600' : 'text-gray-500 hover:bg-gray-200 hover:text-gray-700' }}"
                            href="{{ route('roles.index') }}">
                            <i class="fas fa-user-shield w-5 h-5"></i>
                            <span class="mx-3">Roles</span>
                        </a>
                    @endif

                    
                    <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-200 hover:text-gray-700"
                        href="#">
                        <i class="fas fa-chart-line w-5 h-5"></i>
                        <span class="mx-3">Analytics</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-200 hover:text-gray-700"
                        href="#">
                        <i class="fas fa-cog w-5 h-5"></i>
                        <span class="mx-3">Settings</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-blue-600">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars w-6 h-6"></i>
                    </button>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- User Info -->
                    <div class="hidden md:block">
                        <div class="text-sm text-gray-600">Welcome back,</div>
                        <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="relative block w-8 h-8 overflow-hidden bg-gray-600 rounded-full shadow focus:outline-none">
                            <div
                                class="w-full h-full bg-blue-600 flex items-center justify-center text-white font-medium">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false"
                            class="fixed inset-0 z-10 w-full h-full"></div>

                        <div x-show="dropdownOpen" x-cloak
                            class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-600 hover:text-white">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
