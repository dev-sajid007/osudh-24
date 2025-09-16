@extends('layouts.admin')

@section('title', 'Create Role')

@section('content')
    <div class="mb-6">
        <div class="flex items-center">
            <a href="{{ route('roles.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Create Role</h1>
                <p class="text-gray-600">Create a new role with specific permissions</p>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Role Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Role Name (System)</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Use lowercase letters and underscores only (e.g.,
                            content_manager)</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700">Display Name</label>
                        <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('display_name') border-red-300 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Human-readable name for the role (e.g., Content Manager)</p>
                        @error('display_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Permissions -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Permissions</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $permissionGroups = $permissions->groupBy(function ($permission) {
                                    return explode('_', $permission->name)[1] ?? 'other';
                                });
                            @endphp

                            @foreach ($permissionGroups as $group => $groupPermissions)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-3 capitalize">{{ $group }} Permissions
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach ($groupPermissions as $permission)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <span
                                                    class="ml-2 text-sm text-gray-700">{{ $permission->display_name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('roles.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
