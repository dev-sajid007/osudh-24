@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number)
@push('styles')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
@endpush
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-lg-8">
                <!-- Order Header -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Order #{{ $order->order_number }}</h6>
                        <div class="d-flex gap-2">
                            <span class="badge badge-{{ $order->statusBadgeColor }} badge-lg">
                                {{ ucfirst($order->order_status) }}
                            </span>
                            <span class="badge badge-{{ $order->paymentStatusBadgeColor }} badge-lg">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-gray-800 mb-2">Order Information</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Order Date:</td>
                                        <td>{{ $order->created_at->format('F j, Y \a\t g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Payment Method:</td>
                                        <td>{{ $order->paymentMethodDisplay }}</td>
                                    </tr>
                                    @if($order->confirmed_at)
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Confirmed:</td>
                                        <td>{{ $order->confirmed_at->format('F j, Y \a\t g:i A') }}</td>
                                    </tr>
                                    @endif
                                    @if($order->shipped_at)
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Shipped:</td>
                                        <td>{{ $order->shipped_at->format('F j, Y \a\t g:i A') }}</td>
                                    </tr>
                                    @endif
                                    @if($order->delivered_at)
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Delivered:</td>
                                        <td>{{ $order->delivered_at->format('F j, Y \a\t g:i A') }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-gray-800 mb-2">Customer Information</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Name:</td>
                                        <td>{{ $order->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Email:</td>
                                        <td>{{ $order->customer_email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Phone:</td>
                                        <td>{{ $order->customer_phone }}</td>
                                    </tr>
                                    @if($order->user)
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Account:</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $order->user) }}" class="text-primary">
                                                Registered User
                                            </a>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td class="font-weight-bold text-gray-600">Account:</td>
                                        <td class="text-muted">Guest Order</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Shipping Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Address:</strong></p>
                                <p class="text-gray-800">{{ $order->shipping_address }}</p>
                                <p class="text-gray-800">
                                    {{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', ' . $order->shipping_postal_code : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="10%">Image</th>
                                        <th>Product</th>
                                        <th width="10%">Price</th>
                                        <th width="10%">Qty</th>
                                        <th width="15%">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                         alt="{{ $item->product_name }}" 
                                                         class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-center" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-pills text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">{{ $item->product_name }}</div>
                                                @if($item->product && $item->product->generic)
                                                    <small class="text-muted">{{ $item->product->generic->name }}</small>
                                                @endif
                                                @if($item->product && $item->product->prescription_required)
                                                    <br>
                                                    <span class="badge badge-danger badge-sm">
                                                        <i class="fas fa-prescription"></i> Prescription Required
                                                    </span>
                                                @endif
                                                @if($item->product && $item->product->sku)
                                                    <br>
                                                    <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                @endif
                                            </td>
                                            <td class="text-right">৳{{ number_format($item->product_price, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right font-weight-bold">৳{{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <td colspan="4" class="text-right font-weight-bold">Subtotal:</td>
                                        <td class="text-right font-weight-bold">৳{{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="4" class="text-right font-weight-bold">Shipping:</td>
                                        <td class="text-right font-weight-bold">৳{{ number_format($order->shipping_cost, 2) }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="4" class="text-right font-weight-bold">Tax:</td>
                                        <td class="text-right font-weight-bold">৳{{ number_format($order->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr class="bg-primary text-white">
                                        <td colspan="4" class="text-right font-weight-bold">Total:</td>
                                        <td class="text-right font-weight-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Special Instructions & Notes -->
                @if($order->special_instructions || $order->admin_notes)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Notes & Instructions</h6>
                    </div>
                    <div class="card-body">
                        @if($order->special_instructions)
                            <div class="mb-3">
                                <h6 class="font-weight-bold text-gray-800">Customer Instructions:</h6>
                                <p class="text-gray-800 mb-0">{{ $order->special_instructions }}</p>
                            </div>
                        @endif
                        
                        @if($order->admin_notes)
                            <div>
                                <h6 class="font-weight-bold text-gray-800">Admin Notes:</h6>
                                <p class="text-gray-800 mb-0">{{ $order->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Actions -->
            <div class="col-lg-4">
                <!-- Status Update -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Status</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group">
                                <label for="order_status">Update Status</label>
                                <select name="order_status" id="order_status" class="form-control">
                                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="admin_notes">Admin Notes</label>
                                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" 
                                          placeholder="Add notes about this status change...">{{ $order->admin_notes }}</textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Payment Status</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group">
                                <label for="payment_status">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-control">
                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-credit-card"></i> Update Payment
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Prescription -->
                @if($order->prescription_path)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Prescription</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-prescription fa-3x text-danger"></i>
                        </div>
                        <p class="text-gray-800 mb-3">Customer uploaded prescription</p>
                        <a href="{{ asset('storage/' . $order->prescription_path) }}" 
                           target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt"></i> View Prescription
                        </a>
                    </div>
                </div>
                @endif

                <!-- Order Timeline -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Timeline</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Placed</h6>
                                    <p class="timeline-text">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            
                            @if($order->confirmed_at)
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Confirmed</h6>
                                    <p class="timeline-text">{{ $order->confirmed_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($order->shipped_at)
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Shipped</h6>
                                    <p class="timeline-text">{{ $order->shipped_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($order->delivered_at)
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Delivered</h6>
                                    <p class="timeline-text">{{ $order->delivered_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        @if($order->order_status === 'pending')
                            <button class="btn btn-success btn-sm btn-block mb-2" onclick="quickStatusUpdate('confirmed')">
                                <i class="fas fa-check"></i> Confirm Order
                            </button>
                        @endif
                        
                        @if(in_array($order->order_status, ['confirmed', 'processing']))
                            <button class="btn btn-info btn-sm btn-block mb-2" onclick="quickStatusUpdate('shipped')">
                                <i class="fas fa-truck"></i> Mark as Shipped
                            </button>
                        @endif
                        
                        @if($order->order_status === 'shipped')
                            <button class="btn btn-primary btn-sm btn-block mb-2" onclick="quickStatusUpdate('delivered')">
                                <i class="fas fa-check-circle"></i> Mark as Delivered
                            </button>
                        @endif
                        
                        @if(!in_array($order->order_status, ['delivered', 'cancelled']))
                            <button class="btn btn-danger btn-sm btn-block" onclick="quickStatusUpdate('cancelled')">
                                <i class="fas fa-times"></i> Cancel Order
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -2.25rem;
    top: 1.5rem;
    width: 2px;
    height: calc(100% - 0.5rem);
    background-color: #e3e6f0;
}

.timeline-item.completed:not(:last-child)::before {
    background-color: #1cc88a;
}

.timeline-marker {
    position: absolute;
    left: -2.75rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 2px solid #fff;
    background-color: #e3e6f0;
}

.timeline-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.timeline-text {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 0;
}

.badge-lg {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
function quickStatusUpdate(status) {
    if (confirm(`Are you sure you want to mark this order as ${status}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.orders.update-status", $order) }}';
        
        form.innerHTML = `
            @csrf
            @method('PATCH')
            <input type="hidden" name="order_status" value="${status}">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush