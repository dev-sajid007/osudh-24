@extends('layouts.frontend.app')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Browse Categories</h1>
                <p class="text-xl">Find medicines and health products by category</p>
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
                            <span class="text-gray-500">Categories</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Categories Grid -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            @if ($categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($categories as $category)
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <!-- Category Image -->
                            <div class="relative h-48 bg-gradient-to-br from-cyan-50 to-cyan-100">
                                @if ($category->image_url)
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <i data-lucide="package" class="w-16 h-16 text-cyan-400"></i>
                                    </div>
                                @endif

                                <!-- Product Count Badge -->
                                @if ($category->products_count > 0)
                                    <div
                                        class="absolute top-3 right-3 bg-cyan-600 text-white px-2 py-1 rounded-full text-sm font-semibold">
                                        {{ $category->products_count }}
                                        {{ Str::plural('product', $category->products_count) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Category Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $category->name }}</h3>

                                @if ($category->description)
                                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $category->description }}</p>
                                @endif

                                <!-- Subcategories Preview -->
                                @if ($category->children->count() > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Subcategories:</h4>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($category->children->take(3) as $child)
                                                <span
                                                    class="inline-block bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                                                    {{ $child->name }}
                                                </span>
                                            @endforeach
                                            @if ($category->children->count() > 3)
                                                <span
                                                    class="inline-block bg-cyan-100 text-cyan-600 px-2 py-1 rounded-full text-xs">
                                                    +{{ $category->children->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Button -->
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="inline-flex items-center justify-center w-full bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                    <span>Browse Products</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mb-6">
                        <i data-lucide="package-x" class="w-24 h-24 text-gray-300 mx-auto"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Categories Available</h3>
                    <p class="text-gray-500 mb-8">Categories will appear here once they are added by the administrator.</p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-lg font-semibold">
                        <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                        Return to Home
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Quick Stats Section -->
    @if ($categories->count() > 0)
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="bg-cyan-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="package" class="w-8 h-8 text-cyan-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $categories->count() }}</h3>
                        <p class="text-gray-600">Main Categories</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="grid-3x3" class="w-8 h-8 text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">
                            {{ $categories->sum(function ($cat) {return $cat->children->count();}) }}</h3>
                        <p class="text-gray-600">Subcategories</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="shopping-bag" class="w-8 h-8 text-purple-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $categories->sum('products_count') }}</h3>
                        <p class="text-gray-600">Total Products</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
