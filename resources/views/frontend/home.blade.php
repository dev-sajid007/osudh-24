@extends('layouts.frontend.app')
@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-8 md:py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="w-full lg:w-1/2">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Your Health is Our Priority</h2>
                    <p class="text-lg md:text-xl mb-6">Get medicines delivered to your doorstep. Safe, fast, and reliable.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button
                            class="bg-white text-cyan-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 flex items-center justify-center">
                            <i data-lucide="upload" class="w-5 h-5 mr-2"></i>
                            Upload Prescription
                        </button>
                        <button
                            class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-cyan-600 flex items-center justify-center">
                            <i data-lucide="phone" class="w-5 h-5 mr-2"></i>
                            Consult Doctor
                        </button>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 flex justify-center lg:justify-end">
                    <div class="bg-white/10 p-4 md:p-8 rounded-2xl backdrop-blur-sm w-full max-w-md">
                        <div class="grid grid-cols-2 gap-3 md:gap-4">
                            <div class="bg-white/20 p-3 md:p-4 rounded-lg text-center">
                                <i data-lucide="truck" class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2"></i>
                                <p class="text-xs md:text-sm">Free Delivery</p>
                            </div>
                            <div class="bg-white/20 p-3 md:p-4 rounded-lg text-center">
                                <i data-lucide="shield-check" class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2"></i>
                                <p class="text-xs md:text-sm">Genuine Products</p>
                            </div>
                            <div class="bg-white/20 p-3 md:p-4 rounded-lg text-center">
                                <i data-lucide="clock" class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2"></i>
                                <p class="text-xs md:text-sm">24/7 Support</p>
                            </div>
                            <div class="bg-white/20 p-3 md:p-4 rounded-lg text-center">
                                <i data-lucide="award" class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-2"></i>
                                <p class="text-xs md:text-sm">Licensed</p>
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
                <a href="{{ route('products.index') }}" class="text-cyan-600 hover:text-cyan-700 font-semibold">View All</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="relative">
                                @if ($product->images && count($product->images) > 0)
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                                        <i data-lucide="pill" class="w-16 h-16 text-gray-400"></i>
                                    </div>
                                @endif

                                @if ($product->discount > 0)
                                    <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">
                                        -{{ number_format($product->discount, 0) }}%
                                    </span>
                                @endif

                                @if ($product->created_at->diffInDays() <= 7)
                                    <span
                                        class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 text-xs rounded">New</span>
                                @endif

                                <button
                                    onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist({{ $product->id }})"
                                    class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200 wishlist-btn"
                                    data-product-id="{{ $product->id }}" data-in-wishlist="false"
                                    title="Add to Wishlist">
                                    <i class="fas fa-heart text-gray-400"></i>
                                </button>
                            </div>
                        </a>
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-cyan-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            @if ($product->strength)
                                <p class="text-sm text-gray-600 mb-2">{{ $product->strength }}</p>
                            @else
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($product->description, 50) }}</p>
                            @endif

                            <div class="flex items-center mb-3">
                                <div class="flex text-yellow-400">
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm text-gray-500 ml-2">({{ rand(20, 200) }})</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-lg font-bold text-cyan-600">${{ number_format($product->unit_price, 2) }}</span>
                                    @if ($product->discount > 0)
                                        <span
                                            class="text-sm text-gray-500 line-through ml-2">${{ number_format($product->mrp, 2) }}</span>
                                    @endif
                                </div>
                                <div class="add-to-cart-form">
                                    @if ($product->stock_quantity > 0)
                                        <button
                                            onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }})"
                                            class="add-to-cart-btn bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center"
                                            data-product-id="{{ $product->id }}">
                                            <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i>
                                            Add to Cart
                                        </button>
                                    @else
                                        <span class="text-red-500 text-sm font-semibold">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i data-lucide="package" class="w-16 h-16 mx-auto"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">No Featured Products Yet</h3>
                        <p class="text-gray-500">We're working on adding some amazing products for you!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Featured Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold">Top Products</h2>
                <a href="{{ route('products.index') }}" class="text-cyan-600 hover:text-cyan-700 font-semibold">View All</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="relative">
                                @if ($product->images && count($product->images) > 0)
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                                        <i data-lucide="pill" class="w-16 h-16 text-gray-400"></i>
                                    </div>
                                @endif

                                @if ($product->discount > 0)
                                    <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">
                                        -{{ number_format($product->discount, 0) }}%
                                    </span>
                                @endif

                                @if ($product->created_at->diffInDays() <= 7)
                                    <span
                                        class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 text-xs rounded">New</span>
                                @endif

                                <button
                                    onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist({{ $product->id }})"
                                    class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200 wishlist-btn"
                                    data-product-id="{{ $product->id }}" data-in-wishlist="false"
                                    title="Add to Wishlist">
                                    <i class="fas fa-heart text-gray-400"></i>
                                </button>
                            </div>
                        </a>
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-cyan-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            @if ($product->strength)
                                <p class="text-sm text-gray-600 mb-2">{{ $product->strength }}</p>
                            @else
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($product->description, 50) }}</p>
                            @endif

                            <div class="flex items-center mb-3">
                                <div class="flex text-yellow-400">
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    <i data-lucide="star" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm text-gray-500 ml-2">({{ rand(20, 200) }})</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-lg font-bold text-cyan-600">${{ number_format($product->unit_price, 2) }}</span>
                                    @if ($product->discount > 0)
                                        <span
                                            class="text-sm text-gray-500 line-through ml-2">${{ number_format($product->mrp, 2) }}</span>
                                    @endif
                                </div>
                                <div class="add-to-cart-form">
                                    @if ($product->stock_quantity > 0)
                                        <button
                                            onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }})"
                                            class="add-to-cart-btn bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center"
                                            data-product-id="{{ $product->id }}">
                                            <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i>
                                            Add to Cart
                                        </button>
                                    @else
                                        <span class="text-red-500 text-sm font-semibold">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i data-lucide="package" class="w-16 h-16 mx-auto"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">No Featured Products Yet</h3>
                        <p class="text-gray-500">We're working on adding some amazing products for you!</p>
                    </div>
                @endforelse
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

    <script>
        // Add to cart functionality
        function addToCart(productId) {
            const button = event.target.closest('button');

            // Disable button and show loading state
            button.disabled = true;
            const originalText = button.innerHTML;
            button.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-1 animate-spin"></i>Adding...';

            // Make AJAX request to add to cart
            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showNotification(data.message, 'success');

                        // Update cart count in header if it exists
                        updateCartCount(data.cart_count);
                    } else {
                        // Show error message
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while adding to cart. Please try again.', 'error');
                })
                .finally(() => {
                    // Re-enable button and restore original text
                    button.disabled = false;
                    button.innerHTML = originalText;

                    // Re-initialize lucide icons for the button
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
        }

        // Show notification function
        function showNotification(message, type = 'info') {
            // Remove any existing notifications
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg max-w-sm ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                'bg-blue-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-1">${message}</div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            `;

            // Add to page
            document.body.appendChild(notification);

            // Initialize lucide icons for the close button
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Update cart count in header
        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = count;
                // Add a small animation
                element.classList.add('animate-pulse');
                setTimeout(() => {
                    element.classList.remove('animate-pulse');
                }, 1000);
            });
        }

        // Wishlist functionality placeholder
        function toggleWishlist(productId) {
            console.log(`Toggling wishlist for product ${productId}`);

            // Basic implementation
            const button = document.querySelector(`[data-product-id="${productId}"]`);
            const icon = button.querySelector('i');

            if (icon.classList.contains('text-gray-400')) {
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-red-500');
                button.title = 'Remove from Wishlist';
            } else {
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-400');
                button.title = 'Add to Wishlist';
            }
        }
    </script>

@endsection
