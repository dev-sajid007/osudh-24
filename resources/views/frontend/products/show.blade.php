@extends('layouts.frontend.app')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb -->
    <nav class="bg-gray-50 py-4">
        <div class="container mx-auto px-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-cyan-600 hover:text-cyan-700">Home</a></li>
                <li class="text-gray-400">/</li>
                @if ($product->category)
                    <li><a href="{{ route('products.index', ['category' => $product->category->id]) }}"
                            class="text-cyan-600 hover:text-cyan-700">{{ $product->category->name }}</a></li>
                    <li class="text-gray-400">/</li>
                @endif
                <li class="text-gray-600">{{ $product->name }}</li>
            </ol>
        </div>
    </nav>

    <!-- Product Details -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        @if ($product->images && count($product->images) > 0)
                            <img id="mainImage" src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <i data-lucide="package" class="w-32 h-32 text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    @if ($product->images && count($product->images) > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->images as $index => $image)
                                <button onclick="changeMainImage('{{ $image }}')"
                                    class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 hover:border-cyan-500 transition-colors {{ $index === 0 ? 'border-cyan-500' : 'border-transparent' }}">
                                    <img src="{{ $image }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        @if ($product->brand)
                            <p class="text-lg text-gray-600">by {{ $product->brand }}</p>
                        @endif
                        @if ($product->generic_name)
                            <p class="text-sm text-gray-500">Generic: {{ $product->generic_name }}</p>
                        @endif
                    </div>

                    <!-- Ratings -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">({{ rand(50, 300) }} reviews)</span>
                        </div>
                        @if ($product->prescription_required)
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                Prescription Required
                            </span>
                        @else
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                Over the Counter
                            </span>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        @if ($product->strength)
                            <div>
                                <span class="font-medium text-gray-700">Strength:</span>
                                <span class="text-gray-600">{{ $product->strength }}</span>
                            </div>
                        @endif
                        @if ($product->form)
                            <div>
                                <span class="font-medium text-gray-700">Form:</span>
                                <span class="text-gray-600">{{ ucfirst($product->form) }}</span>
                            </div>
                        @endif
                        @if ($product->package_size)
                            <div>
                                <span class="font-medium text-gray-700">Package Size:</span>
                                <span class="text-gray-600">{{ $product->package_size }}</span>
                            </div>
                        @endif
                        @if ($product->sku)
                            <div>
                                <span class="font-medium text-gray-700">SKU:</span>
                                <span class="text-gray-600">{{ $product->sku }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <span
                                class="text-3xl font-bold text-cyan-600">${{ number_format($product->unit_price, 2) }}</span>
                            @if ($product->discount > 0)
                                <span
                                    class="text-lg text-gray-500 line-through">${{ number_format($product->mrp, 2) }}</span>
                                <span class="bg-red-500 text-white px-2 py-1 text-sm rounded">
                                    {{ number_format($product->discount, 0) }}% OFF
                                </span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-6">
                            @if ($product->stock_quantity > 0)
                                @if ($product->stock_quantity <= $product->minimum_stock)
                                    <span class="text-orange-600 font-medium">
                                        <i data-lucide="alert-triangle" class="w-4 h-4 inline mr-1"></i>
                                        Only {{ $product->stock_quantity }} left in stock
                                    </span>
                                @else
                                    <span class="text-green-600 font-medium">
                                        <i data-lucide="check-circle" class="w-4 h-4 inline mr-1"></i>
                                        In Stock ({{ $product->stock_quantity }} available)
                                    </span>
                                @endif
                            @else
                                <span class="text-red-600 font-medium">
                                    <i data-lucide="x-circle" class="w-4 h-4 inline mr-1"></i>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            @if ($product->stock_quantity > 0)
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" onclick="decreaseQuantity()" class="p-2 hover:bg-gray-50">
                                            <i data-lucide="minus" class="w-4 h-4"></i>
                                        </button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            max="{{ $product->stock_quantity }}"
                                            class="w-16 text-center border-0 focus:ring-0">
                                        <button type="button" onclick="increaseQuantity()" class="p-2 hover:bg-gray-50">
                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <button onclick="addToCart({{ $product->id }})"
                                        class="flex-1 bg-cyan-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-cyan-700 transition-colors flex items-center justify-center">
                                        <i data-lucide="shopping-cart" class="w-5 h-5 mr-2"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            @endif

                            <div class="flex space-x-3">
                                <button onclick="toggleWishlist({{ $product->id }})"
                                    class="flex-1 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center justify-center wishlist-btn"
                                    data-product-id="{{ $product->id }}" data-in-wishlist="false">
                                    <i class="fas fa-heart mr-2"></i>
                                    Add to Wishlist
                                </button>
                                <button
                                    class="border border-gray-300 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i data-lucide="share-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Description & Details -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-sm">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6">
                        <button onclick="showTab('description')"
                            class="tab-button py-4 border-b-2 border-transparent hover:border-cyan-500 text-gray-700 hover:text-cyan-600 font-medium active"
                            data-tab="description">
                            Description
                        </button>
                        <button onclick="showTab('usage')"
                            class="tab-button py-4 border-b-2 border-transparent hover:border-cyan-500 text-gray-700 hover:text-cyan-600 font-medium"
                            data-tab="usage">
                            Usage Instructions
                        </button>
                        @if ($product->side_effects)
                            <button onclick="showTab('side-effects')"
                                class="tab-button py-4 border-b-2 border-transparent hover:border-cyan-500 text-gray-700 hover:text-cyan-600 font-medium"
                                data-tab="side-effects">
                                Side Effects
                            </button>
                        @endif
                        <button onclick="showTab('storage')"
                            class="tab-button py-4 border-b-2 border-transparent hover:border-cyan-500 text-gray-700 hover:text-cyan-600 font-medium"
                            data-tab="storage">
                            Storage
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <div id="description-tab" class="tab-content">
                        <h3 class="text-lg font-semibold mb-4">Product Description</h3>
                        <div class="prose max-w-none">
                            {!! $product->description
                                ? nl2br(e($product->description))
                                : '<p class="text-gray-500">No description available.</p>' !!}
                        </div>
                    </div>

                    <div id="usage-tab" class="tab-content hidden">
                        <h3 class="text-lg font-semibold mb-4">Usage Instructions</h3>
                        <div class="prose max-w-none">
                            {!! $product->usage_instructions
                                ? nl2br(e($product->usage_instructions))
                                : '<p class="text-gray-500">No usage instructions available. Please consult your healthcare provider.</p>' !!}
                        </div>
                    </div>

                    @if ($product->side_effects)
                        <div id="side-effects-tab" class="tab-content hidden">
                            <h3 class="text-lg font-semibold mb-4">Side Effects</h3>
                            <div class="prose max-w-none">
                                {!! nl2br(e($product->side_effects)) !!}
                            </div>
                        </div>
                    @endif

                    <div id="storage-tab" class="tab-content hidden">
                        <h3 class="text-lg font-semibold mb-4">Storage Instructions</h3>
                        <div class="prose max-w-none">
                            {!! $product->storage_instructions
                                ? nl2br(e($product->storage_instructions))
                                : '<p class="text-gray-500">Store in a cool, dry place away from direct sunlight.</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if ($relatedProducts->count() > 0)
        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold mb-8">Related Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                <div class="relative">
                                    @if ($relatedProduct->images && count($relatedProduct->images) > 0)
                                        <img src="{{ $relatedProduct->images[0] }}" alt="{{ $relatedProduct->name }}"
                                            class="w-full h-48 object-cover">
                                    @else
                                        <div class="bg-gray-200 h-48 flex items-center justify-center">
                                            <i data-lucide="pill" class="w-16 h-16 text-gray-400"></i>
                                        </div>
                                    @endif

                                    @if ($relatedProduct->discount > 0)
                                        <span
                                            class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">
                                            -{{ number_format($relatedProduct->discount, 0) }}%
                                        </span>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <h3 class="font-semibold mb-2">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}"
                                        class="hover:text-cyan-600">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h3>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span
                                            class="text-lg font-bold text-cyan-600">${{ number_format($relatedProduct->unit_price, 2) }}</span>
                                        @if ($relatedProduct->discount > 0)
                                            <span
                                                class="text-sm text-gray-500 line-through ml-2">${{ number_format($relatedProduct->mrp, 2) }}</span>
                                        @endif
                                    </div>
                                    @if ($relatedProduct->stock_quantity > 0)
                                        <button onclick="addToCart({{ $relatedProduct->id }})"
                                            class="bg-cyan-600 text-white px-3 py-2 rounded-lg hover:bg-cyan-700 text-sm">
                                            Add to Cart
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <script>
        // Image gallery functionality
        function changeMainImage(imageUrl) {
            document.getElementById('mainImage').src = imageUrl;

            // Update active thumbnail
            const thumbnails = document.querySelectorAll('.grid button');
            thumbnails.forEach((thumb, index) => {
                const img = thumb.querySelector('img');
                if (img && img.src === imageUrl) {
                    thumb.classList.remove('border-transparent');
                    thumb.classList.add('border-cyan-500');
                } else {
                    thumb.classList.remove('border-cyan-500');
                    thumb.classList.add('border-transparent');
                }
            });
        }

        // Quantity controls
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-cyan-500', 'text-cyan-600');
                button.classList.add('border-transparent', 'text-gray-700');
            });

            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.remove('hidden');

            // Add active class to selected tab button
            const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
            activeButton.classList.add('active', 'border-cyan-500', 'text-cyan-600');
            activeButton.classList.remove('border-transparent', 'text-gray-700');
        }

        // Add to cart functionality
        function addToCart(productId) {
            console.log('addToCart called with productId:', productId);

            const quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;
            const button = event.target.closest('button');

            console.log('Quantity:', quantity, 'Button:', button);

            // Disable button and show loading state
            button.disabled = true;
            const originalText = button.innerHTML;
            button.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 mr-2 animate-spin"></i>Adding...';

            console.log('Making AJAX request to /cart/add');

            // Make AJAX request to add to cart
            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        quantity: parseInt(quantity)
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);

                    if (data.success) {
                        // Show success message
                        showNotification(data.message, 'success');

                        // Update cart count in header if it exists
                        updateCartCount(data.cart_count);
                    } else {
                        // Show error message
                        showNotification(data.message || 'Failed to add product to cart', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error details:', error);
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
        } // Show notification function
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
    </script>
@endsection
