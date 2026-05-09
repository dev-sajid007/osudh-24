@extends('layouts.frontend.app')

@section('title', 'Products')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">All Products</h1>
            <p class="text-cyan-100 mt-2">Discover our wide range of medicines and healthcare products</p>
        </div>
    </section>

    <!-- Filters and Products -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                        <h3 class="text-lg font-semibold mb-4">Filters</h3>

                        <!-- Search -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search products..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                                    <i data-lucide="search" class="absolute left-3 top-2.5 w-5 h-5 text-gray-400"></i>
                                </div>
                                <!-- Preserve other filters -->
                                @foreach (request()->except(['search', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <button type="submit"
                                    class="w-full mt-2 bg-cyan-600 text-white py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                                    Search
                                </button>
                            </form>
                        </div>

                        <!-- Categories -->
                        @if ($categories->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                                <div class="space-y-2">
                                    @foreach ($categories as $category)
                                        <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $category->id])) }}"
                                            class="flex items-center justify-between p-2 rounded hover:bg-gray-50 {{ request('category') == $category->id ? 'bg-cyan-50 text-cyan-600' : 'text-gray-700' }}">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-sm text-gray-500">({{ $category->products_count }})</span>
                                        </a>
                                    @endforeach
                                </div>
                                @if (request('category'))
                                    <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
                                        class="text-sm text-cyan-600 hover:text-cyan-700 mt-2 inline-block">
                                        Clear Category Filter
                                    </a>
                                @endif
                            </div>
                        @endif

                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}"
                                        placeholder="Min" step="0.01"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}"
                                        placeholder="Max" step="0.01"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                                </div>
                                <!-- Preserve other filters -->
                                @foreach (request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <button type="submit"
                                    class="w-full mt-2 bg-cyan-600 text-white py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                                    Apply Price Filter
                                </button>
                            </form>
                        </div>

                        <!-- Clear All Filters -->
                        @if (request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                            <a href="{{ route('products.index') }}"
                                class="block w-full text-center py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="lg:w-3/4">
                    <!-- Sort and Results Info -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                        <div class="text-gray-600 mb-4 sm:mb-0">
                            Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of
                            {{ $products->total() }} products
                        </div>

                        <form method="GET" action="{{ route('products.index') }}" class="flex items-center space-x-2">
                            <label for="sort" class="text-sm font-medium text-gray-700">Sort by:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low
                                    to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price:
                                    High to Low</option>
                            </select>
                            <!-- Preserve other filters -->
                            @foreach (request()->except(['sort', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        </form>
                    </div>

                    <!-- Products Grid -->
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($products as $product)
                                <div
                                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
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
                                                <span
                                                    class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">
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
                                            <a href="{{ route('products.show', $product->slug) }}"
                                                class="hover:text-cyan-600">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        @if ($product->strength)
                                            <p class="text-sm text-gray-600 mb-2">{{ $product->strength }}</p>
                                        @else
                                            <p class="text-sm text-gray-600 mb-2">
                                                {{ Str::limit($product->description, 50) }}</p>
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
                                            @if ($product->stock_quantity > 0)
                                                <button onclick="addToCart(event, {{ $product->id }})"
                                                    class="bg-cyan-600 text-white px-3 py-2 rounded-lg hover:bg-cyan-700 text-sm transition-colors">
                                                    Add to Cart
                                                </button>
                                            @else
                                                <span class="text-red-500 text-sm font-semibold">Out of Stock</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i data-lucide="search" class="w-16 h-16 mx-auto"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">No Products Found</h3>
                            <p class="text-gray-500 mb-4">We couldn't find any products matching your criteria.</p>
                            @if (request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                                <a href="{{ route('products.index') }}"
                                    class="inline-block bg-cyan-600 text-white px-6 py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        // Add to cart functionality
        function addToCart(e, productId) {
            e = e || window.event;
            const button = e?.target?.closest('button') || document.querySelector(`button[data-product-id="${productId}"]`);
            if (!button) {
                console.error('Add to cart button not found for product', productId);
                return;
            }

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
                // Show or hide the badge based on count
                if (count > 0) {
                    element.classList.remove('hidden');
                } else {
                    element.classList.add('hidden');
                }
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
