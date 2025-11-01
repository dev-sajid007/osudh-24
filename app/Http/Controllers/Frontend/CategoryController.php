<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of all active categories.
     */
    public function index()
    {
        $categories = Category::active()
            ->whereNull('parent_id') // Only parent categories
            ->with(['children' => function ($query) {
                $query->active()->orderBy('sort_order');
            }])
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->orderBy('sort_order')
            ->get();

        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Display products by category.
     */
    public function show(Category $category, Request $request)
    {
        // Get all category IDs including children
        $categoryIds = collect([$category->id]);
        if ($category->children->count() > 0) {
            $categoryIds = $categoryIds->concat($category->children->pluck('id'));
        }

        $search = $request->get('search');
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        $perPage = $request->get('per_page', 20);

        $products = Product::active()
            ->inStock()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'supplier', 'generic'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('generic', function ($gq) use ($search) {
                            $gq->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage);

        // Get subcategories for filtering
        $subcategories = $category->children()->active()->get();

        return view('frontend.categories.show', compact('category', 'products', 'subcategories', 'search', 'sortBy', 'sortOrder'));
    }

    /**
     * Get categories for AJAX requests
     */
    public function api()
    {
        $categories = Category::active()
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->active()->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image_url,
                    'children' => $category->children->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'name' => $child->name,
                            'slug' => $child->slug,
                            'image' => $child->image_url,
                        ];
                    })
                ];
            });

        return response()->json($categories);
    }
}
