@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="mb-6">
        <div class="flex items-center">
            <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">User: {{ $user->name }}</h1>
                <p class="text-gray-600">View user details and permissions</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Information -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center mb-6">
                    <div class="h-16 w-16 flex-shrink-0">
                        <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                        <dd class="mt-1">
                            @if ($user->email_verified_at)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pending Verification
                                </span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->diffForHumans() }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Total Roles</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->roles->count() }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="{{ route('users.edit', $user) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mr-2">
                        <i class="fas fa-edit mr-1"></i>
                        Edit User
                    </a>
                    @if (
                        !$user->hasRole('admin') ||
                            App\Models\User::whereHas('roles', function ($q) {
                                $q->where('name', 'admin');
                            })->count() > 1)
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                <i class="fas fa-trash mr-1"></i>
                                Delete User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Roles -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Assigned Roles</h3>

                @if ($user->roles->count() > 0)
                    <div class="space-y-4">
                        @foreach ($user->roles as $role)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $role->display_name }}</h4>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $role->name === 'admin'
                                    ? 'bg-red-100 text-red-800'
                                    : ($role->name === 'manager'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-blue-100 text-blue-800') }}">
                                        {{ $role->name }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">{{ $role->description }}</p>

                                <!-- Role Permissions -->
                                <div>
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Permissions:</h5>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($role->permissions->take(5) as $permission)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $permission->display_name }}
                                            </span>
                                        @endforeach
                                        @if ($role->permissions->count() > 5)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-200 text-gray-600">
                                                +{{ $role->permissions->count() - 5 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <i class="fas fa-user-times text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-500">No roles assigned to this user.</p>
                        <a href="{{ route('users.edit', $user) }}"
                            class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Assign Roles
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- All Permissions Summary -->
    <div class="mt-6 bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">All User Permissions</h3>

            @php
                $allPermissions = collect();
                foreach ($user->roles as $role) {
                    $allPermissions = $allPermissions->merge($role->permissions);
                }
                $uniquePermissions = $allPermissions->unique('id');
                $permissionGroups = $uniquePermissions->groupBy(function ($permission) {
                    return explode('_', $permission->name)[1] ?? 'other';
                });
            @endphp

            @if ($uniquePermissions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($permissionGroups as $group => $permissions)
                        <div class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3 capitalize">{{ $group }} Permissions</h4>
                            <div class="space-y-2">
                                @foreach ($permissions as $permission)
                                    <div class="flex items-center">
                                        <i class="fas fa-check text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-700">{{ $permission->display_name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <i class="fas fa-ban text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-500">This user has no permissions.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
