<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the wishlist page
     */
    public function index()
    {
        $products = Wishlist::getProducts();
        $totalCount = Wishlist::count();

        return view('frontend.wishlist.index', compact('products', 'totalCount'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);

        $productId = $request->product_id;
        $product = Product::findOrFail($productId);

        $result = Wishlist::toggle($productId);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $result['action'] === 'added'
                    ? "'{$product->name}' added to wishlist!"
                    : "'{$product->name}' removed from wishlist!",
                'action' => $result['action'],
                'in_wishlist' => $result['in_wishlist'],
                'count' => $result['count']
            ]);
        }

        $message = $result['action'] === 'added'
            ? "'{$product->name}' added to wishlist!"
            : "'{$product->name}' removed from wishlist!";

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $productId = $request->product_id;
        $removed = Wishlist::remove($productId);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $removed,
                'message' => $removed ? 'Product removed from wishlist!' : 'Product not found in wishlist!',
                'count' => Wishlist::count()
            ]);
        }

        $message = $removed ? 'Product removed from wishlist!' : 'Product not found in wishlist!';
        return redirect()->back()->with($removed ? 'success' : 'error', $message);
    }

    /**
     * Get wishlist count (AJAX)
     */
    public function count()
    {
        return response()->json([
            'count' => Wishlist::count()
        ]);
    }

    /**
     * Clear all wishlist items
     */
    public function clear()
    {
        Wishlist::clear();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared successfully!',
                'count' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Wishlist cleared successfully!');
    }

    /**
     * Check if product is in wishlist (AJAX)
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        return response()->json([
            'in_wishlist' => Wishlist::has($request->product_id),
            'count' => Wishlist::count()
        ]);
    }
}
