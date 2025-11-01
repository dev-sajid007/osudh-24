<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Helpers\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function index()
    {
        // Get cart items with product details
        $cartItems = Cart::getItemsWithProducts();

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check for stock issues
        $stockIssues = Cart::validateStock();
        if (!empty($stockIssues)) {
            return redirect()->route('cart.index')->with('error', 'Some items in your cart have stock issues. Please review your cart.');
        }

        $summary = Cart::getSummary();
        $user = Auth::user();

        return view('frontend.checkout.index', compact('cartItems', 'summary', 'user'));
    }

    /**
     * Process the checkout and create order
     */
    public function store(Request $request)
    {
        // Debug: Log that the method was called
        Log::info('Checkout store method called', ['request_data' => $request->all()]);
        
        try {
            // Validate the request
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'city' => 'required|string|max:255',
                'postal_code' => 'nullable|string|max:10',
                'payment_method' => 'required|in:cash_on_delivery,bkash,nagad,rocket',
                'prescription' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
                'special_instructions' => 'nullable|string|max:1000',
            ]);

            Log::info('Validation passed');

            // Check if cart is empty
            $cartItems = Cart::getItemsWithProducts();
            Log::info('Cart items retrieved', ['count' => $cartItems->count()]);
            
            if ($cartItems->isEmpty()) {
                Log::warning('Cart is empty');
                return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
            }

            // Final stock validation
            $stockIssues = Cart::validateStock();
            if (!empty($stockIssues)) {
                Log::warning('Stock validation failed', ['issues' => $stockIssues]);
                return redirect()->route('cart.index')->with('error', 'Some items in your cart are no longer available.');
            }

            Log::info('Stock validation passed');

            // Check if prescription is required
            $requiresPrescription = false;
            foreach ($cartItems as $item) {
                if ($item->prescription_required) {
                    $requiresPrescription = true;
                    break;
                }
            }

            if ($requiresPrescription && !$request->hasFile('prescription')) {
                Log::warning('Prescription required but not provided');
                return back()->withErrors(['prescription' => 'Prescription is required for prescription medications in your cart.']);
            }

            Log::info('Starting database transaction');
            DB::beginTransaction();
            
            // Calculate summary
            $summary = Cart::getSummary();

            // Handle prescription upload
            $prescriptionPath = null;
            if ($request->hasFile('prescription')) {
                $prescriptionPath = $request->file('prescription')->store('prescriptions', 'public');
            }

            // Create the order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => Auth::id(), // This can be null for guest users
                'customer_name' => $request->first_name . ' ' . $request->last_name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_postal_code' => $request->postal_code,
                'subtotal' => $summary['subtotal'],
                'shipping_cost' => $summary['shipping'],
                'tax_amount' => $summary['tax'],
                'total_amount' => $summary['total'],
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'prescription_path' => $prescriptionPath,
                'special_instructions' => $request->special_instructions,
            ]);

            Log::info('Order created', ['order_id' => $order->id, 'order_number' => $order->order_number]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'product_price' => $item->cart_price,
                    'quantity' => $item->cart_quantity,
                    'total_price' => $item->cart_quantity * $item->cart_price,
                ]);

                // Reduce product stock
                $product = Product::find($item->id);
                if ($product) {
                    $product->stock_quantity -= $item->cart_quantity;
                    $product->save();
                }
            }

            Log::info('Order items created and stock updated');

            // Clear the cart
            Cart::clear();
            Log::info('Cart cleared');

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Add debugging information
            Log::error('Checkout Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Something went wrong while processing your order. Please try again. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show order success page
     */
    public function success($orderNumber)
    {
        $query = Order::where('order_number', $orderNumber)
            ->with('orderItems');
            
        // If user is authenticated, only show their orders
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }
        
        $order = $query->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        return view('frontend.checkout.success', compact('order'));
    }

    /**
     * Generate a unique order number
     */
    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}