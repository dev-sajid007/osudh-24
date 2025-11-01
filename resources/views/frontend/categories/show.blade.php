@extends('layouts.frontend.app')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
                    @if ($category->description)
                        <p class="text-xl">{{ $category->description }}</p>
                    @endif
                </div>
                @if ($category->image_url)
                    <div class="hidden md:block">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                            class="w-24 h-24 rounded-full border-4 border-white/20">
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-cyan-600 hover:text-cyan-800">
                            <i data-lucide="home" class="w-4 h-4"></i>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-1"></i>
                            <a href="{{ route('categories.index') }}"
                                class="text-cyan-600 hover:text-cyan-800">Categories</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-1"></i>
                            <span class="text-gray-500">{{ $category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <!-- Search within category -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Search in {{ $category->name }}</h3>
                    <form method="GET" action="{{ route('categories.show', $category->slug) }}">
                        <div class="relative">
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Search products..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
                        </div>
                        <button type="submit" class="w-full mt-3 bg-cyan-600 hover:bg-cyan-700 text-white py-2 rounded-lg">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Subcategories -->
                @if ($subcategories->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Subcategories</h3>
                        <ul class="space-y-2">
                            @foreach ($subcategories as $subcategory)
                                <li>
                                    <a href="{{ route('categories.show', $subcategory->slug) }}"
                                        class="flex items-center justify-between p-2 rounded hover:bg-gray-50 transition-colors">
                                        <span class="text-gray-700">{{ $subcategory->name }}</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Category Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Products:</span>
                            <span class="font-semibold">{{ $products->total() }}</span>
                        </div>
                        @if ($subcategories->count() > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subcategories:</span>
                                <span class="font-semibold">{{ $subcategories->count() }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Filters and Sorting -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-xl font-semibold">Products in {{ $category->name }}</h2>
                            <p class="text-gray-600">{{ $products->total() }}
                                {{ Str::plural('product', $products->total()) }} found</p>
                        </div>

                        <!-- Sort Options -->
                        <form method="GET" action="{{ route('categories.show', $category->slug) }}"
                            class="flex items-center gap-2">
                            @if ($search)
                                <input type="hidden" name="search" value="{{ $search }}">
                            @endif

                            <label class="text-sm text-gray-600">Sort by:</label>
                            <select name="sort" onchange="this.form.submit()"
                                class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Name</option>
                                <option value="unit_price" {{ $sortBy === 'unit_price' ? 'selected' : '' }}>Price</option>
                                <option value="stock_quantity" {{ $sortBy === 'stock_quantity' ? 'selected' : '' }}>Stock
                                </option>
                                <option value="created_at" {{ $sortBy === 'created_at' ? 'selected' : '' }}>Newest</option>
                            </select>

                            <select name="order" onchange="this.form.submit()"
                                class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-cyan-500">
                                <option value="asc" {{ request('order', 'asc') === 'asc' ? 'selected' : '' }}>Ascending
                                </option>
                                <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Descending
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                @if ($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach ($products as $product)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                <!-- Product Image -->
                                <div class="relative h-48 bg-gray-100">
                                    @if ($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <i data-lucide="pill" class="w-16 h-16 text-gray-400"></i>
                                        </div>
                                    @endif

                                    <!-- Stock Badge -->
                                    @if ($product->stock_quantity <= $product->min_stock_level)
                                        <span
                                            class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">Low
                                            Stock</span>
                                    @elseif($product->stock_quantity <= 10)
                                        <span
                                            class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 text-xs rounded">Limited</span>
                                    @endif

                                    <!-- Wishlist Button -->
                                    <x-wishlist-button :product-id="$product->id"
                                        class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200" />
                                </div>

                                <!-- Product Info -->
                                <div class="p-4">
                                    <h3 class="font-semibold mb-1 line-clamp-2">{{ $product->name }}</h3>

                                    @if ($product->generic)
                                        <p class="text-sm text-gray-600 mb-2">{{ $product->generic->name }}</p>
                                    @endif

                                    <!-- Price and Stock -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <span
                                                class="text-lg font-bold text-cyan-600">${{ number_format($product->unit_price, 2) }}</span>
                                            @if ($product->strength)
                                                <span class="text-sm text-gray-500">/ {{ $product->strength }}</span>
                                            @endif
                                        </div>
                                        <span class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</span>
                                    </div>

                                    <!-- Supplier -->
                                    @if ($product->supplier)
                                        <p class="text-xs text-gray-500 mb-3">By {{ $product->supplier->name }}</p>
                                    @endif

                                    <!-- Add to Cart Button -->
                                    <button
                                        class="w-full bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center justify-center">
                                        <i data-lucide="shopping-cart" class="w-4 h-4 mr-2"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- No Products Found -->
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <div class="mb-6">
                            <i data-lucide="package-x" class="w-24 h-24 text-gray-300 mx-auto"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Products Found</h3>
                        @if ($search)
                            <p class="text-gray-500 mb-6">No products found for "{{ $search }}" in
                                {{ $category->name }}.</p>
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="inline-flex items-center bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                                <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                                Clear Search
                            </a>
                        @else
                            <p class="text-gray-500 mb-6">No products available in this category yet.</p>
                            <a href="{{ route('categories.index') }}"
                                class="inline-flex items-center bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                                Browse Other Categories
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
