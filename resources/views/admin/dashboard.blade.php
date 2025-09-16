 @extends('layouts.admin')

 @section('title', 'Admin Dashboard')
 @section('header', 'Dashboard')

 @section('content')
     <!-- Statistics Cards -->
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
         <!-- Total Products -->
         <div class="bg-white rounded-lg shadow p-6">
             <div class="flex items-center">
                 <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                     </svg>
                 </div>
                 <div class="ml-4">
                     <h3 class="text-lg font-semibold text-gray-900">{{ $stats['total_products'] }}</h3>
                     <p class="text-sm text-gray-600">Total Products</p>
                 </div>
             </div>
         </div>

         <!-- Active Products -->
         <div class="bg-white rounded-lg shadow p-6">
             <div class="flex items-center">
                 <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                     </svg>
                 </div>
                 <div class="ml-4">
                     <h3 class="text-lg font-semibold text-gray-900">{{ $stats['active_products'] }}</h3>
                     <p class="text-sm text-gray-600">Active Products</p>
                 </div>
             </div>
         </div>

         <!-- Low Stock -->
         <div class="bg-white rounded-lg shadow p-6">
             <div class="flex items-center">
                 <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z">
                         </path>
                     </svg>
                 </div>
                 <div class="ml-4">
                     <h3 class="text-lg font-semibold text-gray-900">{{ $stats['low_stock_products'] }}</h3>
                     <p class="text-sm text-gray-600">Low Stock Items</p>
                 </div>
             </div>
         </div>

         <!-- Out of Stock -->
         <div class="bg-white rounded-lg shadow p-6">
             <div class="flex items-center">
                 <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                         </path>
                     </svg>
                 </div>
                 <div class="ml-4">
                     <h3 class="text-lg font-semibold text-gray-900">{{ $stats['out_of_stock_products'] }}</h3>
                     <p class="text-sm text-gray-600">Out of Stock</p>
                 </div>
             </div>
         </div>
     </div>

     <!-- Secondary Stats -->
     <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
         <div class="bg-white rounded-lg shadow p-4 text-center">
             <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</h4>
             <p class="text-sm text-gray-600">Categories</p>
         </div>
         <div class="bg-white rounded-lg shadow p-4 text-center">
             <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_suppliers'] }}</h4>
             <p class="text-sm text-gray-600">Suppliers</p>
         </div>
         <div class="bg-white rounded-lg shadow p-4 text-center">
             <h4 class="text-2xl font-bold text-gray-900">{{ $stats['prescription_products'] }}</h4>
             <p class="text-sm text-gray-600">Prescription</p>
         </div>
         <div class="bg-white rounded-lg shadow p-4 text-center">
             <h4 class="text-2xl font-bold text-gray-900">{{ $stats['otc_products'] }}</h4>
             <p class="text-sm text-gray-600">OTC Products</p>
         </div>
         <div class="bg-white rounded-lg shadow p-4 text-center">
             <h4 class="text-2xl font-bold text-red-600">{{ $stats['products_expiring_soon'] }}</h4>
             <p class="text-sm text-gray-600">Expiring Soon</p>
         </div>
         <div class="bg-white rounded-lg shadow p-4 text-center">
             <h4 class="text-2xl font-bold text-red-800">{{ $stats['expired_products'] }}</h4>
             <p class="text-sm text-gray-600">Expired</p>
         </div>
     </div>

     <!-- Main Content Grid -->
     <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
         <!-- Recent Products -->
         <div class="bg-white rounded-lg shadow">
             <div class="px-6 py-4 border-b border-gray-200">
                 <h3 class="text-lg font-medium text-gray-900">Recent Products</h3>
             </div>
             <div class="p-6">
                 @if ($recent_products->count() > 0)
                     <div class="space-y-4">
                         @foreach ($recent_products as $product)
                             <div class="flex items-center justify-between">
                                 <div class="flex items-center space-x-3">
                                     @if ($product->images && count($product->images) > 0)
                                         <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}"
                                             class="w-8 h-8 rounded object-cover">
                                     @else
                                         <div class="w-8 h-8 rounded bg-gray-200"></div>
                                     @endif
                                     <div>
                                         <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                         <p class="text-xs text-gray-500">{{ $product->category->name ?? 'No Category' }}
                                         </p>
                                     </div>
                                 </div>
                                 <div class="text-right">
                                     <p class="text-sm font-medium text-gray-900">
                                         ₹{{ number_format($product->unit_price, 2) }}</p>
                                     <p class="text-xs text-gray-500">Stock: {{ $product->stock_quantity }}</p>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                     <div class="mt-4">
                         <a href="{{ route('admin.products.index') }}"
                             class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                             View all products →
                         </a>
                     </div>
                 @else
                     <p class="text-gray-500 text-center py-4">No products found</p>
                 @endif
             </div>
         </div>

         <!-- Low Stock Alerts -->
         <div class="bg-white rounded-lg shadow">
             <div class="px-6 py-4 border-b border-gray-200">
                 <h3 class="text-lg font-medium text-gray-900">Low Stock Alerts</h3>
             </div>
             <div class="p-6">
                 @if ($low_stock_products->count() > 0)
                     <div class="space-y-4">
                         @foreach ($low_stock_products as $product)
                             <div class="flex items-center justify-between">
                                 <div>
                                     <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                     <p class="text-xs text-gray-500">{{ $product->category->name ?? 'No Category' }}</p>
                                 </div>
                                 <div class="text-right">
                                     <span
                                         class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                         {{ $product->stock_quantity }} left
                                     </span>
                                     <p class="text-xs text-gray-500 mt-1">Min: {{ $product->minimum_stock }}</p>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                     <div class="mt-4">
                         <a href="{{ route('admin.products.index', ['stock_status' => 'low_stock']) }}"
                             class="text-red-600 hover:text-red-800 text-sm font-medium">
                             View all low stock items →
                         </a>
                     </div>
                 @else
                     <p class="text-gray-500 text-center py-4">No low stock items</p>
                 @endif
             </div>
         </div>
     </div>

     <!-- Products Expiring Soon -->
     @if ($expiring_products->count() > 0)
         <div class="mt-8 bg-white rounded-lg shadow">
             <div class="px-6 py-4 border-b border-gray-200">
                 <h3 class="text-lg font-medium text-gray-900">Products Expiring Soon</h3>
             </div>
             <div class="p-6">
                 <div class="overflow-x-auto">
                     <table class="min-w-full divide-y divide-gray-200">
                         <thead class="bg-gray-50">
                             <tr>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                     Product</th>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                     Category</th>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                     Stock</th>
                                 <th
                                     class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                     Expiry Date</th>
                             </tr>
                         </thead>
                         <tbody class="bg-white divide-y divide-gray-200">
                             @foreach ($expiring_products as $product)
                                 <tr>
                                     <td class="px-6 py-4 whitespace-nowrap">
                                         <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                         <div class="text-sm text-gray-500">{{ $product->sku }}</div>
                                     </td>
                                     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                         {{ $product->category->name ?? '-' }}
                                     </td>
                                     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                         {{ $product->stock_quantity }}
                                     </td>
                                     <td class="px-6 py-4 whitespace-nowrap">
                                         <span
                                             class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                             {{ $product->expiry_date ? $product->expiry_date->format('M d, Y') : 'No expiry' }}
                                         </span>
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
