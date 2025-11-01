<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | {{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Admin CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.35rem;
            margin-bottom: 0.25rem;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .main-content {
            min-height: 100vh;
            background-color: #f8f9fc;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .badge-primary { background-color: #4e73df; }
        .badge-success { background-color: #1cc88a; }
        .badge-warning { background-color: #f6c23e; }
        .badge-danger { background-color: #e74a3b; }
        .badge-info { background-color: #36b9cc; }
        .badge-secondary { background-color: #858796; }
        
        .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
        .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
        .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
        .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
        
        .text-primary { color: #4e73df !important; }
        .text-success { color: #1cc88a !important; }
        .text-warning { color: #f6c23e !important; }
        .text-danger { color: #e74a3b !important; }
        .text-info { color: #36b9cc !important; }
        
        .bg-primary { background-color: #4e73df !important; }
        .bg-success { background-color: #1cc88a !important; }
        .bg-warning { background-color: #f6c23e !important; }
        .bg-danger { background-color: #e74a3b !important; }
        .bg-info { background-color: #36b9cc !important; }
        
        .text-gray-800 { color: #5a5c69 !important; }
        .text-gray-900 { color: #3a3b45 !important; }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: #858796;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #858796;
        }
        
        @stack('styles')
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="px-3 pb-3">
                        <h4 class="text-white mb-0">
                            <i class="fas fa-capsules me-2"></i>
                            Pharmacy Admin
                        </h4>
                    </div>
                    
                    <ul class="nav flex-column px-3">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <!-- Divider -->
                        <hr class="sidebar-divider my-3" style="border-color: rgba(255, 255, 255, 0.2);">
                        
                        <!-- Catalog Management -->
                        <li class="nav-item">
                            <small class="text-white-50 text-uppercase mb-2 d-block">Catalog</small>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                               href="{{ route('admin.products.index') }}">
                                <i class="fas fa-pills me-2"></i>
                                Products
                                @php
                                    $lowStockCount = \App\Models\Product::whereRaw('stock_quantity <= minimum_stock')->count();
                                @endphp
                                @if ($lowStockCount > 0)
                                    <span class="badge bg-danger rounded-pill ms-auto">{{ $lowStockCount }}</span>
                                @endif
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                               href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-tags me-2"></i>
                                Categories
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.generics.*') ? 'active' : '' }}" 
                               href="{{ route('admin.generics.index') }}">
                                <i class="fas fa-flask me-2"></i>
                                Generics
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}" 
                               href="{{ route('admin.suppliers.index') }}">
                                <i class="fas fa-truck me-2"></i>
                                Suppliers
                            </a>
                        </li>
                        
                        <!-- Divider -->
                        <hr class="sidebar-divider my-3" style="border-color: rgba(255, 255, 255, 0.2);">
                        
                        <!-- Orders -->
                        <li class="nav-item">
                            <small class="text-white-50 text-uppercase mb-2 d-block">Orders</small>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                               href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-cart me-2"></i>
                                All Orders
                                @php
                                    $pendingOrdersCount = \App\Models\Order::where('order_status', 'pending')->count();
                                @endphp
                                @if ($pendingOrdersCount > 0)
                                    <span class="badge bg-warning rounded-pill ms-auto">{{ $pendingOrdersCount }}</span>
                                @endif
                            </a>
                        </li>
                        
                        <!-- Divider -->
                        <hr class="sidebar-divider my-3" style="border-color: rgba(255, 255, 255, 0.2);">
                        
                        <!-- Users -->
                        <li class="nav-item">
                            <small class="text-white-50 text-uppercase mb-2 d-block">Users</small>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users me-2"></i>
                                Users
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" 
                               href="{{ route('admin.roles.index') }}">
                                <i class="fas fa-user-shield me-2"></i>
                                Roles
                            </a>
                        </li>
                        
                        <!-- Divider -->
                        <hr class="sidebar-divider my-3" style="border-color: rgba(255, 255, 255, 0.2);">
                        
                        <!-- Settings -->
                        <li class="nav-item">
                            <small class="text-white-50 text-uppercase mb-2 d-block">Settings</small>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.website-settings.*') ? 'active' : '' }}" 
                               href="{{ route('admin.website-settings.index') }}">
                                <i class="fas fa-cog me-2"></i>
                                Website Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navigation -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary d-md-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <span class="text-muted">Welcome back,</span>
                            <strong>{{ Auth::user()->name }}</strong>
                        </div>
                    </div>
                    
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                                View Site
                            </a>
                        </div>
                        
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">My Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-1"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
</body>

</html>