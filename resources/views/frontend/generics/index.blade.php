@extends('layouts.frontend.app')

@section('title', 'Generics')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Active Ingredients (Generics)</h1>
            <p class="text-cyan-100 mt-2">Browse medicines by their active ingredients</p>
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
                    <li class="text-gray-700 font-medium">Generics</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Generics Grid -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            @if ($generics->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($generics as $generic)
                        <a href="{{ route('generics.show', $generic->slug) }}"
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6">
                                <!-- Generic Icon/Header -->
                                <div class="flex items-center justify-center w-12 h-12 bg-cyan-100 rounded-full mb-4">
                                    <i data-lucide="beaker" class="w-6 h-6 text-cyan-600"></i>
                                </div>

                                <!-- Generic Name -->
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                    {{ $generic->name }}
                                </h3>

                                <!-- Description -->
                                @if ($generic->description)
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                        {{ $generic->description }}
                                    </p>
                                @endif

                                <!-- Product Count -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <span class="text-sm text-gray-500">
                                        <i data-lucide="box" class="w-4 h-4 inline mr-1"></i>
                                        {{ $generic->products_count }} {{ $generic->products_count == 1 ? 'product' : 'products' }}
                                    </span>
                                    <span class="text-cyan-600 font-semibold">
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $generics->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i data-lucide="package" class="w-16 h-16 mx-auto"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No Generics Found</h3>
                    <p class="text-gray-500 mb-6">We're working on adding more active ingredients for you!</p>
                    <a href="{{ route('home') }}" class="inline-block bg-cyan-600 text-white px-6 py-2 rounded-lg hover:bg-cyan-700 transition-colors">
                        Back to Home
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
