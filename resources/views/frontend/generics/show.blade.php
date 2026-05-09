@extends('layouts.frontend.app')

@section('title', $generic->name)

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">{{ $generic->name }}</h1>
            @if ($generic->description)
                <p class="text-cyan-100 mt-2">{{ $generic->description }}</p>
            @endif
        </div>
    </section>

    <!-- Breadcrumb -->
    <section class="py-4 bg-gray-50">
        <div class="container mx-auto px-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-cyan-600 hover:text-cyan-700 font-medium">
                            <i data-lucide="home" class="w-4 h-4 inline mr-1"></i>Home
                        </a>
                    </li>
                    <li class="text-gray-500">/</li>
                    <li>
                        <a href="{{ route('generics.index') }}" class="text-cyan-600 hover:text-cyan-700 font-medium">
                            Generics
                        </a>
                    </li>
                    <li class="text-gray-500">/</li>
                    <li class="text-gray-700 font-medium">{{ $generic->name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            @if ($products->count() > 0)
                <!-- Results Info -->
                <div class="mb-8">
                    <p class="text-gray-600">
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of
                        {{ $products->total() }} products containing <strong>{{ $generic->name }}</strong>
                    </p>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($products as $product)
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

                                @if ($product->category)
                                    <p class="text-xs text-gray-500 mb-3">
                                        <i data-lucide="tag" class="w-3 h-3 inline mr-1"></i>
                                        {{ $product->category->name }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                    <div>
                                        <span class="text-lg font-bold text-cyan-600">৳{{ number_format($product->unit_price, 2) }}</span>
                                        @if ($product->discount > 0)
                                            <span class="text-sm text-gray-500 line-through ml-2">৳{{ number_format($product->mrp, 2) }}</span>
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
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i data-lucide="search" class="w-16 h-16 mx-auto"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No Products Found</h3>
                    <p class="text-gray-500 mb-6">No products containing {{ $generic->name }} are currently available.</p>
                    <a href="{{ route('generics.index') }}"
                        class="inline-block bg-cyan-600 text-white px-6 py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                        View All Generics
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
