<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\CloudinaryService;

class CategoryController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::active()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Validate image
            $validation = $this->cloudinaryService->validateImage($request->file('image'));
            if (!$validation['valid']) {
                return back()->withErrors(['image' => $validation['error']])->withInput();
            }

            // Upload to Cloudinary
            $uploadResult = $this->cloudinaryService->uploadImage($request->file('image'), 'categories');

            if ($uploadResult['success']) {
                $validated['image'] = $uploadResult['secure_url'];
                $validated['cloudinary_public_id'] = $uploadResult['public_id'];
            } else {
                return back()->withErrors(['image' => 'Failed to upload image: ' . $uploadResult['error']])->withInput();
            }
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products']);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::active()
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Prevent setting self as parent
        if ($validated['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'Category cannot be its own parent.']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Validate image
            $validation = $this->cloudinaryService->validateImage($request->file('image'));
            if (!$validation['valid']) {
                return back()->withErrors(['image' => $validation['error']])->withInput();
            }

            // Delete old Cloudinary image if exists
            if ($category->cloudinary_public_id) {
                $this->cloudinaryService->deleteImage($category->cloudinary_public_id);
            } elseif ($category->image) {
                // Delete old local image if exists
                Storage::disk('public')->delete($category->image);
            }

            // Upload new image to Cloudinary
            $uploadResult = $this->cloudinaryService->uploadImage($request->file('image'), 'categories');

            if ($uploadResult['success']) {
                $validated['image'] = $uploadResult['secure_url'];
                $validated['cloudinary_public_id'] = $uploadResult['public_id'];
            } else {
                return back()->withErrors(['image' => 'Failed to upload image: ' . $uploadResult['error']])->withInput();
            }
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with associated products.']);
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with subcategories.']);
        }

        // Delete associated image
        if ($category->cloudinary_public_id) {
            $this->cloudinaryService->deleteImage($category->cloudinary_public_id);
        } elseif ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    /**
     * Get categories for API/AJAX calls
     */
    public function getCategories(Request $request)
    {
        $query = Category::active();

        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        $categories = $query->orderBy('name')->get(['id', 'name', 'parent_id']);

        return response()->json($categories);
    }

    /**
     * Reorder categories
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($validated['categories'] as $categoryData) {
            Category::where('id', $categoryData['id'])
                ->update(['sort_order' => $categoryData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
