@extends('layouts.frontend.app')

@section('title', 'Compare Generics')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Compare Medicines by Active Ingredient</h1>
            <p class="text-cyan-100 mt-2">Find the best alternative medicines with the same active ingredients</p>
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
                    <li class="text-gray-700 font-medium">Compare</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('generics.compare') }}" class="max-w-2xl mx-auto">
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search for medicines or active ingredients..."
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                    <button type="submit" class="bg-cyan-600 text-white px-8 py-3 rounded-lg hover:bg-cyan-700 transition-colors">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Comparison Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            @if ($genericGroups->count() > 0)
                <div class="space-y-8">
                    @foreach ($genericGroups as $group)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <!-- Generic Header -->
                            <div class="bg-gradient-to-r from-cyan-50 to-cyan-100 px-6 py-4 border-b border-cyan-200">
                                <h3 class="text-xl font-bold text-cyan-900">
                                    <i data-lucide="beaker" class="w-5 h-5 inline mr-2"></i>
                                    {{ $group['generic']->name }}
                                </h3>
                                @if ($group['generic']->description)
                                    <p class="text-sm text-cyan-700 mt-1">{{ $group['generic']->description }}</p>
                                @endif
                            </div>

                            <!-- Price Range Info -->
                            <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                                <span class="text-sm text-gray-600">
                                    <strong>{{ $group['count'] }}</strong> {{ $group['count'] == 1 ? 'product' : 'products' }} available
                                </span>
                                <span class="text-sm font-semibold text-cyan-600">
                                    Price Range: ৳{{ number_format($group['min_price'], 2) }} - ৳{{ number_format($group['max_price'], 2) }}
                                </span>
                            </div>

                            <!-- Products Grid -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($group['products'] as $product)
                                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                                <div class="relative bg-gray-100 h-32">
                                                    @if ($product->images && count($product->images) > 0)
                                                        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center">
                                                            <i data-lucide="pill" class="w-8 h-8 text-gray-400"></i>
                                                        </div>
                                                    @endif

                                                    @if ($product->discount > 0)
                                                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                                            -{{ number_format($product->discount, 0) }}%
                                                        </span>
                                                    @endif
                                                </div>
                                            </a>

                                            <div class="p-3">
                                                <h4 class="font-semibold text-sm mb-1 line-clamp-2">
                                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-cyan-600">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>

                                                @if ($product->strength)
                                                    <p class="text-xs text-gray-600 mb-2">{{ $product->strength }}</p>
                                                @endif

                                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                                    <span class="font-bold text-cyan-600">৳{{ number_format($product->unit_price, 2) }}</span>
                                                    @if ($product->stock_quantity > 0)
                                                        <button onclick="addToCart(event, {{ $product->id }})"
                                                            class="bg-cyan-600 text-white text-xs px-2 py-1 rounded hover:bg-cyan-700 transition-colors">
                                                            Add
                                                        </button>
                                                    @else
                                                        <span class="text-red-500 text-xs font-semibold">Out of Stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i data-lucide="search" class="w-16 h-16 mx-auto"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No Products Found</h3>
                    <p class="text-gray-500 mb-6">
                        @if ($search)
                            No products found matching "{{ $search }}". Try a different search term.
                        @else
                            Start by searching for a medicine or active ingredient to compare.
                        @endif
                    </p>
                    <a href="{{ route('generics.index') }}" class="inline-block bg-cyan-600 text-white px-6 py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                        View All Generics
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
