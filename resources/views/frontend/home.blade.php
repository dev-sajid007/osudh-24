@extends('layouts.frontend.app')
@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="w-1/2">
                    <h2 class="text-5xl font-bold mb-4">Your Health is Our Priority</h2>
                    <p class="text-xl mb-6">Get medicines delivered to your doorstep. Safe, fast, and reliable.</p>
                    <div class="flex space-x-4">
                        <button
                            class="bg-white text-cyan-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 flex items-center">
                            <i data-lucide="upload" class="w-5 h-5 mr-2"></i>
                            Upload Prescription
                        </button>
                        <button
                            class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-cyan-600 flex items-center">
                            <i data-lucide="phone" class="w-5 h-5 mr-2"></i>
                            Consult Doctor
                        </button>
                    </div>
                </div>
                <div class="w-1/2 flex justify-end">
                    <div class="bg-white/10 p-8 rounded-2xl backdrop-blur-sm">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/20 p-4 rounded-lg text-center">
                                <i data-lucide="truck" class="w-8 h-8 mx-auto mb-2"></i>
                                <p class="text-sm">Free Delivery</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-lg text-center">
                                <i data-lucide="shield-check" class="w-8 h-8 mx-auto mb-2"></i>
                                <p class="text-sm">Genuine Products</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-lg text-center">
                                <i data-lucide="clock" class="w-8 h-8 mx-auto mb-2"></i>
                                <p class="text-sm">24/7 Support</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-lg text-center">
                                <i data-lucide="award" class="w-8 h-8 mx-auto mb-2"></i>
                                <p class="text-sm">Licensed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold">Shop by Category</h2>
                <a href="{{ route('categories.index') }}" class="text-cyan-600 hover:text-cyan-700 font-semibold">View All
                    Categories</a>
            </div>

            @if ($featuredCategories->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach ($featuredCategories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="text-center group cursor-pointer">
                            <div class="bg-cyan-100 p-6 rounded-xl mb-4 group-hover:bg-cyan-200 transition-colors relative">
                                @if ($category->image_url)
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                        class="w-12 h-12 mx-auto rounded">
                                @else
                                    <i data-lucide="package" class="w-12 h-12 mx-auto text-cyan-600"></i>
                                @endif

                                @if ($category->products_count > 0)
                                    <span
                                        class="absolute -top-2 -right-2 bg-cyan-600 text-white text-xs px-2 py-1 rounded-full">
                                        {{ $category->products_count }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-semibold text-sm">{{ $category->name }}</h3>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Fallback static categories when no categories exist -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    <div class="text-center group cursor-pointer">
                        <div class="bg-cyan-100 p-6 rounded-xl mb-4 group-hover:bg-cyan-200 transition-colors">
                            <i data-lucide="pill" class="w-12 h-12 mx-auto text-cyan-600"></i>
                        </div>
                        <h3 class="font-semibold">Medicines</h3>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="bg-cyan-100 p-6 rounded-xl mb-4 group-hover:bg-cyan-200 transition-colors">
                            <i data-lucide="heart-pulse" class="w-12 h-12 mx-auto text-cyan-600"></i>
                        </div>
                        <h3 class="font-semibold">Health Care</h3>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="bg-cyan-100 p-6 rounded-xl mb-4 group-hover:bg-cyan-200 transition-colors">
                            <i data-lucide="baby" class="w-12 h-12 mx-auto text-cyan-600"></i>
                        </div>
                        <h3 class="font-semibold">Baby Care</h3>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="bg-cyan-100 p-6 rounded-xl mb-4 group-hover:bg-cyan-200 transition-colors">
                            <i data-lucide="flower" class="w-12 h-12 mx-auto text-cyan-600"></i>
                        </div>
                        <h3 class="font-semibold">Beauty</h3>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="bg-cyan-100 p-6 rounded-xl mb-4 group-hover:bg-cyan-200 transition-colors">
                            <i data-lucide="dumbbell" class="w-12 h-12 mx-auto text-cyan-600"></i>
                        </div>
                        <h3 class="font-semibold">Fitness</h3>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="bg-cyan-100 p-6 rounded-xl mb-4 group-hover:bg-cyan-200 transition-colors">
                            <i data-lucide="stethoscope" class="w-12 h-12 mx-auto text-cyan-600"></i>
                        </div>
                        <h3 class="font-semibold">Devices</h3>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold">Featured Products</h2>
                <a href="#" class="text-cyan-600 hover:text-cyan-700 font-semibold">View All</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Product Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i data-lucide="pill" class="w-16 h-16 text-gray-400"></i>
                        </div>
                        <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">-20%</span>
                        <button onclick="toggleWishlist(1)"
                            class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200 wishlist-btn"
                            data-product-id="1" data-in-wishlist="false" title="Add to Wishlist">
                            <i class="fas fa-heart text-gray-400"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2">Paracetamol 500mg</h3>
                        <p class="text-sm text-gray-600 mb-2">Pain Relief & Fever Reducer</p>
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400">
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(124)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-cyan-600">$8.99</span>
                                <span class="text-sm text-gray-500 line-through ml-2">$11.24</span>
                            </div>
                            <div class="add-to-cart-form">
                                <button
                                    class="add-to-cart-btn bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center"
                                    data-product-id="1">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i data-lucide="thermometer" class="w-16 h-16 text-gray-400"></i>
                        </div>
                        <button onclick="toggleWishlist(2)"
                            class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200 wishlist-btn"
                            data-product-id="2" data-in-wishlist="false" title="Add to Wishlist">
                            <i class="fas fa-heart text-gray-400"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2">Digital Thermometer</h3>
                        <p class="text-sm text-gray-600 mb-2">Fast & Accurate Reading</p>
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400">
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(89)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-cyan-600">$24.99</span>
                            </div>
                            <div class="add-to-cart-form">
                                <button
                                    class="add-to-cart-btn bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center"
                                    data-product-id="2">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i data-lucide="droplets" class="w-16 h-16 text-gray-400"></i>
                        </div>
                        <span class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 text-xs rounded">New</span>
                        <button onclick="toggleWishlist(3)"
                            class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200 wishlist-btn"
                            data-product-id="3" data-in-wishlist="false" title="Add to Wishlist">
                            <i class="fas fa-heart text-gray-400"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2">Hand Sanitizer</h3>
                        <p class="text-sm text-gray-600 mb-2">70% Alcohol - 500ml</p>
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400">
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(67)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-cyan-600">$12.50</span>
                            </div>
                            <div class="add-to-cart-form">
                                <button
                                    class="add-to-cart-btn bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center"
                                    data-product-id="3">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                            <i data-lucide="activity" class="w-16 h-16 text-gray-400"></i>
                        </div>
                        <button onclick="toggleWishlist(4)"
                            class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200 wishlist-btn"
                            data-product-id="4" data-in-wishlist="false" title="Add to Wishlist">
                            <i class="fas fa-heart text-gray-400"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2">Blood Pressure Monitor</h3>
                        <p class="text-sm text-gray-600 mb-2">Digital Automatic Cuff</p>
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400">
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(156)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-cyan-600">$89.99</span>
                            </div>
                            <div class="add-to-cart-form">
                                <button
                                    class="add-to-cart-btn bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center"
                                    data-product-id="4">
                                    <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="text-center p-6 rounded-xl border border-gray-200 hover:border-cyan-200 hover:shadow-lg transition-all">
                    <div class="bg-cyan-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="upload" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Prescription Upload</h3>
                    <p class="text-gray-600 mb-4">Upload your prescription and get medicines delivered to your doorstep.
                    </p>
                    <button class="text-cyan-600 font-semibold hover:text-cyan-700">Learn More →</button>
                </div>
                <div
                    class="text-center p-6 rounded-xl border border-gray-200 hover:border-cyan-200 hover:shadow-lg transition-all">
                    <div class="bg-cyan-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="video" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Online Consultation</h3>
                    <p class="text-gray-600 mb-4">Consult with certified doctors from the comfort of your home.</p>
                    <button class="text-cyan-600 font-semibold hover:text-cyan-700">Book Now →</button>
                </div>
                <div
                    class="text-center p-6 rounded-xl border border-gray-200 hover:border-cyan-200 hover:shadow-lg transition-all">
                    <div class="bg-cyan-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="test-tube" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Lab Tests</h3>
                    <p class="text-gray-600 mb-4">Book lab tests and get reports delivered digitally.</p>
                    <button class="text-cyan-600 font-semibold hover:text-cyan-700">Browse Tests →</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-cyan-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Updated with Health Tips</h2>
            <p class="text-xl mb-8">Subscribe to our newsletter for the latest health news and exclusive offers.</p>
            <div class="max-w-md mx-auto flex">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 px-4 py-3 rounded-l-lg text-gray-800 focus:outline-none">
                <button class="bg-cyan-800 hover:bg-cyan-900 px-6 py-3 rounded-r-lg font-semibold">
                    Subscribe
                </button>
            </div>
        </div>
    </section>

@endsection
