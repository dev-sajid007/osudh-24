@extends('layouts.frontend.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}"
                        class="flex items-center text-indigo-600 hover:text-indigo-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Cart
                    </a>
                    <div class="border-l border-gray-300 h-6"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
                </div>
                
                <!-- Progress Steps -->
                <div class="mt-6">
                    <nav aria-label="Progress">
                        <ol role="list" class="flex items-center">
                            <li class="relative pr-8 sm:pr-20">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="h-0.5 w-full bg-gray-200"></div>
                                </div>
                                <a href="{{ route('cart.index') }}"
                                    class="relative w-8 h-8 flex items-center justify-center bg-indigo-600 rounded-full hover:bg-indigo-900">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">Cart</span>
                                </a>
                                <span class="absolute -bottom-6 text-xs font-medium text-gray-500">Cart</span>
                            </li>
                            <li class="relative pr-8 sm:pr-20">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="h-0.5 w-full bg-gray-200"></div>
                                </div>
                                <div class="relative w-8 h-8 flex items-center justify-center bg-indigo-600 rounded-full"
                                    aria-current="step">
                                    <span class="h-2.5 w-2.5 bg-white rounded-full" aria-hidden="true"></span>
                                    <span class="sr-only">Checkout</span>
                                </div>
                                <span class="absolute -bottom-6 text-xs font-medium text-indigo-600">Checkout</span>
                            </li>
                            <li class="relative">
                                <div class="relative w-8 h-8 flex items-center justify-center bg-gray-300 rounded-full">
                                    <span class="h-2.5 w-2.5 bg-white rounded-full" aria-hidden="true"></span>
                                    <span class="sr-only">Confirmation</span>
                                </div>
                                <span class="absolute -bottom-6 text-xs font-medium text-gray-500">Confirmation</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
                @csrf
                
                <!-- Display general errors -->
                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
                    <!-- Customer Information Form -->
                    <div class="lg:col-span-7">
                        <div class="bg-white shadow rounded-lg">
                            <!-- Contact Information -->
                            <div class="px-4 py-6 sm:px-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-6">Contact Information</h2>
                                
                                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                                            First name *
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" id="first_name" name="first_name"
                                                value="{{ old('first_name', $user ? explode(' ', $user->name)[0] : '') }}"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                required>
                                        </div>
                                        @error('first_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                                            Last name *
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" id="last_name" name="last_name"
                                                value="{{ old('last_name', $user && str_word_count($user->name) > 1 ? substr($user->name, strpos($user->name, ' ') + 1) : '') }}"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                required>
                                        </div>
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700">
                                            Email address *
                                        </label>
                                        <div class="mt-1">
                                            <input type="email" id="email" name="email"
                                                value="{{ old('email', $user->email ?? '') }}"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                required>
                                        </div>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">
                                            Phone number *
                                        </label>
                                        <div class="mt-1">
                                            <input type="tel" id="phone" name="phone"
                                                value="{{ old('phone') }}"
                                                placeholder="+880 1XXX XXXXXX"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                required>
                                        </div>
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-6">Shipping Information</h2>
                                
                                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div class="sm:col-span-2">
                                        <label for="address" class="block text-sm font-medium text-gray-700">
                                            Address *
                                        </label>
                                        <div class="mt-1">
                                            <textarea id="address" name="address" rows="3"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="Street address, apartment, suite, etc."
                                                required>{{ old('address') }}</textarea>
                                        </div>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">
                                            City *
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" id="city" name="city"
                                                value="{{ old('city') }}"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                required>
                                        </div>
                                        @error('city')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700">
                                            Postal code
                                        </label>
                                        <div class="mt-1">
                                            <input type="text" id="postal_code" name="postal_code"
                                                value="{{ old('postal_code') }}"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        @error('postal_code')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-6">Payment Method</h2>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="cash_on_delivery" name="payment_method" type="radio" value="cash_on_delivery"
                                            {{ old('payment_method', 'cash_on_delivery') == 'cash_on_delivery' ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="cash_on_delivery" class="ml-3 block text-sm font-medium text-gray-700">
                                            Cash on Delivery
                                            <span class="text-gray-500 text-xs block">Pay when you receive your order</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="bkash" name="payment_method" type="radio" value="bkash"
                                            {{ old('payment_method') == 'bkash' ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="bkash" class="ml-3 block text-sm font-medium text-gray-700">
                                            bKash
                                            <span class="text-gray-500 text-xs block">Mobile payment with bKash</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="nagad" name="payment_method" type="radio" value="nagad"
                                            {{ old('payment_method') == 'nagad' ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="nagad" class="ml-3 block text-sm font-medium text-gray-700">
                                            Nagad
                                            <span class="text-gray-500 text-xs block">Mobile payment with Nagad</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="rocket" name="payment_method" type="radio" value="rocket"
                                            {{ old('payment_method') == 'rocket' ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="rocket" class="ml-3 block text-sm font-medium text-gray-700">
                                            Rocket
                                            <span class="text-gray-500 text-xs block">Mobile payment with Rocket</span>
                                        </label>
                                    </div>
                                </div>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prescription Upload -->
                            @php
                                $requiresPrescription = false;
                                foreach ($cartItems as $item) {
                                    if ($item->prescription_required) {
                                        $requiresPrescription = true;
                                        break;
                                    }
                                }
                            @endphp

                            @if ($requiresPrescription)
                                <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-2">Prescription Upload</h2>
                                    <p class="text-sm text-red-600 mb-4">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Prescription required for items in your cart
                                    </p>
                                    
                                    <div class="mt-1">
                                        <label for="prescription" class="block text-sm font-medium text-gray-700">
                                            Upload prescription *
                                        </label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                                    viewBox="0 0 48 48">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="prescription"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="prescription" name="prescription" type="file"
                                                            accept=".jpg,.jpeg,.png,.pdf" class="sr-only"
                                                            {{ $requiresPrescription ? 'required' : '' }}>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, PDF up to 5MB</p>
                                            </div>
                                        </div>
                                    </div>
                                    @error('prescription')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <!-- Special Instructions -->
                            <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                <label for="special_instructions" class="block text-sm font-medium text-gray-700">
                                    Special Instructions
                                </label>
                                <div class="mt-1">
                                    <textarea id="special_instructions" name="special_instructions" rows="3"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Any special delivery instructions or notes...">{{ old('special_instructions') }}</textarea>
                                </div>
                                @error('special_instructions')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-10 lg:mt-0 lg:col-span-5">
                        <div class="bg-white shadow rounded-lg sticky top-6">
                            <div class="px-4 py-6 sm:px-6">
                                <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>

                                <div class="mt-6 space-y-4">
                                    @foreach ($cartItems as $item)
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="h-16 w-16 rounded-md object-cover"
                                                    src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholder-product.png') }}"
                                                    alt="{{ $item->name }}">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $item->name }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $item->generic->name ?? 'N/A' }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    Qty: {{ $item->cart_quantity }} × ৳{{ number_format($item->cart_price, 2) }}
                                                </p>
                                                @if ($item->prescription_required)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Prescription Required
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">
                                                ৳{{ number_format($item->cart_price * $item->cart_quantity, 2) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <dl class="mt-6 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-sm text-gray-600">Subtotal</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            ৳{{ number_format($summary['subtotal'], 2) }}
                                        </dd>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <dt class="text-sm text-gray-600">Shipping</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            ৳{{ number_format($summary['shipping'], 2) }}
                                        </dd>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <dt class="text-sm text-gray-600">Tax</dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            ৳{{ number_format($summary['tax'], 2) }}
                                        </dd>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                                        <dt class="text-base font-medium text-gray-900">Total</dt>
                                        <dd class="text-base font-medium text-gray-900">
                                            ৳{{ number_format($summary['total'], 2) }}
                                        </dd>
                                    </div>
                                </dl>

                                <div class="mt-6">
                                    <button type="submit" id="place-order-btn"
                                        class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span id="place-order-text">Place Order</span>
                                        <svg id="place-order-spinner" class="hidden animate-spin ml-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <p class="mt-4 text-center text-sm text-gray-500">
                                    By placing your order, you agree to our
                                    <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a>
                                    and
                                    <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkout-form');
            const submitBtn = document.getElementById('place-order-btn');
            const submitText = document.getElementById('place-order-text');
            const submitSpinner = document.getElementById('place-order-spinner');

            form.addEventListener('submit', function(e) {
                // Disable submit button and show loading state
                submitBtn.disabled = true;
                submitText.textContent = 'Processing...';
                submitSpinner.classList.remove('hidden');
            });

            // File upload preview
            const fileInput = document.getElementById('prescription');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileName = file.name;
                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        
                        // Create preview element
                        const preview = document.createElement('div');
                        preview.className = 'mt-2 p-2 bg-gray-50 border border-gray-200 rounded-md';
                        preview.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-900">${fileName}</span>
                                    <span class="text-xs text-gray-500 ml-2">(${fileSize} MB)</span>
                                </div>
                                <button type="button" onclick="this.parentElement.parentElement.remove(); document.getElementById('prescription').value = '';" class="text-red-600 hover:text-red-900">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        `;
                        
                        // Remove existing preview
                        const existingPreview = fileInput.parentElement.parentElement.querySelector('.mt-2');
                        if (existingPreview) {
                            existingPreview.remove();
                        }
                        
                        fileInput.parentElement.parentElement.appendChild(preview);
                    }
                });
            }
        });
    </script>
@endpush