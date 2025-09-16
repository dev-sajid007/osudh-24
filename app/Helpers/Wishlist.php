<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Wishlist
{
    const SESSION_KEY = 'wishlist';

    /**
     * Add a product to the wishlist
     */
    public static function add(int $productId): bool
    {
        $wishlist = self::getItems();

        if (!in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            Session::put(self::SESSION_KEY, $wishlist);
            return true;
        }

        return false;
    }

    /**
     * Remove a product from the wishlist
     */
    public static function remove(int $productId): bool
    {
        $wishlist = self::getItems();
        $key = array_search($productId, $wishlist);

        if ($key !== false) {
            unset($wishlist[$key]);
            Session::put(self::SESSION_KEY, array_values($wishlist));
            return true;
        }

        return false;
    }

    /**
     * Check if a product is in the wishlist
     */
    public static function has(int $productId): bool
    {
        return in_array($productId, self::getItems());
    }

    /**
     * Get all wishlist product IDs
     */
    public static function getItems(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    /**
     * Get all wishlist products with details
     */
    public static function getProducts(): \Illuminate\Database\Eloquent\Collection
    {
        $productIds = self::getItems();

        if (empty($productIds)) {
            return collect();
        }

        return Product::whereIn('id', $productIds)
            ->with(['category', 'supplier'])
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            });
    }

    /**
     * Get wishlist items count
     */
    public static function count(): int
    {
        return count(self::getItems());
    }

    /**
     * Clear all items from wishlist
     */
    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Toggle product in wishlist (add if not present, remove if present)
     */
    public static function toggle(int $productId): array
    {
        if (self::has($productId)) {
            self::remove($productId);
            return [
                'action' => 'removed',
                'in_wishlist' => false,
                'count' => self::count()
            ];
        } else {
            self::add($productId);
            return [
                'action' => 'added',
                'in_wishlist' => true,
                'count' => self::count()
            ];
        }
    }
}
