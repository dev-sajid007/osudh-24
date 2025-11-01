<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::active()
            ->inStock()
            ->with(['category', 'supplier', 'generic']);

        // Filter by category if provided
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Price range filter
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('unit_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('unit_price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->whereNull('parent_id')->withCount('products')->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product
     */
    public function show($slug)
    {
        $product = Product::active()
            ->with(['category', 'supplier', 'generic'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related products from the same category
        $relatedProducts = Product::active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // Get recently viewed products (you can implement this later with sessions/cookies)
        $recentlyViewed = collect();

        return view('frontend.products.show', compact('product', 'relatedProducts', 'recentlyViewed'));
    }
}
