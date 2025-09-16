@extends('layouts.admin')

@section('title', 'Role Details')

@section('content')
    <div class="mb-6">
        <div class="flex items-center">
            <a href="{{ route('roles.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Role: {{ $role->display_name }}</h1>
                <p class="text-gray-600">View role details and permissions</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Role Information -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Role Information</h3>

                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">System Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $role->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Display Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $role->display_name }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $role->description ?? 'No description provided' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Users</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $role->users->count() }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Permissions</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $role->permissions->count() }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="{{ route('roles.edit', $role) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mr-2">
                        <i class="fas fa-edit mr-1"></i>
                        Edit Role
                    </a>
                    @if ($role->name !== 'admin')
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this role?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                <i class="fas fa-trash mr-1"></i>
                                Delete Role
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Permissions</h3>

                @if ($role->permissions->count() > 0)
                    @php
                        $permissionGroups = $role->permissions->groupBy(function ($permission) {
                            return explode('_', $permission->name)[1] ?? 'other';
                        });
                    @endphp

                    <div class="space-y-4">
                        @foreach ($permissionGroups as $group => $permissions)
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2 capitalize">{{ $group }} Permissions</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($permissions as $permission)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            {{ $permission->display_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No permissions assigned to this role.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Users with this role -->
    @if ($role->users->count() > 0)
        <div class="mt-6 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Users with this Role</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($role->users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 flex-shrink-0">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-gray-700">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->email_verified_at)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('users.show', $user) }}"
                                            class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
