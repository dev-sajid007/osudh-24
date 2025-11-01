@extends('layouts.admin')

@section('title', 'Categories')
@section('header', 'Categories')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Product Categories</h3>
                <a href="{{ route('admin.categories.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Add Category
                </a>
            </div>
        </div>

        <!-- Categories Tree -->
        <div class="p-6">
            @if ($categories->whereNull('parent_id')->count() > 0)
                <div class="space-y-4">
                    @foreach ($categories->whereNull('parent_id') as $category)
                        <div class="border border-gray-200 rounded-lg">
                            <!-- Parent Category -->
                            <div
                                class="flex items-center justify-between p-4 {{ $category->is_active ? 'bg-white' : 'bg-gray-50' }}">
                                <div class="flex items-center space-x-4">
                                    @if ($category->image_url)
                                        <div class="relative">
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                                class="w-10 h-10 rounded-lg object-cover">
                                            @if ($category->cloudinary_public_id)
                                                <div
                                                    class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                                    <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif

                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900">{{ $category->name }}</h4>
                                        @if ($category->description)
                                            <p class="text-sm text-gray-500">{{ Str::limit($category->description, 100) }}
                                            </p>
                                        @endif
                                        <div class="flex items-center space-x-4 mt-1">
                                            <span class="text-xs text-gray-500">{{ $category->products_count ?? 0 }}
                                                products</span>
                                            <span class="text-xs text-gray-500">{{ $category->children->count() }}
                                                subcategories</span>
                                            @if (!$category->is_active)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.categories.show', $category) }}"
                                        class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    @if ($category->products()->count() == 0 && $category->children()->count() == 0)
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                            class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Child Categories -->
                            @if ($category->children->count() > 0)
                                <div class="border-t border-gray-200">
                                    @foreach ($category->children as $child)
                                        <div
                                            class="flex items-center justify-between p-4 pl-16 border-b border-gray-100 last:border-b-0 {{ $child->is_active ? 'bg-white' : 'bg-gray-50' }}">
                                            <div class="flex items-center space-x-4">
                                                @if ($child->image_url)
                                                    <div class="relative">
                                                        <img src="{{ $child->image_url }}" alt="{{ $child->name }}"
                                                            class="w-8 h-8 rounded object-cover">
                                                        @if ($child->cloudinary_public_id)
                                                            <div
                                                                class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border border-white">
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="w-8 h-8 rounded bg-gray-200"></div>
                                                @endif

                                                <div>
                                                    <h5 class="font-medium text-gray-900">{{ $child->name }}</h5>
                                                    @if ($child->description)
                                                        <p class="text-sm text-gray-500">
                                                            {{ Str::limit($child->description, 80) }}</p>
                                                    @endif
                                                    <div class="flex items-center space-x-4 mt-1">
                                                        <span
                                                            class="text-xs text-gray-500">{{ $child->products_count ?? 0 }}
                                                            products</span>
                                                        @if (!$child->is_active)
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                                Inactive
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.categories.show', $child) }}"
                                                    class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                                <a href="{{ route('admin.categories.edit', $child) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                                @if ($child->products()->count() == 0)
                                                    <form method="POST"
                                                        action="{{ route('admin.categories.destroy', $child) }}"
                                                        class="inline" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-lg mb-4">No categories found</div>
                    <a href="{{ route('admin.categories.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Create First Category
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
