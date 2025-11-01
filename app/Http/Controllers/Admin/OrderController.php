<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by order number or customer name/email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(20)->withQueryString();

        // Get statistics for dashboard cards
        $stats = $this->getOrderStats();

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product.generic']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $order->order_status;
        $newStatus = $request->order_status;

        $order->update([
            'order_status' => $newStatus,
            'admin_notes' => $request->admin_notes,
        ]);

        // Update timestamps based on status
        switch ($newStatus) {
            case 'confirmed':
                $order->update(['confirmed_at' => now()]);
                break;
            case 'shipped':
                $order->update(['shipped_at' => now()]);
                break;
            case 'delivered':
                $order->update(['delivered_at' => now()]);
                break;
        }

        return redirect()->back()->with('success', "Order status updated from '{$oldStatus}' to '{$newStatus}'");
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);

        $oldPaymentStatus = $order->payment_status;
        $newPaymentStatus = $request->payment_status;

        $order->update([
            'payment_status' => $newPaymentStatus
        ]);

        return redirect()->back()->with('success', "Payment status updated from '{$oldPaymentStatus}' to '{$newPaymentStatus}'");
    }

    /**
     * Get order statistics
     */
    private function getOrderStats()
    {
        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'confirmed_orders' => Order::where('order_status', 'confirmed')->count(),
            'shipped_orders' => Order::where('order_status', 'shipped')->count(),
            'delivered_orders' => Order::where('order_status', 'delivered')->count(),
            'cancelled_orders' => Order::where('order_status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_revenue' => Order::where('payment_status', 'pending')->sum('total_amount'),
            'todays_orders' => Order::whereDate('created_at', today())->count(),
            'todays_revenue' => Order::whereDate('created_at', today())
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();

        $filename = 'orders_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order Number',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Order Status',
                'Payment Status',
                'Payment Method',
                'Total Amount',
                'Order Date',
                'Shipping Address'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->order_status,
                    $order->payment_status,
                    $order->paymentMethodDisplay,
                    $order->total_amount,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->shipping_address . ', ' . $order->shipping_city
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk update order status
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'action' => 'required|in:confirm,ship,deliver,cancel',
        ]);

        $orderIds = $request->order_ids;
        $action = $request->action;

        $statusMap = [
            'confirm' => 'confirmed',
            'ship' => 'shipped',
            'deliver' => 'delivered',
            'cancel' => 'cancelled'
        ];

        $newStatus = $statusMap[$action];
        $updated = 0;

        foreach ($orderIds as $orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['order_status' => $newStatus]);
                
                // Update timestamp
                switch ($newStatus) {
                    case 'confirmed':
                        $order->update(['confirmed_at' => now()]);
                        break;
                    case 'shipped':
                        $order->update(['shipped_at' => now()]);
                        break;
                    case 'delivered':
                        $order->update(['delivered_at' => now()]);
                        break;
                }
                
                $updated++;
            }
        }

        return redirect()->back()->with('success', "Updated {$updated} orders to '{$newStatus}' status");
    }
}