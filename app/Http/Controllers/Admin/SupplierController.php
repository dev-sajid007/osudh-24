<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $perPage = $request->get('per_page', 15);

        $suppliers = Supplier::query()
            ->withProductCount()
            ->when($search, function ($query, $search) {
                $query->search($search);
            })
            ->when($status !== null, function ($query) use ($status) {
                if ($status === 'active') {
                    $query->active();
                } elseif ($status === 'inactive') {
                    $query->inactive();
                }
            })
            ->orderBy('name')
            ->paginate($perPage);

        return view('admin.suppliers.index', compact('suppliers', 'search', 'status'));
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:suppliers,code',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'gst_number' => 'nullable|string|max:50',
            'license_number' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'credit_limit' => 'nullable|numeric|min:0|max:999999999.99',
            'payment_terms_days' => 'nullable|integer|min:0|max:365',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        try {
            DB::beginTransaction();

            $supplier = Supplier::create($validated);

            DB::commit();

            return redirect()
                ->route('admin.suppliers.show', $supplier)
                ->with('success', 'Supplier created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create supplier. Please try again.');
        }
    }

    /**
     * Display the specified supplier.
     */
    public function show(Supplier $supplier)
    {
        $supplier->load(['products' => function ($query) {
            $query->with('generic')->latest()->take(10);
        }]);

        $stats = [
            'total_products' => $supplier->products()->count(),
            'active_products' => $supplier->products()->where('is_active', true)->count(),
            'inactive_products' => $supplier->products()->where('is_active', false)->count(),
            'low_stock_products' => $supplier->products()->where('stock_quantity', '<=', 10)->count(),
        ];

        return view('admin.suppliers.show', compact('supplier', 'stats'));
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('suppliers', 'code')->ignore($supplier->id)
            ],
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'gst_number' => 'nullable|string|max:50',
            'license_number' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'credit_limit' => 'nullable|numeric|min:0|max:999999999.99',
            'payment_terms_days' => 'nullable|integer|min:0|max:365',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        try {
            DB::beginTransaction();

            $supplier->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.suppliers.show', $supplier)
                ->with('success', 'Supplier updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update supplier. Please try again.');
        }
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            // Check if supplier has products
            if ($supplier->products()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete supplier. There are products associated with this supplier.');
            }

            DB::beginTransaction();

            $supplier->delete();

            DB::commit();

            return redirect()
                ->route('admin.suppliers.index')
                ->with('success', 'Supplier deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Failed to delete supplier. Please try again.');
        }
    }

    /**
     * Toggle supplier status.
     */
    public function toggleStatus(Supplier $supplier)
    {
        try {
            $supplier->update([
                'is_active' => !$supplier->is_active
            ]);

            $status = $supplier->is_active ? 'activated' : 'deactivated';

            return redirect()
                ->back()
                ->with('success', "Supplier {$status} successfully.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update supplier status.');
        }
    }

    /**
     * Get suppliers for AJAX requests.
     */
    public function api(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 10);

        $suppliers = Supplier::active()
            ->when($search, function ($query, $search) {
                $query->search($search);
            })
            ->orderBy('name')
            ->limit($limit)
            ->get(['id', 'name', 'code', 'email', 'phone']);

        return response()->json($suppliers);
    }
}
