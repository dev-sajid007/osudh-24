@extends('layouts.admin')

@section('title', 'Product Details')
@section('header', 'Product Details')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.products.edit', $product) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    @if ($product->image_urls && count($product->image_urls) > 0)
                        <div class="space-y-4">
                            <!-- Main Image -->
                            <div class="relative">
                                <img src="{{ $product->image_urls[0]['large'] }}" alt="{{ $product->name }}"
                                    class="w-full h-80 object-cover rounded-lg shadow-lg">
                                @if ($product->has_cloudinary_images)
                                    <div
                                        class="absolute top-4 right-4 bg-green-500 text-white text-sm px-3 py-2 rounded-full flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Cloudinary</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Thumbnail Gallery -->
                            @if (count($product->image_urls) > 1)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach (array_slice($product->image_urls, 1, 4) as $imageUrls)
                                        <div class="relative group cursor-pointer">
                                            <img src="{{ $imageUrls['medium'] }}" alt="{{ $product->name }}"
                                                class="w-full h-20 object-cover rounded border-2 border-gray-200 hover:border-blue-500 transition-colors"
                                                onclick="changeMainImage('{{ $imageUrls['large'] }}')">
                                            @if ($product->has_cloudinary_images)
                                                <div
                                                    class="absolute top-1 right-1 w-3 h-3 bg-green-400 rounded-full border border-white">
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Image Size Options (if Cloudinary) -->
                            @if ($product->has_cloudinary_images)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <h5 class="text-sm font-medium text-green-800 mb-2">Available Sizes</h5>
                                    <div class="flex flex-wrap gap-2">
                                        <button onclick="changeMainImage('{{ $product->image_urls[0]['thumbnail'] }}')"
                                            class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-800 rounded">
                                            Thumbnail
                                        </button>
                                        <button onclick="changeMainImage('{{ $product->image_urls[0]['medium'] }}')"
                                            class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-800 rounded">
                                            Medium
                                        </button>
                                        <button onclick="changeMainImage('{{ $product->image_urls[0]['large'] }}')"
                                            class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-800 rounded">
                                            Large
                                        </button>
                                        <button onclick="changeMainImage('{{ $product->image_urls[0]['original'] }}')"
                                            class="px-2 py-1 text-xs bg-green-100 hover:bg-green-200 text-green-800 rounded">
                                            Original
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-80 bg-gray-200 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="mt-2 block text-sm text-gray-500">No Images Available</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">SKU</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->sku }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Brand</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->brand ?: '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Generic Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->generic_name ?: '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Form</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($product->form ?: '-') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dosage</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->dosage ?: '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Strength</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->strength ?: '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Package Size</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->package_size ?: '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Barcode</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->barcode ?: '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Category & Supplier -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Category & Supplier</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->category->name ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Supplier</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->supplier->name ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Pricing -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Unit Price</dt>
                                <dd class="mt-1 text-lg font-semibold text-green-600">
                                    ₹{{ number_format($product->unit_price, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">MRP</dt>
                                <dd class="mt-1 text-sm text-gray-900">₹{{ number_format($product->mrp, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Discount</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->discount }}%</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tax Rate</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->tax_rate }}%</dd>
                            </div>
                            @if ($product->discount > 0)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Final Price</dt>
                                    <dd class="mt-1 text-lg font-semibold text-blue-600">
                                        ₹{{ number_format($product->final_price, 2) }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Stock Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Stock Information</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Current Stock</dt>
                                <dd class="mt-1">
                                    <span
                                        class="text-lg font-semibold {{ $product->is_low_stock ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    @if ($product->is_low_stock)
                                        <span
                                            class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            Low Stock
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Minimum Stock</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->minimum_stock }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Maximum Stock</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->maximum_stock }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Availability</dt>
                                <dd class="mt-1">
                                    @switch($product->availability_status)
                                        @case('in_stock')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                In Stock
                                            </span>
                                        @break

                                        @case('low_stock')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Low Stock
                                            </span>
                                        @break

                                        @case('out_of_stock')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Out of Stock
                                            </span>
                                        @break
                                    @endswitch
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Status & Requirements -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Status & Requirements</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
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
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Prescription Required</dt>
                                <dd class="mt-1">
                                    @if ($product->prescription_required)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            Yes
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            No (OTC)
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Expiry Date</dt>
                                <dd class="mt-1">
                                    @if ($product->expiry_date)
                                        <span
                                            class="{{ $product->is_expiring_soon ? 'text-yellow-600' : ($product->is_expired ? 'text-red-600' : 'text-gray-900') }}">
                                            {{ $product->expiry_date->format('M d, Y') }}
                                        </span>
                                        @if ($product->is_expired)
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Expired
                                            </span>
                                        @elseif($product->is_expiring_soon)
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Expiring Soon
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-500">Not specified</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mt-8 space-y-6">
                @if ($product->description)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Description</h4>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                @endif

                @if ($product->usage_instructions)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Usage Instructions</h4>
                        <p class="text-gray-700">{{ $product->usage_instructions }}</p>
                    </div>
                @endif

                @if ($product->side_effects)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Side Effects</h4>
                        <p class="text-gray-700">{{ $product->side_effects }}</p>
                    </div>
                @endif

                @if ($product->storage_instructions)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Storage Instructions</h4>
                        <p class="text-gray-700">{{ $product->storage_instructions }}</p>
                    </div>
                @endif

                @if ($product->tags && count($product->tags) > 0)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Tags</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->tags as $tag)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Function to change main image
            function changeMainImage(newSrc) {
                const mainImage = document.querySelector(
                    'img[src*="large"], img[src*="medium"], img[src*="original"], img[src*="thumbnail"]');
                if (mainImage) {
                    mainImage.src = newSrc;
                }
            }

            // Make function global
            window.changeMainImage = changeMainImage;
        </script>
    @endpush
@endsection
