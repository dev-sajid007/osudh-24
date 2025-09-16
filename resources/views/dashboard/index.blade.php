@extends('layouts.dashboard')

@section('title', 'Dashboard - CRM')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-gray-900">Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}!</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- User Role Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Your Role(s):</strong>
                    @if (Auth::user()->roles->count() > 0)
                        {{ Auth::user()->roles->pluck('display_name')->implode(', ') }}
                    @else
                        No roles assigned
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ is_numeric($stats['total_users']) ? number_format($stats['total_users']) : $stats['total_users'] }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Users</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ is_numeric($stats['active_users']) ? number_format($stats['active_users']) : $stats['active_users'] }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Users Today -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">New Today</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ is_numeric($stats['new_users_today']) ? number_format($stats['new_users_today']) : $stats['new_users_today'] }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Users This Week -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-calendar-week text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">New This Week</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ is_numeric($stats['new_users_this_week']) ? number_format($stats['new_users_this_week']) : $stats['new_users_this_week'] }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- User Registration Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">User Registrations (Last 7 Days)</h3>
                @if (Auth::user()->hasRole(['admin', 'manager']))
                    <div class="mt-5">
                        <canvas id="userChart" width="400" height="200"></canvas>
                    </div>
                @else
                    <div class="mt-5 text-center py-8">
                        <i class="fas fa-lock text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-500">Access restricted. Contact administrator for permissions.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Users</h3>
                @if (Auth::user()->hasRole(['admin', 'manager']))
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @forelse($recent_users as $user)
                                <li>
                                    <div class="relative pb-8">
                                        @if (!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span
                                                    class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-user text-white text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                                        registered
                                                    </p>
                                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time
                                                        datetime="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center py-4 text-gray-500">
                                    No users registered yet
                                </li>
                            @endforelse
                        </ul>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-lock text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-500">Access restricted. Contact administrator for permissions.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-user-plus mr-2"></i>
                    Add New User
                </button>

                <button
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-handshake mr-2"></i>
                    Create Lead
                </button>

                <button
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-chart-bar mr-2"></i>
                    View Reports
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart data from Laravel
            const chartData = @json($chart_data);

            // Setup chart
            const ctx = document.getElementById('userChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.map(item => item.date),
                    datasets: [{
                        label: 'New Users',
                        data: chartData.map(item => item.users),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
