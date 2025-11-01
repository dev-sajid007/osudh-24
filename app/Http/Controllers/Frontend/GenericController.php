<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Generic;
use App\Models\Product;
use Illuminate\Http\Request;

class GenericController extends Controller
{
    /**
     * Display a listing of all generics with product counts.
     */
    public function index()
    {
        $generics = Generic::active()
            ->withProductCount()
            ->withActiveProducts()
            ->orderBy('name')
            ->paginate(20);

        return view('frontend.generics.index', compact('generics'));
    }

    /**
     * Display products by generic.
     */
    public function show(Generic $generic)
    {
        $products = Product::byGeneric($generic->id)
            ->active()
            ->inStock()
            ->with(['category', 'supplier'])
            ->orderBy('name')
            ->paginate(20);

        return view('frontend.generics.show', compact('generic', 'products'));
    }

    /**
     * Display products grouped by generic for comparison.
     */
    public function compare(Request $request)
    {
        $search = $request->get('search');

        $genericGroups = Product::active()
            ->inStock()
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->groupByGeneric()
            ->get()
            ->map(function ($group) {
                $products = Product::byGeneric($group->generic_id)
                    ->active()
                    ->inStock()
                    ->with(['category', 'supplier'])
                    ->orderBy('unit_price')
                    ->get();

                return [
                    'generic' => $group->generic,
                    'products' => $products,
                    'count' => $products->count(),
                    'min_price' => $products->min('unit_price'),
                    'max_price' => $products->max('unit_price')
                ];
            });

        return view('frontend.generics.compare', compact('genericGroups', 'search'));
    }
}
