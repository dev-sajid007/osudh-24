<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\CloudinaryService;

class ProductController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'low_stock':
                    $query->lowStock();
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
                case 'in_stock':
                    $query->where('stock_quantity', '>', 0);
                    break;
            }
        }

        // Filter by prescription requirement
        if ($request->filled('prescription_required')) {
            $query->where('prescription_required', $request->prescription_required);
        }

        $products = $query->orderBy('name')->paginate(20);
        $categories = Category::active()->rootCategories()->get();
        $suppliers = Supplier::active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        $suppliers = Supplier::active()->orderBy('name')->get();
        $generics = Generic::active()->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'suppliers', 'generics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'generic_id' => 'nullable|exists:generics,id',
            'sku' => 'nullable|string|max:255|unique:products',
            'barcode' => 'nullable|string|max:255|unique:products',
            'dosage' => 'nullable|string|max:255',
            'form' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:255',
            'package_size' => 'nullable|string|max:255',
            'prescription_required' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'mrp' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'storage_instructions' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'status' => 'required|in:active,draft,discontinued',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string'
        ]);

        // Handle image uploads
        $images = [];
        $cloudinaryPublicIds = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate image
                $validation = $this->cloudinaryService->validateImage($image);
                if (!$validation['valid']) {
                    return back()->withErrors(['images' => $validation['error']])->withInput();
                }

                // Upload to Cloudinary
                $uploadResult = $this->cloudinaryService->uploadImage($image, 'products');

                if ($uploadResult['success']) {
                    $images[] = $uploadResult['secure_url'];
                    $cloudinaryPublicIds[] = $uploadResult['public_id'];
                } else {
                    return back()->withErrors(['images' => 'Failed to upload image: ' . $uploadResult['error']])->withInput();
                }
            }
        }

        $validated['images'] = $images;
        $validated['cloudinary_public_ids'] = $cloudinaryPublicIds;

        // Handle tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product = Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        $suppliers = Supplier::active()->orderBy('name')->get();
        $generics = Generic::active()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'suppliers', 'generics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'generic_id' => 'nullable|exists:generics,id',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $product->id,
            'dosage' => 'nullable|string|max:255',
            'form' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:255',
            'package_size' => 'nullable|string|max:255',
            'prescription_required' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'mrp' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'storage_instructions' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'status' => 'required|in:active,draft,discontinued',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string'
        ]);

        // Handle new image uploads
        $images = $product->images ?? [];
        $cloudinaryPublicIds = $product->cloudinary_public_ids ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate image
                $validation = $this->cloudinaryService->validateImage($image);
                if (!$validation['valid']) {
                    return back()->withErrors(['images' => $validation['error']])->withInput();
                }

                // Upload to Cloudinary
                $uploadResult = $this->cloudinaryService->uploadImage($image, 'products');

                if ($uploadResult['success']) {
                    $images[] = $uploadResult['secure_url'];
                    $cloudinaryPublicIds[] = $uploadResult['public_id'];
                } else {
                    return back()->withErrors(['images' => 'Failed to upload image: ' . $uploadResult['error']])->withInput();
                }
            }
        }

        $validated['images'] = $images;
        $validated['cloudinary_public_ids'] = $cloudinaryPublicIds;

        // Handle tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated images
        if ($product->cloudinary_public_ids) {
            foreach ($product->cloudinary_public_ids as $publicId) {
                $this->cloudinaryService->deleteImage($publicId);
            }
        } elseif ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Update stock quantity
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
            'reason' => 'nullable|string|max:255'
        ]);

        $product->update(['stock_quantity' => $validated['stock_quantity']]);

        return back()->with('success', 'Stock updated successfully.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'products' => 'required|array',
            'products.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $validated['products']);

        switch ($validated['action']) {
            case 'activate':
                $products->update(['status' => 'active']);
                $message = 'Products activated successfully.';
                break;
            case 'deactivate':
                $products->update(['status' => 'draft']);
                $message = 'Products deactivated successfully.';
                break;
            case 'delete':
                $products->delete();
                $message = 'Products deleted successfully.';
                break;
        }

        return back()->with('success', $message);
    }
}
