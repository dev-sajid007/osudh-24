@extends('layouts.frontend.app')

@section('title', 'Order Confirmation - ' . config('app.name'))

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <!-- Success Header -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Order Confirmed!</h1>
                <p class="mt-2 text-gray-600">Thank you for your order. We'll send you a confirmation email shortly.</p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-8">
                <nav aria-label="Progress">
                    <ol role="list" class="flex items-center justify-center">
                        <li class="relative pr-8 sm:pr-20">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-green-200"></div>
                            </div>
                            <div class="relative w-8 h-8 flex items-center justify-center bg-green-600 rounded-full">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Cart</span>
                            </div>
                            <span class="absolute -bottom-6 text-xs font-medium text-green-600">Cart</span>
                        </li>
                        <li class="relative pr-8 sm:pr-20">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full bg-green-200"></div>
                            </div>
                            <div class="relative w-8 h-8 flex items-center justify-center bg-green-600 rounded-full">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Checkout</span>
                            </div>
                            <span class="absolute -bottom-6 text-xs font-medium text-green-600">Checkout</span>
                        </li>
                        <li class="relative">
                            <div class="relative w-8 h-8 flex items-center justify-center bg-green-600 rounded-full">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Confirmation</span>
                            </div>
                            <span class="absolute -bottom-6 text-xs font-medium text-green-600">Confirmation</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Order Details -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <!-- Order Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Order #{{ $order->order_number }}</h2>
                            <p class="text-sm text-gray-500">
                                Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $order->statusBadgeColor }}-100 text-{{ $order->statusBadgeColor }}-800">
                                {{ ucfirst($order->order_status) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Customer Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->customer_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="text-sm font-medium text-gray-900">{{ $order->paymentMethodDisplay }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Shipping Address</h3>
                    <div class="text-sm text-gray-900">
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', ' . $order->shipping_postal_code : '' }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="px-6 py-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach ($order->orderItems as $item)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="h-16 w-16 rounded-md object-cover"
                                        src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder-product.png') }}"
                                        alt="{{ $item->product_name }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h4>
                                    @if ($item->product && $item->product->generic)
                                        <p class="text-sm text-gray-500">{{ $item->product->generic->name }}</p>
                                    @endif
                                    @if ($item->product && $item->product->prescription_required)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                            Prescription Required
                                        </span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">
                                    Qty: {{ $item->quantity }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    ৳{{ number_format($item->total_price, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <dl class="mt-6 space-y-3 border-t border-gray-200 pt-6">
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Subtotal</dt>
                            <dd class="font-medium text-gray-900">৳{{ number_format($order->subtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Shipping</dt>
                            <dd class="font-medium text-gray-900">৳{{ number_format($order->shipping_cost, 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600">Tax</dt>
                            <dd class="font-medium text-gray-900">৳{{ number_format($order->tax_amount, 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-base font-medium border-t border-gray-200 pt-3">
                            <dt class="text-gray-900">Total</dt>
                            <dd class="text-gray-900">৳{{ number_format($order->total_amount, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                @if ($order->prescription_path)
                    <!-- Prescription Information -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-blue-50">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-900">Prescription Uploaded</p>
                                <p class="text-xs text-blue-700">Our pharmacist will verify your prescription before processing the order.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($order->special_instructions)
                    <!-- Special Instructions -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-yellow-50">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-900">Special Instructions</p>
                                <p class="text-sm text-yellow-800">{{ $order->special_instructions }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Next Steps -->
            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What happens next?</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 text-indigo-600">
                                <span class="text-xs font-bold">1</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Order Confirmation</p>
                            <p class="text-sm text-gray-500">You'll receive an email confirmation with your order details.</p>
                        </div>
                    </div>
                    
                    @if ($order->requiresPrescription())
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 text-indigo-600">
                                    <span class="text-xs font-bold">2</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Prescription Verification</p>
                                <p class="text-sm text-gray-500">Our licensed pharmacist will verify your prescription.</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 text-indigo-600">
                                <span class="text-xs font-bold">{{ $order->requiresPrescription() ? '3' : '2' }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Processing & Packaging</p>
                            <p class="text-sm text-gray-500">We'll carefully prepare your order for delivery.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 text-indigo-600">
                                <span class="text-xs font-bold">{{ $order->requiresPrescription() ? '4' : '3' }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Delivery</p>
                            <p class="text-sm text-gray-500">Your order will be delivered to your specified address.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Continue Shopping
                </a>
                
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View Order History
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection