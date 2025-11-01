@extends('layouts.admin')

@section('title', 'Order Management')

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
                <h1 class="h3 mb-0 text-gray-800">Order Management</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.export', request()->query()) }}" 
                   class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_orders']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['pending_orders']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Revenue</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">৳{{ number_format($stats['total_revenue'], 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Today's Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['todays_orders']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders.index') }}" id="filter-form">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Order number, customer name, email...">
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="status" class="form-label">Order Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select class="form-control" id="payment_status" name="payment_status">
                                <option value="">All Payments</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>

                        <div class="col-md-1 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Orders List</h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleBulkActions()">
                        <i class="fas fa-tasks"></i> Bulk Actions
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Bulk Actions -->
                <div id="bulk-actions" class="alert alert-info" style="display: none;">
                    <form action="{{ route('admin.orders.bulk-update') }}" method="POST" id="bulk-form">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <select name="action" class="form-control" required>
                                    <option value="">Select Action</option>
                                    <option value="confirm">Mark as Confirmed</option>
                                    <option value="ship">Mark as Shipped</option>
                                    <option value="deliver">Mark as Delivered</option>
                                    <option value="cancel">Mark as Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-warning">Apply to Selected</button>
                                <button type="button" class="btn btn-secondary" onclick="toggleBulkActions()">Cancel</button>
                            </div>
                            <div class="col-md-4 text-right">
                                <small class="text-muted">Selected: <span id="selected-count">0</span> orders</small>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-primary font-weight-bold">
                                            {{ $order->order_number }}
                                        </a>
                                        @if($order->prescription_path)
                                            <i class="fas fa-prescription text-danger ml-1" title="Prescription Required"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $order->customer_name }}</div>
                                        <small class="text-muted">{{ $order->customer_email }}</small><br>
                                        <small class="text-muted">{{ $order->customer_phone }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $order->statusBadgeColor }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $order->paymentStatusBadgeColor }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $order->paymentMethodDisplay }}</small>
                                    </td>
                                    <td class="font-weight-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <div>{{ $order->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        data-toggle="dropdown" title="Quick Actions">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <h6 class="dropdown-header">Update Status</h6>
                                                    @if($order->order_status !== 'confirmed')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'confirmed')">
                                                            <i class="fas fa-check text-primary"></i> Confirm Order
                                                        </a>
                                                    @endif
                                                    @if($order->order_status !== 'shipped')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'shipped')">
                                                            <i class="fas fa-truck text-info"></i> Mark as Shipped
                                                        </a>
                                                    @endif
                                                    @if($order->order_status !== 'delivered')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'delivered')">
                                                            <i class="fas fa-check-circle text-success"></i> Mark as Delivered
                                                        </a>
                                                    @endif
                                                    @if($order->order_status !== 'cancelled')
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="#" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')">
                                                            <i class="fas fa-times"></i> Cancel Order
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                            <h5>No orders found</h5>
                                            <p>No orders match your current filters.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Status Update Modal -->
    <div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="status-update-form" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Update Order Status</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="order_status" id="new-status">
                        <p>Are you sure you want to update this order status to <strong id="status-text"></strong>?</p>
                        <div class="form-group">
                            <label for="admin_notes">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" 
                                      placeholder="Add any notes about this status change..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function updateOrderStatus(orderId, status) {
    const form = document.getElementById('status-update-form');
    form.action = `/admin/orders/${orderId}/status`;
    document.getElementById('new-status').value = status;
    document.getElementById('status-text').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    $('#statusUpdateModal').modal('show');
}

function toggleBulkActions() {
    const bulkDiv = document.getElementById('bulk-actions');
    if (bulkDiv.style.display === 'none') {
        bulkDiv.style.display = 'block';
    } else {
        bulkDiv.style.display = 'none';
        // Uncheck all checkboxes
        document.getElementById('select-all').checked = false;
        document.querySelectorAll('.order-checkbox').forEach(cb => cb.checked = false);
        updateSelectedCount();
    }
}

document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateSelectedCount();
});

document.querySelectorAll('.order-checkbox').forEach(cb => {
    cb.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const selected = document.querySelectorAll('.order-checkbox:checked').length;
    document.getElementById('selected-count').textContent = selected;
    
    // Update hidden inputs for bulk form
    const form = document.getElementById('bulk-form');
    const existingInputs = form.querySelectorAll('input[name="order_ids[]"]');
    existingInputs.forEach(input => input.remove());
    
    document.querySelectorAll('.order-checkbox:checked').forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'order_ids[]';
        input.value = cb.value;
        form.appendChild(input);
    });
}

// Auto-submit filter form on change
document.querySelectorAll('#filter-form select').forEach(select => {
    select.addEventListener('change', () => {
        document.getElementById('filter-form').submit();
    });
});
</script>
@endpush