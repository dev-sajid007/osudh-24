<div class="w-64 bg-white shadow-lg">
    <div class="p-6">
        <h1 class="text-xl font-bold text-gray-800">Pharmacy Admin</h1>
    </div>

    <nav class="mt-6">
        <!-- Dashboard -->
        <div class="px-6 py-2">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Catalog Management -->
        <div class="px-6 py-2 mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Catalog Management</div>

            <a href="{{ route('admin.products.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                </svg>
                <span>Products</span>
                @php
                    $lowStockCount = \App\Models\Product::lowStock()->count();
                @endphp
                @if ($lowStockCount > 0)
                    <span
                        class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $lowStockCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.generics.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.generics.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                    </path>
                </svg>
                <span>Generics</span>
            </a>

            <a href="{{ route('admin.suppliers.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.suppliers.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <span>Suppliers</span>
            </a>
        </div>

        <!-- Inventory Management -->
        <div class="px-6 py-2 mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Inventory</div>

            <a href="{{ route('admin.products.index', ['stock_status' => 'low_stock']) }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
                <span>Low Stock Alerts</span>
                @if ($lowStockCount > 0)
                    <span
                        class="ml-auto bg-yellow-500 text-white text-xs rounded-full px-2 py-1">{{ $lowStockCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.products.index', ['stock_status' => 'out_of_stock']) }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span>Out of Stock</span>
            </a>

            <a href="{{ route('admin.reports.stock.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.reports.stock.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <span>Stock Reports</span>
                @php
                    $lowStockCount = \App\Models\Product::whereRaw('stock_quantity <= minimum_stock')->count();
                @endphp
                @if ($lowStockCount > 0)
                    <span
                        class="ml-auto bg-yellow-500 text-white text-xs rounded-full px-2 py-1">{{ $lowStockCount }}</span>
                @endif
            </a>
        </div>

        <!-- Orders Management -->
        <div class="px-6 py-2 mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Orders</div>

            <a href="#" class="flex items-center px-4 py-2 text-gray-400 cursor-not-allowed rounded-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span>All Orders</span>
                <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded">Soon</span>
            </a>

            <a href="#" class="flex items-center px-4 py-2 text-gray-400 cursor-not-allowed rounded-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span>Prescriptions</span>
                <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded">Soon</span>
            </a>
        </div>

        <!-- User Management -->
        <div class="px-6 py-2 mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">User Management</div>

            <a href="{{ route('users.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a4 4 0 11-8-1.82">
                    </path>
                </svg>
                <span>Users</span>
            </a>

            <a href="{{ route('roles.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('roles.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
                <span>Roles</span>
            </a>
        </div>

        <!-- Settings -->
        <div class="px-6 py-2 mt-4">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Settings</div>

            <a href="{{ route('admin.website-settings.index') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.website-settings.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Website Settings</span>
            </a>

            <a href="{{ route('admin.cloudinary.setup') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.cloudinary.setup') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                <span>Cloudinary Setup</span>
                @if (!config('cloudinary.cloud_name') || !config('cloudinary.api_key'))
                    <span class="ml-auto bg-orange-500 text-white text-xs rounded-full px-2 py-1">!</span>
                @else
                    <span class="ml-auto bg-green-500 text-white text-xs rounded-full px-2 py-1">✓</span>
                @endif
            </a>

            <a href="#" class="flex items-center px-4 py-2 text-gray-400 cursor-not-allowed rounded-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>System Settings</span>
                <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded">Soon</span>
            </a>
        </div>
    </nav>
</div>
