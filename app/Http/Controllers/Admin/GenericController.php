<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenericController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Generic::withProductCount();

        // Handle search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $generics = $query->orderBy('name')->paginate(15);

        return view('admin.generics.index', compact('generics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.generics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:generics,name',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $generic = Generic::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.generics.index')
            ->with('success', 'Generic created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Generic $generic)
    {
        $products = $generic->products()
            ->with(['category', 'supplier'])
            ->active()
            ->paginate(20);

        return view('admin.generics.show', compact('generic', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Generic $generic)
    {
        return view('admin.generics.edit', compact('generic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Generic $generic)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:generics,name,' . $generic->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $generic->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.generics.index')
            ->with('success', 'Generic updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Generic $generic)
    {
        // Check if generic has products
        if ($generic->products()->count() > 0) {
            return back()->with('error', 'Cannot delete generic that has products associated with it.');
        }

        $generic->delete();

        return redirect()->route('admin.generics.index')
            ->with('success', 'Generic deleted successfully.');
    }
}
