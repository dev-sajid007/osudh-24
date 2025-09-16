@extends('layouts.frontend.app')

@section('title', 'My Wishlist')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Wishlist</h1>
                <p class="text-gray-600 mt-2">{{ $totalCount }} {{ Str::plural('item', $totalCount) }} in your wishlist</p>
            </div>

            @if ($totalCount > 0)
                <button onclick="clearWishlist()"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>
                    Clear All
                </button>
            @endif
        </div>

        @if ($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 wishlist-item"
                        data-product-id="{{ $product->id }}">
                        <!-- Product Image -->
                        <div class="relative aspect-square">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-pills text-4xl text-gray-400"></i>
                                </div>
                            @endif

                            <!-- Remove from Wishlist Button -->
                            <button onclick="removeFromWishlist({{ $product->id }})"
                                class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200 remove-wishlist-btn">
                                <i class="fas fa-heart text-red-500"></i>
                            </button>

                            <!-- Stock Status -->
                            @if ($product->stock_quantity <= 0)
                                <div
                                    class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-medium">
                                    Out of Stock
                                </div>
                            @elseif($product->stock_quantity <= 10)
                                <div
                                    class="absolute top-2 left-2 bg-orange-500 text-white px-2 py-1 rounded text-xs font-medium">
                                    Low Stock
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>

                            @if ($product->category)
                                <p class="text-sm text-gray-500 mb-2">{{ $product->category->name }}</p>
                            @endif

                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="text-2xl font-bold text-cyan-600">₹{{ number_format($product->price, 2) }}</span>
                                @if ($product->mrp && $product->mrp > $product->price)
                                    <span
                                        class="text-sm text-gray-500 line-through">₹{{ number_format($product->mrp, 2) }}</span>
                                @endif
                            </div>

                            @if ($product->description)
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                @if ($product->stock_quantity > 0)
                                    <button
                                        class="flex-1 bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Add to Cart
                                    </button>
                                @else
                                    <button
                                        class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg font-medium cursor-not-allowed"
                                        disabled>
                                        <i class="fas fa-ban mr-2"></i>
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Continue Shopping -->
            <div class="text-center mt-12">
                <a href="{{ route('categories.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Continue Shopping
                </a>
            </div>
        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-12">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 mb-6">
                    <i class="fas fa-heart text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Your wishlist is empty</h3>
                <p class="text-gray-500 mb-8">Discover amazing products and add them to your wishlist!</p>
                <a href="{{ route('categories.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

    <!-- Success/Error Messages -->
    <div id="wishlist-message"
        class="fixed top-4 right-4 max-w-sm transform translate-x-full transition-transform duration-300 z-50">
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500" id="message-icon"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900" id="message-text"></p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="hideMessage()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function removeFromWishlist(productId) {
                fetch('{{ route('wishlist.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the product card from view
                            const productCard = document.querySelector(`.wishlist-item[data-product-id="${productId}"]`);
                            if (productCard) {
                                productCard.remove();
                            }

                            // Update wishlist count
                            updateWishlistCount(data.count);

                            // Show success message
                            showMessage(data.message, 'success');

                            // Reload page if no items left
                            if (data.count === 0) {
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                // Update count display
                                const countElement = document.querySelector('p.text-gray-600');
                                if (countElement) {
                                    countElement.textContent =
                                        `${data.count} ${data.count === 1 ? 'item' : 'items'} in your wishlist`;
                                }
                            }
                        } else {
                            showMessage(data.message || 'Error removing item from wishlist', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('Error removing item from wishlist', 'error');
                    });
            }

            function clearWishlist() {
                if (!confirm('Are you sure you want to clear your entire wishlist?')) {
                    return;
                }

                fetch('{{ route('wishlist.clear') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateWishlistCount(0);
                            showMessage(data.message, 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showMessage(data.message || 'Error clearing wishlist', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('Error clearing wishlist', 'error');
                    });
            }

            function showMessage(message, type = 'success') {
                const messageDiv = document.getElementById('wishlist-message');
                const messageText = document.getElementById('message-text');
                const messageIcon = document.getElementById('message-icon');

                messageText.textContent = message;

                if (type === 'success') {
                    messageIcon.className = 'fas fa-check-circle text-green-500';
                } else {
                    messageIcon.className = 'fas fa-exclamation-circle text-red-500';
                }

                messageDiv.classList.remove('translate-x-full');

                setTimeout(() => {
                    hideMessage();
                }, 3000);
            }

            function hideMessage() {
                const messageDiv = document.getElementById('wishlist-message');
                messageDiv.classList.add('translate-x-full');
            }

            function updateWishlistCount(count) {
                // Update header wishlist count if it exists
                const countElements = document.querySelectorAll('.wishlist-count');
                countElements.forEach(element => {
                    element.textContent = count;
                    if (count > 0) {
                        element.classList.remove('hidden');
                    } else {
                        element.classList.add('hidden');
                    }
                });
            }
        </script>
    @endpush
@endsection
