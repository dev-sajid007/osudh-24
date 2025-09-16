<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get dashboard statistics (role-based access)
        $stats = [
            'total_users' => $user->hasRole(['admin', 'manager']) ? User::count() : 'N/A',
            'active_users' => $user->hasRole(['admin', 'manager']) ? User::where('email_verified_at', '!=', null)->count() : 'N/A',
            'new_users_today' => $user->hasRole(['admin', 'manager']) ? User::whereDate('created_at', today())->count() : 'N/A',
            'new_users_this_week' => $user->hasRole(['admin', 'manager']) ? User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() : 'N/A',
        ];

        // Get recent users (only for admin and manager)
        $recent_users = $user->hasRole(['admin', 'manager']) ? User::latest()->take(5)->get() : collect();

        // Get user registration chart data (last 7 days) - only for admin and manager
        $chart_data = [];
        if ($user->hasRole(['admin', 'manager'])) {
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $chart_data[] = [
                    'date' => $date->format('M d'),
                    'users' => User::whereDate('created_at', $date)->count()
                ];
            }
        }

        return view('dashboard.index', compact('stats', 'recent_users', 'chart_data'));
    }

    public function admin()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'low_stock_products' => Product::lowStock()->count(),
            'out_of_stock_products' => Product::where('stock_quantity', 0)->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::active()->count(),
            'total_suppliers' => Supplier::count(),
            'active_suppliers' => Supplier::active()->count(),
            'prescription_products' => Product::prescriptionRequired()->count(),
            'otc_products' => Product::otc()->count(),
            'products_expiring_soon' => Product::expiringSoon()->count(),
            'expired_products' => Product::expired()->count(),
        ];

        // Recent products
        $recent_products = Product::with(['category', 'supplier'])
            ->latest()
            ->take(5)
            ->get();

        // Low stock alerts
        $low_stock_products = Product::with(['category'])
            ->lowStock()
            ->orderBy('stock_quantity')
            ->take(10)
            ->get();

        // Products expiring soon
        $expiring_products = Product::with(['category'])
            ->expiringSoon()
            ->orderBy('expiry_date')
            ->take(5)
            ->get();

        // Stock status distribution
        $stock_distribution = [
            'in_stock' => Product::where('stock_quantity', '>', 0)->whereRaw('stock_quantity > minimum_stock')->count(),
            'low_stock' => Product::lowStock()->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_products',
            'low_stock_products',
            'expiring_products',
            'stock_distribution'
        ));
    }
}
