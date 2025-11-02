<header class="bg-white shadow-lg sticky top-0 z-50">
    <!-- Top Bar -->
    <div class="bg-cyan-600 text-white py-2">
        <div class="container mx-auto px-4">
            <!-- Desktop View -->
            <div class="hidden md:flex justify-between items-center text-sm">
                <div class="flex items-center space-x-4">
                    <span class="flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-1"></i>
                        {{ $settings['header_phone'] ?? '+1 (555) 123-4567' }}</span>
                    <span class="flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-1"></i>
                        {{ $settings['header_email'] ?? 'info@osudh24.com' }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>{{ $settings['free_shipping_message'] ?? 'Free shipping on orders over $50' }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ $settings['facebook_url'] ?? '#' }}" class="hover:text-cyan-200"><i
                                data-lucide="facebook" class="w-4 h-4 cursor-pointer"></i></a>
                        <a href="{{ $settings['twitter_url'] ?? '#' }}" class="hover:text-cyan-200"><i data-lucide="twitter"
                                class="w-4 h-4 cursor-pointer"></i></a>
                        <a href="{{ $settings['instagram_url'] ?? '#' }}" class="hover:text-cyan-200"><i
                                data-lucide="instagram" class="w-4 h-4 cursor-pointer"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile View -->
            <div class="flex md:hidden justify-between items-center text-xs">
                <span class="flex items-center"><i data-lucide="phone" class="w-3 h-3 mr-1"></i>
                    {{ $settings['header_phone'] ?? '+1 (555) 123-4567' }}</span>
                <div class="flex space-x-2">
                    <a href="{{ $settings['facebook_url'] ?? '#' }}" class="hover:text-cyan-200"><i
                            data-lucide="facebook" class="w-3 h-3 cursor-pointer"></i></a>
                    <a href="{{ $settings['twitter_url'] ?? '#' }}" class="hover:text-cyan-200"><i data-lucide="twitter"
                            class="w-3 h-3 cursor-pointer"></i></a>
                    <a href="{{ $settings['instagram_url'] ?? '#' }}" class="hover:text-cyan-200"><i
                            data-lucide="instagram" class="w-3 h-3 cursor-pointer"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                @if ($settings['site_logo'] ?? '')
                    <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'Osudh24' }}"
                        class="h-8 md:h-12 w-auto mr-2 md:mr-3">
                @else
                    <div class="bg-cyan-600 text-white p-1 md:p-2 rounded-lg mr-2 md:mr-3">
                        <i data-lucide="cross" class="w-5 h-5 md:w-8 md:h-8"></i>
                    </div>
                @endif
                <div class="hidden md:block">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $settings['site_name'] ?? 'Osudh24' }}</h1>
                    <p class="text-sm text-gray-600">{{ $settings['site_tagline'] ?? 'Your Health, Our Priority' }}</p>
                </div>
            </div>

            <!-- Search Bar - Hidden on mobile, shown on tablet+ -->
            <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                <div class="relative w-full">
                    <input type="text" placeholder="Search medicines, health products..."
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                    <button
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-cyan-600 text-white p-2 rounded-md hover:bg-cyan-700">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center space-x-2 md:space-x-6">
                <!-- Mobile Search Icon -->
                <button class="md:hidden flex items-center cursor-pointer hover:text-cyan-600">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>
                
                <!-- Store Locator - Hidden on mobile -->
                <div class="hidden lg:flex items-center space-x-1 cursor-pointer hover:text-cyan-600">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span class="text-sm">Store Locator</span>
                </div>
                
                <!-- Account - Icon only on mobile -->
                <div class="flex items-center space-x-1 cursor-pointer hover:text-cyan-600">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span class="hidden md:inline text-sm">Account</span>
                </div>
                
                <!-- Wishlist -->
                <a href="{{ route('wishlist.index') }}"
                    class="flex items-center space-x-1 cursor-pointer hover:text-cyan-600 transition-colors duration-200 relative">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                    <span class="hidden md:inline text-sm">Wishlist</span>
                    <span
                        class="absolute -top-2 -right-2 md:static bg-cyan-600 text-white text-xs rounded-full px-2 py-1 wishlist-count {{ \App\Helpers\Wishlist::count() > 0 ? '' : 'hidden' }}">
                        {{ \App\Helpers\Wishlist::count() }}
                    </span>
                </a>
                
                <!-- Cart -->
                <a href="{{ route('cart.index') }}"
                    class="flex items-center space-x-1 cursor-pointer hover:text-cyan-600 transition-colors duration-200 relative">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span class="hidden md:inline text-sm">Cart</span>
                    <span
                        class="absolute -top-2 -right-2 md:static bg-cyan-600 text-white text-xs rounded-full px-2 py-1 cart-badge cart-count {{ \App\Helpers\Cart::count() > 0 ? '' : 'hidden' }}">
                        {{ \App\Helpers\Cart::count() }}
                    </span>
                </a>
            </div>
        </div>
        
        <!-- Mobile Search Bar -->
        <div class="md:hidden mt-3">
            <div class="relative">
                <input type="text" placeholder="Search medicines..."
                    class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-sm">
                <button
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-cyan-600 text-white p-2 rounded-md hover:bg-cyan-700">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-gray-800 text-white">
        <div class="container mx-auto px-4">
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center">
                <!-- Categories Dropdown -->
                <div class="relative category-item">
                    <button class="bg-cyan-600 hover:bg-cyan-700 px-6 py-4 flex items-center space-x-2">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                        <span>All Categories</span>
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>

                    <!-- 3-Step Mega Menu -->
                    <div class="mega-menu absolute top-full left-0 bg-white text-gray-800 shadow-2xl rounded-lg overflow-hidden"
                        style="width: 900px; z-index: 1000;">
                        <div class="flex">
                            <!-- Step 1: Main Categories -->
                            <div class="w-1/3 bg-gray-50 border-r">
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-3">Main Categories</h3>
                                    <ul class="space-y-2">
                                        <li class="main-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center"
                                            data-category="prescription">
                                            <i data-lucide="pill" class="w-4 h-4 mr-2"></i>
                                            Prescription Medicines
                                            <i data-lucide="chevron-right" class="w-4 h-4 ml-auto"></i>
                                        </li>
                                        <li class="main-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center"
                                            data-category="otc">
                                            <i data-lucide="tablet" class="w-4 h-4 mr-2"></i>
                                            Over-the-Counter
                                            <i data-lucide="chevron-right" class="w-4 h-4 ml-auto"></i>
                                        </li>
                                        <li class="main-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center"
                                            data-category="wellness">
                                            <i data-lucide="heart-pulse" class="w-4 h-4 mr-2"></i>
                                            Health & Wellness
                                            <i data-lucide="chevron-right" class="w-4 h-4 ml-auto"></i>
                                        </li>
                                        <li class="main-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center"
                                            data-category="personal">
                                            <i data-lucide="user-check" class="w-4 h-4 mr-2"></i>
                                            Personal Care
                                            <i data-lucide="chevron-right" class="w-4 h-4 ml-auto"></i>
                                        </li>
                                        <li class="main-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center"
                                            data-category="baby">
                                            <i data-lucide="baby" class="w-4 h-4 mr-2"></i>
                                            Baby & Child
                                            <i data-lucide="chevron-right" class="w-4 h-4 ml-auto"></i>
                                        </li>
                                        <li class="main-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center"
                                            data-category="medical">
                                            <i data-lucide="stethoscope" class="w-4 h-4 mr-2"></i>
                                            Medical Devices
                                            <i data-lucide="chevron-right" class="w-4 h-4 ml-auto"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Step 2: Subcategories -->
                            <div class="w-1/3 border-r">
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-3">Subcategories</h3>
                                    <div id="subcategories">
                                        <ul class="space-y-2 text-sm">
                                            <li class="sub-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded"
                                                data-sub="antibiotics">Antibiotics</li>
                                            <li class="sub-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded"
                                                data-sub="pain-relief">Pain Relief</li>
                                            <li class="sub-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded"
                                                data-sub="diabetes">Diabetes Care</li>
                                            <li class="sub-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded"
                                                data-sub="heart">Heart Medications</li>
                                            <li class="sub-category p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded"
                                                data-sub="mental">Mental Health</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Products/Brands -->
                            <div class="w-1/3">
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-3">Popular Products</h3>
                                    <div id="products">
                                        <ul class="space-y-2 text-sm">
                                            <li
                                                class="p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-cyan-100 rounded mr-2 flex items-center justify-center">
                                                    <i data-lucide="pill" class="w-4 h-4 text-cyan-600"></i>
                                                </div>
                                                Amoxicillin 500mg
                                            </li>
                                            <li
                                                class="p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-cyan-100 rounded mr-2 flex items-center justify-center">
                                                    <i data-lucide="pill" class="w-4 h-4 text-cyan-600"></i>
                                                </div>
                                                Ibuprofen 200mg
                                            </li>
                                            <li
                                                class="p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-cyan-100 rounded mr-2 flex items-center justify-center">
                                                    <i data-lucide="pill" class="w-4 h-4 text-cyan-600"></i>
                                                </div>
                                                Metformin 850mg
                                            </li>
                                            <li
                                                class="p-2 hover:bg-cyan-50 hover:text-cyan-600 cursor-pointer rounded flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-cyan-100 rounded mr-2 flex items-center justify-center">
                                                    <i data-lucide="pill" class="w-4 h-4 text-cyan-600"></i>
                                                </div>
                                                Lisinopril 10mg
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Navigation Links -->
                <div class="flex items-center space-x-8 ml-8">
                    <a href="{{ route('home') }}" class="py-4 hover:text-cyan-400">Home</a>
                    <a href="{{ route('categories.index') }}" class="py-4 hover:text-cyan-400">Categories</a>
                    <a href="{{ route('generics.index') }}" class="py-4 hover:text-cyan-400">Generics</a>
                    <a href="#" class="py-4 hover:text-cyan-400">Prescription Upload</a>
                    <a href="#" class="py-4 hover:text-cyan-400">Health Services</a>
                    <a href="#" class="py-4 hover:text-cyan-400">Contact</a>
                </div>

                <!-- Emergency Button -->
                <div class="ml-auto">
                    <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i data-lucide="phone-call" class="w-4 h-4"></i>
                        <span>Emergency</span>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="lg:hidden flex items-center justify-between py-3">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="flex items-center space-x-2 text-white">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                    <span class="text-sm">Menu</span>
                </button>

                <!-- Emergency Button Mobile -->
                <button class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded-lg flex items-center space-x-2">
                    <i data-lucide="phone-call" class="w-4 h-4"></i>
                    <span class="text-xs">Emergency</span>
                </button>
            </div>

            <!-- Mobile Menu Drawer -->
            <div id="mobile-menu" class="hidden lg:hidden fixed inset-0 bg-gray-800 bg-opacity-95 z-50 overflow-y-auto">
                <div class="flex justify-between items-center p-4 border-b border-gray-700">
                    <h2 class="text-lg font-semibold">Menu</h2>
                    <button id="mobile-menu-close" class="text-white">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <div class="p-4 space-y-4">
                    <a href="{{ route('home') }}" class="block py-3 border-b border-gray-700 hover:text-cyan-400">Home</a>
                    <a href="{{ route('categories.index') }}" class="block py-3 border-b border-gray-700 hover:text-cyan-400">Categories</a>
                    <a href="{{ route('generics.index') }}" class="block py-3 border-b border-gray-700 hover:text-cyan-400">Generics</a>
                    <a href="#" class="block py-3 border-b border-gray-700 hover:text-cyan-400">Prescription Upload</a>
                    <a href="#" class="block py-3 border-b border-gray-700 hover:text-cyan-400">Health Services</a>
                    <a href="#" class="block py-3 border-b border-gray-700 hover:text-cyan-400">Contact</a>
                    
                    <!-- Mobile Categories Accordion -->
                    <div class="pt-4">
                        <h3 class="font-semibold mb-3 text-cyan-400">Categories</h3>
                        <div class="space-y-2">
                            <details class="bg-gray-700 rounded-lg">
                                <summary class="p-3 cursor-pointer flex items-center justify-between">
                                    <span class="flex items-center"><i data-lucide="pill" class="w-4 h-4 mr-2"></i> Prescription Medicines</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </summary>
                                <div class="p-3 bg-gray-800 text-sm space-y-2">
                                    <a href="#" class="block py-2 hover:text-cyan-400">Antibiotics</a>
                                    <a href="#" class="block py-2 hover:text-cyan-400">Pain Relief</a>
                                    <a href="#" class="block py-2 hover:text-cyan-400">Diabetes Care</a>
                                </div>
                            </details>
                            <details class="bg-gray-700 rounded-lg">
                                <summary class="p-3 cursor-pointer flex items-center justify-between">
                                    <span class="flex items-center"><i data-lucide="tablet" class="w-4 h-4 mr-2"></i> Over-the-Counter</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </summary>
                            </details>
                            <details class="bg-gray-700 rounded-lg">
                                <summary class="p-3 cursor-pointer flex items-center justify-between">
                                    <span class="flex items-center"><i data-lucide="heart-pulse" class="w-4 h-4 mr-2"></i> Health & Wellness</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </summary>
                            </details>
                            <details class="bg-gray-700 rounded-lg">
                                <summary class="p-3 cursor-pointer flex items-center justify-between">
                                    <span class="flex items-center"><i data-lucide="user-check" class="w-4 h-4 mr-2"></i> Personal Care</span>
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </summary>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.remove('hidden');
        });
        
        document.getElementById('mobile-menu-close')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.add('hidden');
        });
    </script>
</header>
