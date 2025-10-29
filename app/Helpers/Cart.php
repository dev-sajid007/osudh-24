<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Cart
{
    const SESSION_KEY = 'cart';

    /**
     * Add a product to the cart
     */
    public static function add(int $productId, int $quantity = 1): bool
    {
        $product = Product::find($productId);
        if (!$product || $product->stock_quantity < $quantity) {
            return false;
        }

        $cart = self::getItems();

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            // Check if new quantity exceeds stock
            if ($newQuantity > $product->stock_quantity) {
                $cart[$productId]['quantity'] = $product->stock_quantity;
            } else {
                $cart[$productId]['quantity'] = $newQuantity;
            }
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => min($quantity, $product->stock_quantity),
                'price' => $product->unit_price,
                'added_at' => now()->toDateTimeString()
            ];
        }

        Session::put(self::SESSION_KEY, $cart);
        return true;
    }

    /**
     * Remove a product from the cart
     */
    public static function remove(int $productId): bool
    {
        $cart = self::getItems();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put(self::SESSION_KEY, $cart);
            return true;
        }

        return false;
    }

    /**
     * Update product quantity in cart
     */
    public static function updateQuantity(int $productId, int $quantity): bool
    {
        if ($quantity <= 0) {
            return self::remove($productId);
        }

        $product = Product::find($productId);
        if (!$product) {
            return false;
        }

        $cart = self::getItems();

        if (isset($cart[$productId])) {
            // Check stock availability
            $cart[$productId]['quantity'] = min($quantity, $product->stock_quantity);
            Session::put(self::SESSION_KEY, $cart);
            return true;
        }

        return false;
    }

    /**
     * Check if a product is in the cart
     */
    public static function has(int $productId): bool
    {
        $cart = self::getItems();
        return isset($cart[$productId]);
    }

    /**
     * Get product quantity in cart
     */
    public static function getQuantity(int $productId): int
    {
        $cart = self::getItems();
        return $cart[$productId]['quantity'] ?? 0;
    }

    /**
     * Get all cart items (array format)
     */
    public static function getItems(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    /**
     * Get cart items with product details
     */
    public static function getItemsWithProducts(): \Illuminate\Support\Collection
    {
        $cartItems = self::getItems();

        if (empty($cartItems)) {
            return collect();
        }

        $productIds = array_keys($cartItems);
        $products = Product::whereIn('id', $productIds)
            ->with(['category', 'supplier', 'generic'])
            ->get()
            ->keyBy('id');

        // Merge cart data with product data
        $items = collect();
        foreach ($cartItems as $productId => $cartItem) {
            if ($products->has($productId)) {
                $product = $products->get($productId);
                $product->cart_quantity = $cartItem['quantity'];
                $product->cart_price = $cartItem['price'];
                $product->cart_total = $cartItem['quantity'] * $cartItem['price'];
                $product->added_at = $cartItem['added_at'];
                $items->push($product);
            }
        }

        return $items;
    }

    /**
     * Get total number of items in cart
     */
    public static function count(): int
    {
        $cart = self::getItems();
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Get total number of unique products in cart
     */
    public static function getUniqueItemCount(): int
    {
        return count(self::getItems());
    }

    /**
     * Get cart subtotal
     */
    public static function getSubtotal(): float
    {
        $cart = self::getItems();
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['quantity'] * $item['price'];
        }

        return round($subtotal, 2);
    }

    /**
     * Get cart total with tax (assuming 10% tax)
     */
    public static function getTotal(float $taxRate = 0.10): float
    {
        $subtotal = self::getSubtotal();
        $tax = $subtotal * $taxRate;
        return round($subtotal + $tax, 2);
    }

    /**
     * Get tax amount
     */
    public static function getTax(float $taxRate = 0.10): float
    {
        return round(self::getSubtotal() * $taxRate, 2);
    }

    /**
     * Get shipping cost
     */
    public static function getShipping(): float
    {
        $subtotal = self::getSubtotal();

        // Free shipping over 1000 Taka, otherwise 50 Taka
        if ($subtotal >= 1000) {
            return 0.00;
        }

        return 50.00;
    }

    /**
     * Clear all items from cart
     */
    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Get cart summary
     */
    public static function getSummary(): array
    {
        $subtotal = self::getSubtotal();
        $tax = self::getTax();
        $shipping = self::getShipping();
        $total = $subtotal + $tax + $shipping;

        return [
            'item_count' => self::count(),
            'unique_items' => self::getUniqueItemCount(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => round($total, 2)
        ];
    }

    /**
     * Check if cart is empty
     */
    public static function isEmpty(): bool
    {
        return empty(self::getItems());
    }

    /**
     * Validate cart items against current stock
     */
    public static function validateStock(): array
    {
        $cart = self::getItems();
        $issues = [];

        foreach ($cart as $productId => $cartItem) {
            $product = Product::find($productId);
            if (!$product) {
                $issues[] = [
                    'product_id' => $productId,
                    'issue' => 'Product not found',
                    'action' => 'remove'
                ];
                continue;
            }

            if ($product->stock_quantity < $cartItem['quantity']) {
                $issues[] = [
                    'product_id' => $productId,
                    'product_name' => $product->name,
                    'requested_quantity' => $cartItem['quantity'],
                    'available_quantity' => $product->stock_quantity,
                    'issue' => 'Insufficient stock',
                    'action' => 'reduce_quantity'
                ];
            }
        }

        return $issues;
    }

    /**
     * Fix stock issues automatically
     */
    public static function fixStockIssues(): array
    {
        $issues = self::validateStock();
        $fixed = [];

        foreach ($issues as $issue) {
            if ($issue['action'] === 'remove') {
                self::remove($issue['product_id']);
                $fixed[] = "Removed unavailable product from cart";
            } elseif ($issue['action'] === 'reduce_quantity') {
                $oldQuantity = $issue['requested_quantity'];
                $newQuantity = $issue['available_quantity'];
                self::updateQuantity($issue['product_id'], $newQuantity);
                $fixed[] = "Reduced {$issue['product_name']} quantity from {$oldQuantity} to {$newQuantity}";
            }
        }

        return $fixed;
    }
}
