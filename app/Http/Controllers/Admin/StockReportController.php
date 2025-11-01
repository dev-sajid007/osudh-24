<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockReportController extends Controller
{
    /**
     * Display stock reports dashboard.
     */
    public function index()
    {
        $stats = $this->getStockStatistics();

        return view('admin.reports.stock.index', compact('stats'));
    }

    /**
     * Low stock report.
     */
    public function lowStock(Request $request)
    {
        $threshold = $request->get('threshold', 10);
        $supplier = $request->get('supplier');
        $generic = $request->get('generic');
        $sortBy = $request->get('sort_by', 'stock_quantity');
        $sortOrder = $request->get('sort_order', 'asc');

        $products = Product::query()
            ->with(['supplier', 'generic'])
            ->whereRaw('stock_quantity <= minimum_stock OR stock_quantity <= ?', [$threshold])
            ->when($supplier, function ($query) use ($supplier) {
                $query->where('supplier_id', $supplier);
            })
            ->when($generic, function ($query) use ($generic) {
                $query->where('generic_id', $generic);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(50);

        $suppliers = Supplier::active()->orderBy('name')->get(['id', 'name']);
        $generics = Generic::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.reports.stock.low-stock', compact(
            'products',
            'suppliers',
            'generics',
            'threshold',
            'supplier',
            'generic',
            'sortBy',
            'sortOrder'
        ));
    }

    /**
     * Expired products report.
     */
    public function expired(Request $request)
    {
        $dateFilter = $request->get('date_filter', 'expired');
        $supplier = $request->get('supplier');
        $generic = $request->get('generic');

        $query = Product::query()->with(['supplier', 'generic']);

        switch ($dateFilter) {
            case 'expired':
                $query->where('expiry_date', '<', now());
                break;
            case 'expiring_30':
                $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
                break;
            case 'expiring_60':
                $query->whereBetween('expiry_date', [now(), now()->addDays(60)]);
                break;
            case 'expiring_90':
                $query->whereBetween('expiry_date', [now(), now()->addDays(90)]);
                break;
        }

        $products = $query
            ->when($supplier, function ($query) use ($supplier) {
                $query->where('supplier_id', $supplier);
            })
            ->when($generic, function ($query) use ($generic) {
                $query->where('generic_id', $generic);
            })
            ->orderBy('expiry_date', 'asc')
            ->paginate(50);

        $suppliers = Supplier::active()->orderBy('name')->get(['id', 'name']);
        $generics = Generic::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.reports.stock.expired', compact(
            'products',
            'suppliers',
            'generics',
            'dateFilter',
            'supplier',
            'generic'
        ));
    }

    /**
     * Stock valuation report.
     */
    public function valuation(Request $request)
    {
        $supplier = $request->get('supplier');
        $generic = $request->get('generic');
        $groupBy = $request->get('group_by', 'supplier');

        $baseQuery = Product::query()
            ->selectRaw('
                COUNT(*) as total_products,
                SUM(stock_quantity) as total_quantity,
                SUM(stock_quantity * unit_price) as total_value,
                AVG(unit_price) as avg_price,
                MIN(unit_price) as min_price,
                MAX(unit_price) as max_price
            ')
            ->when($supplier, function ($query) use ($supplier) {
                $query->where('supplier_id', $supplier);
            })
            ->when($generic, function ($query) use ($generic) {
                $query->where('generic_id', $generic);
            });

        if ($groupBy === 'supplier') {
            $valuationData = Product::query()
                ->select([
                    'suppliers.name as group_name',
                    'suppliers.id as group_id',
                    DB::raw('COUNT(products.id) as total_products'),
                    DB::raw('SUM(products.stock_quantity) as total_quantity'),
                    DB::raw('SUM(products.stock_quantity * products.unit_price) as total_value'),
                    DB::raw('AVG(products.unit_price) as avg_price')
                ])
                ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
                ->when($generic, function ($query) use ($generic) {
                    $query->where('products.generic_id', $generic);
                })
                ->groupBy('suppliers.id', 'suppliers.name')
                ->orderBy('total_value', 'desc')
                ->get();
        } else {
            $valuationData = Product::query()
                ->select([
                    'generics.name as group_name',
                    'generics.id as group_id',
                    DB::raw('COUNT(products.id) as total_products'),
                    DB::raw('SUM(products.stock_quantity) as total_quantity'),
                    DB::raw('SUM(products.stock_quantity * products.unit_price) as total_value'),
                    DB::raw('AVG(products.unit_price) as avg_price')
                ])
                ->leftJoin('generics', 'products.generic_id', '=', 'generics.id')
                ->when($supplier, function ($query) use ($supplier) {
                    $query->where('products.supplier_id', $supplier);
                })
                ->groupBy('generics.id', 'generics.name')
                ->orderBy('total_value', 'desc')
                ->get();
        }

        $totalStats = $baseQuery->first();
        $suppliers = Supplier::active()->orderBy('name')->get(['id', 'name']);
        $generics = Generic::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.reports.stock.valuation', compact(
            'valuationData',
            'totalStats',
            'suppliers',
            'generics',
            'supplier',
            'generic',
            'groupBy'
        ));
    }

    /**
     * Stock movement report.
     */
    public function movement(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $product = $request->get('product');
        $supplier = $request->get('supplier');

        // This would require a stock_movements table to be implemented
        // For now, we'll show a placeholder view
        $movements = collect(); // Placeholder

        $suppliers = Supplier::active()->orderBy('name')->get(['id', 'name']);
        $products = Product::with('supplier')->orderBy('name')->get(['id', 'name', 'supplier_id']);

        return view('admin.reports.stock.movement', compact(
            'movements',
            'suppliers',
            'products',
            'startDate',
            'endDate',
            'product',
            'supplier'
        ));
    }

    /**
     * Stock analysis dashboard.
     */
    public function analysis()
    {
        $analytics = [
            'top_selling' => $this->getTopSellingProducts(),
            'slow_moving' => $this->getSlowMovingProducts(),
            'category_analysis' => $this->getCategoryAnalysis(),
            'supplier_performance' => $this->getSupplierPerformance(),
            'monthly_trends' => $this->getMonthlyTrends(),
        ];

        return view('admin.reports.stock.analysis', compact('analytics'));
    }

    /**
     * Export stock reports.
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'low_stock');
        $format = $request->get('format', 'pdf');

        switch ($type) {
            case 'low_stock':
                return $this->exportLowStock($format);
            case 'expired':
                return $this->exportExpired($format);
            case 'valuation':
                return $this->exportValuation($format);
            default:
                return redirect()->back()->with('error', 'Invalid export type.');
        }
    }

    // Private helper methods

    private function getStockStatistics()
    {
        $totalProducts = Product::count();
        $lowStockProducts = Product::whereRaw('stock_quantity <= minimum_stock')->count();
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();
        $expiredProducts = Product::where('expiry_date', '<', now())->count();
        $expiringProducts = Product::whereBetween('expiry_date', [now(), now()->addDays(30)])->count();

        $totalStockValue = Product::selectRaw('SUM(stock_quantity * unit_price) as total')
            ->value('total') ?? 0;

        $averageStockDays = Product::selectRaw('AVG(DATEDIFF(expiry_date, NOW())) as avg_days')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '>', now())
            ->value('avg_days') ?? 0;

        return [
            'total_products' => $totalProducts,
            'low_stock_products' => $lowStockProducts,
            'out_of_stock_products' => $outOfStockProducts,
            'expired_products' => $expiredProducts,
            'expiring_products' => $expiringProducts,
            'total_stock_value' => $totalStockValue,
            'average_stock_days' => round($averageStockDays, 1),
            'stock_turnover_rate' => $this->calculateStockTurnoverRate(),
        ];
    }

    private function getTopSellingProducts()
    {
        // Placeholder - would need sales data
        return Product::select(['id', 'name', 'stock_quantity', 'unit_price'])
            ->orderBy('stock_quantity', 'desc')
            ->limit(10)
            ->get();
    }

    private function getSlowMovingProducts()
    {
        // Products with high stock but low movement (placeholder logic)
        return Product::select(['id', 'name', 'stock_quantity', 'unit_price', 'created_at'])
            ->where('stock_quantity', '>', 50)
            ->where('created_at', '<', now()->subDays(90))
            ->orderBy('stock_quantity', 'desc')
            ->limit(10)
            ->get();
    }

    private function getCategoryAnalysis()
    {
        return Generic::select([
            'generics.name',
            DB::raw('COUNT(products.id) as product_count'),
            DB::raw('SUM(products.stock_quantity) as total_stock'),
            DB::raw('SUM(products.stock_quantity * products.unit_price) as total_value')
        ])
            ->leftJoin('products', 'generics.id', '=', 'products.generic_id')
            ->groupBy('generics.id', 'generics.name')
            ->orderBy('total_value', 'desc')
            ->limit(10)
            ->get();
    }

    private function getSupplierPerformance()
    {
        return Supplier::select([
            'suppliers.name',
            DB::raw('COUNT(products.id) as product_count'),
            DB::raw('SUM(products.stock_quantity) as total_stock'),
            DB::raw('SUM(products.stock_quantity * products.unit_price) as total_value'),
            DB::raw('AVG(products.unit_price) as avg_price')
        ])
            ->leftJoin('products', 'suppliers.id', '=', 'products.supplier_id')
            ->where('suppliers.is_active', true)
            ->groupBy('suppliers.id', 'suppliers.name')
            ->orderBy('total_value', 'desc')
            ->limit(10)
            ->get();
    }

    private function getMonthlyTrends()
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $months[] = [
                'month' => $date->format('M Y'),
                'products_added' => Product::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'total_value' => Product::whereYear('created_at', '<=', $date->year)
                    ->whereMonth('created_at', '<=', $date->month)
                    ->sum(DB::raw('stock_quantity * unit_price')) ?? 0,
            ];
        }
        return $months;
    }

    private function calculateStockTurnoverRate()
    {
        // Placeholder calculation - would need sales data for accurate calculation
        $totalStockValue = Product::sum(DB::raw('stock_quantity * unit_price')) ?? 1;
        $avgMonthlyAdditions = Product::where('created_at', '>=', now()->subMonths(6))
            ->sum(DB::raw('stock_quantity * unit_price')) / 6;

        return $avgMonthlyAdditions > 0 ? round($totalStockValue / $avgMonthlyAdditions, 2) : 0;
    }

    private function exportLowStock($format)
    {
        // Placeholder for export functionality
        return redirect()->back()->with('info', 'Export functionality will be implemented soon.');
    }

    private function exportExpired($format)
    {
        // Placeholder for export functionality
        return redirect()->back()->with('info', 'Export functionality will be implemented soon.');
    }

    private function exportValuation($format)
    {
        // Placeholder for export functionality
        return redirect()->back()->with('info', 'Export functionality will be implemented soon.');
    }
}
