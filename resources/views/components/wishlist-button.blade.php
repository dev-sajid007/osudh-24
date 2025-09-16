@props([
    'productId',
    'class' => 'p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors duration-200',
])

@php
    $inWishlist = \App\Helpers\Wishlist::has($productId);
@endphp

<button onclick="toggleWishlist({{ $productId }})" class="{{ $class }} wishlist-btn"
    data-product-id="{{ $productId }}" data-in-wishlist="{{ $inWishlist ? 'true' : 'false' }}"
    title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
    <i class="fas fa-heart {{ $inWishlist ? 'text-red-500' : 'text-gray-400' }}"></i>
</button>
