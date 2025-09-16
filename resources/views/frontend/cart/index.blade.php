@extends('layouts.frontend.app')

@section('title', 'Shopping Cart - ' . config('app.name'))

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
                        <p class="mt-2 text-gray-600">
                            <span id="cart-count">{{ $cartItems->count() }}</span>
                            {{ $cartItems->count() == 1 ? 'item' : 'items' }} in your cart
                        </p>
                    </div>
                    @if ($cartItems->count() > 0)
                        <button id="clear-cart-btn"
                            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Clear Cart
                        </button>
                    @endif
                </div>
            </div>

            @if ($cartItems->count() > 0)
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
                    <!-- Cart Items -->
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                        <ul role="list" class="border-t border-gray-200 divide-y divide-gray-200" id="cart-items">
                            @foreach ($cartItems as $item)
                                <li class="flex py-6 sm:py-10" data-product-id="{{ $item->id }}">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->featured_image_url ?? asset('images/placeholder-product.jpg') }}"
                                            alt="{{ $item->name }}"
                                            class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48">
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h3 class="text-sm">
                                                        <a href="#"
                                                            class="font-medium text-gray-700 hover:text-gray-800">
                                                            {{ $item->name }}
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="mt-1 flex text-sm">
                                                    <p class="text-gray-500">{{ $item->generic->name ?? 'N/A' }}
                                                    </p>
                                                    @if ($item->manufacturer)
                                                        <p class="ml-4 pl-4 border-l border-gray-200 text-gray-500">
                                                            {{ $item->manufacturer }}</p>
                                                    @endif
                                                </div>
                                                <div class="mt-1 flex text-sm">
                                                    <p class="text-gray-500">Stock: {{ $item->stock_quantity }}
                                                    </p>
                                                    @if ($item->expiry_date)
                                                        <p class="ml-4 pl-4 border-l border-gray-200 text-gray-500">
                                                            Expires:
                                                            {{ \Carbon\Carbon::parse($item->expiry_date)->format('M Y') }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <p class="mt-1 text-sm font-medium text-gray-900">
                                                    ৳{{ number_format($item->price, 2) }}</p>
                                            </div>

                                            <div class="mt-4 sm:mt-0 sm:pr-9">
                                                <div class="flex items-center">
                                                    <label for="quantity-{{ $item->id }}"
                                                        class="sr-only">Quantity</label>
                                                    <div class="flex items-center border border-gray-300 rounded-md">
                                                        <button type="button"
                                                            class="quantity-btn minus-btn p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            data-product-id="{{ $item->id }}" data-action="decrease">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M20 12H4"></path>
                                                            </svg>
                                                        </button>
                                                        <input type="number" id="quantity-{{ $item->id }}"
                                                            name="quantity" value="{{ $item->cart_quantity }}"
                                                            min="1" max="{{ $item->stock_quantity }}"
                                                            class="quantity-input w-16 text-center border-0 py-2 text-gray-900 focus:ring-0 focus:outline-none"
                                                            data-product-id="{{ $item->id }}">
                                                        <button type="button"
                                                            class="quantity-btn plus-btn p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            data-product-id="{{ $item->id }}" data-action="increase">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="absolute top-0 right-0">
                                                    <button type="button"
                                                        class="remove-item-btn -m-2 p-2 inline-flex text-gray-400 hover:text-gray-500"
                                                        data-product-id="{{ $item->id }}">
                                                        <span class="sr-only">Remove</span>
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                            @if ($item->stock_quantity > 0)
                                                @if ($item->cart_quantity <= $item->stock_quantity)
                                                    <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span>In stock</span>
                                                @else
                                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span>Limited stock ({{ $item->stock_quantity }}
                                                        available)</span>
                                                @endif
                                            @else
                                                <svg class="flex-shrink-0 w-5 h-5 text-red-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span>Out of stock</span>
                                            @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    <!-- Order Summary -->
                    <section aria-labelledby="summary-heading"
                        class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                        <dl class="mt-6 space-y-4" id="cart-summary">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">৳<span
                                        id="subtotal">{{ number_format($summary['subtotal'], 2) }}</span></dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex items-center text-sm text-gray-600">
                                    <span>Shipping estimate</span>
                                    <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Learn more about how shipping is calculated</span>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">৳<span
                                        id="shipping">{{ number_format($summary['shipping'], 2) }}</span></dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex text-sm text-gray-600">
                                    <span>Tax estimate</span>
                                    <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Learn more about how tax is calculated</span>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">৳<span
                                        id="tax">{{ number_format($summary['tax'], 2) }}</span></dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900">৳<span
                                        id="total">{{ number_format($summary['total'], 2) }}</span></dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
                                Checkout
                            </button>
                        </div>

                        <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                            <p>
                                or
                                <a href="{{ route('home') }}" class="text-indigo-600 font-medium hover:text-indigo-500">
                                    Continue Shopping
                                    <span aria-hidden="true"> &rarr;</span>
                                </a>
                            </p>
                        </div>
                    </section>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6m-4 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01">
                        </path>
                    </svg>
                    <h3 class="mt-6 text-xl font-medium text-gray-900">Your cart is empty</h3>
                    <p class="mt-2 text-gray-500">Start adding some items to your cart.</p>
                    <div class="mt-8">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-gray-700">Updating cart...</span>
        </div>
    </div>

    <!-- Message Container -->
    <div id="message-container" class="fixed top-4 right-4 z-50"></div>
@endsection

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
@endpush
