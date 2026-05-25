<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart page
     */
    public function index()
    {
        $cartItems = Cart::getItemsWithProducts();
        $summary = Cart::getSummary();
        $stockIssues = Cart::validateStock();

        return view('frontend.cart.index', compact('cartItems', 'summary', 'stockIssues'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'integer|min:1|max:999'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $product = Product::findOrFail($productId);

        // Check stock availability
        if ($product->stock_quantity < $quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.',
                    'available_stock' => $product->stock_quantity
                ]);
            }
            return redirect()->back()->with('error', 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.');
        }

        $added = Cart::add($productId, $quantity);

        if ($request->expectsJson()) {
            if ($added) {
                $summary = Cart::getSummary();
                return response()->json([
                    'success' => true,
                    'message' => "'{$product->name}' added to cart!",
                    'cart_count' => $summary['item_count'],
                    'cart_total' => $summary['total'],
                    'product_cart_quantity' => Cart::getQuantity($productId)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add item to cart.'
                ]);
            }
        }

        $message = $added ? "'{$product->name}' added to cart!" : 'Failed to add item to cart.';
        return redirect()->back()->with($added ? 'success' : 'error', $message);
    }

    /**
     * Update product quantity in cart
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0|max:999'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        if ($quantity == 0) {
            return $this->remove($request);
        }

        $product = Product::find($productId);
        if (!$product) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ]);
            }
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Check stock availability
        if ($product->stock_quantity < $quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.',
                    'available_stock' => $product->stock_quantity,
                    'current_quantity' => Cart::getQuantity($productId)
                ]);
            }
            return redirect()->back()->with('error', 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.');
        }

        $updated = Cart::updateQuantity($productId, $quantity);

        if ($request->expectsJson()) {
            if ($updated) {
                $summary = Cart::getSummary();
                $productTotal = $quantity * $product->price;

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'cart_count' => $summary['item_count'],
                    'cart_subtotal' => $summary['subtotal'],
                    'cart_shipping' => $summary['shipping'],
                    'cart_total' => $summary['total'],
                    'product_total' => $productTotal,
                    'summary' => $summary
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update cart.'
                ]);
            }
        }

        $message = $updated ? 'Cart updated successfully!' : 'Failed to update cart.';
        return redirect()->back()->with($updated ? 'success' : 'error', $message);
    }

    /**
     * Remove product from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $productId = $request->product_id;
        $removed = Cart::remove($productId);

        if ($request->expectsJson()) {
            if ($removed) {
                $summary = Cart::getSummary();
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart!',
                    'cart_count' => $summary['item_count'],
                    'cart_subtotal' => $summary['subtotal'],
                    'cart_shipping' => $summary['shipping'],
                    'cart_total' => $summary['total'],
                    'summary' => $summary
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart!'
                ]);
            }
        }

        $message = $removed ? 'Product removed from cart!' : 'Product not found in cart!';
        return redirect()->back()->with($removed ? 'success' : 'error', $message);
    }

    /**
     * Get cart count (AJAX)
     */
    public function count()
    {
        $summary = Cart::getSummary();
        return response()->json([
            'count' => $summary['item_count'],
            'unique_items' => $summary['unique_items'],
            'total' => $summary['total']
        ]);
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        Cart::clear();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully!',
                'count' => 0,
                'total' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart summary (AJAX)
     */
    public function summary()
    {
        $summary = Cart::getSummary();
        return response()->json($summary);
    }

    /**
     * Fix stock issues in cart
     */
    public function fixStockIssues()
    {
        $fixed = Cart::fixStockIssues();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated based on current stock availability.',
                'fixed_issues' => $fixed,
                'summary' => Cart::getSummary()
            ]);
        }

        $message = empty($fixed) ? 'No issues found in cart.' : 'Cart updated: ' . implode(', ', $fixed);
        return redirect()->back()->with('success', $message);
    }

    /**
     * Check product availability and get cart info
     */
    public function checkProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $productId = $request->product_id;
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
                'in_cart' => Cart::has($productId),
                'cart_quantity' => Cart::getQuantity($productId)
            ],
            'cart_summary' => Cart::getSummary()
        ]);
    }
}
