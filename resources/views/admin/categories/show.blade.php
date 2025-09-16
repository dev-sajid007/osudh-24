@extends('layouts.admin')

@section('title', 'Category Details')
@section('header', 'Category Details')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Edit Category
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Category Image -->
                <div>
                    @if ($category->image_url)
                        <div class="relative">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                class="w-full h-64 object-cover rounded-lg shadow-lg">
                            @if ($category->cloudinary_public_id)
                                <div
                                    class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Cloudinary</span>
                                </div>
                            @endif
                        </div>

                        @if ($category->cloudinary_public_id && $category->image_urls)
                            <!-- Multiple size previews for Cloudinary images -->
                            <div class="mt-4">
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Available Sizes</h5>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="text-center">
                                        <img src="{{ $category->image_urls['thumbnail'] }}" alt="Thumbnail"
                                            class="w-full h-16 object-cover rounded border">
                                        <p class="text-xs text-gray-500 mt-1">Thumbnail</p>
                                    </div>
                                    <div class="text-center">
                                        <img src="{{ $category->image_urls['medium'] }}" alt="Medium"
                                            class="w-full h-16 object-cover rounded border">
                                        <p class="text-xs text-gray-500 mt-1">Medium</p>
                                    </div>
                                    <div class="text-center">
                                        <img src="{{ $category->image_urls['large'] }}" alt="Large"
                                            class="w-full h-16 object-cover rounded border">
                                        <p class="text-xs text-gray-500 mt-1">Large</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="mt-2 block text-sm text-gray-500">No Image Available</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Category Details -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $category->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">
                                    {{ $category->slug }}</dd>
                            </div>
                            @if ($category->parent)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Parent Category</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('admin.categories.show', $category->parent) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            {{ $category->parent->name }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Sort Order</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $category->sort_order }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if ($category->is_active)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Full Path</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $category->full_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Depth Level</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $category->getDepthLevel() }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Statistics -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $category->products->count() }}</div>
                                <div class="text-sm text-blue-600">Products</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">{{ $category->children->count() }}</div>
                                <div class="text-sm text-green-600">Subcategories</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if ($category->description)
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Description</h4>
                    <p class="text-gray-700 leading-relaxed">{{ $category->description }}</p>
                </div>
            @endif

            <!-- Subcategories -->
            @if ($category->children->count() > 0)
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Subcategories ({{ $category->children->count() }})
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($category->children as $child)
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-3">
                                    @if ($child->image)
                                        <img src="{{ Storage::url($child->image) }}" alt="{{ $child->name }}"
                                            class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-900">
                                            <a href="{{ route('admin.categories.show', $child) }}"
                                                class="hover:text-blue-600">
                                                {{ $child->name }}
                                            </a>
                                        </h5>
                                        <p class="text-sm text-gray-500">{{ $child->products->count() }} products</p>
                                        @if (!$child->is_active)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Products in this category -->
            @if ($category->products->count() > 0)
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Products ({{ $category->products->count() }})</h4>
                        <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View all products →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stock</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($category->products->take(10) as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($product->images && count($product->images) > 0)
                                                    <img class="h-8 w-8 rounded object-cover"
                                                        src="{{ Storage::url($product->images[0]) }}"
                                                        alt="{{ $product->name }}">
                                                @else
                                                    <div class="h-8 w-8 rounded bg-gray-200"></div>
                                                @endif
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $product->sku }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ₹{{ number_format($product->unit_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="text-sm {{ $product->is_low_stock ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                            @if ($product->is_low_stock)
                                                <span
                                                    class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Low
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($product->status)
                                                @case('active')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @break

                                                @case('draft')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                        Draft
                                                    </span>
                                                @break

                                                @case('discontinued')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                        Discontinued
                                                    </span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.products.show', $product) }}"
                                                class="text-blue-600 hover:text-blue-900">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($category->products->count() > 10)
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View all {{ $category->products->count() }} products →
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Metadata -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Metadata</h4>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('M d, Y \a\t g:i A') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('M d, Y \a\t g:i A') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection
