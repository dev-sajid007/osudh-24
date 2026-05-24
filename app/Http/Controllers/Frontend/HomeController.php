<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured categories (limit to 6 for the grid)
        $featuredCategories = Category::active()
            ->whereNull('parent_id')
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        // Get featured products
        $featuredProducts = Product::active()
            ->inStock()
            ->with(['category', 'supplier', 'generic'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('frontend.home', compact('featuredCategories', 'featuredProducts'));
    }
}