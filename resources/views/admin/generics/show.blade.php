@extends('layouts.admin')

@section('title', 'Generic: ' . $generic->name)

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $generic->name }}</h1>
                <p class="text-gray-600">Generic name details and associated products</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.generics.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to List</span>
                </a>
                <a href="{{ route('admin.generics.edit', $generic) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    <span>Edit Generic</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Generic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Name:</strong>
                            <div class="text-muted">{{ $generic->name }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Slug:</strong>
                            <div><code class="text-muted">{{ $generic->slug }}</code></div>
                        </div>

                        <div class="mb-3">
                            <strong>Status:</strong>
                            <div>
                                @if ($generic->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>

                        @if ($generic->description)
                            <div class="mb-3">
                                <strong>Description:</strong>
                                <div class="text-muted">{{ $generic->description }}</div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong>Products Count:</strong>
                            <div>
                                <span class="badge bg-info fs-6">{{ $products->total() }} products</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Created:</strong>
                            <div class="text-muted">{{ $generic->created_at->format('M d, Y \a\t g:i A') }}</div>
                        </div>

                        <div class="mb-0">
                            <strong>Last Updated:</strong>
                            <div class="text-muted">{{ $generic->updated_at->format('M d, Y \a\t g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Associated Products</h6>
                            <span class="badge bg-primary">{{ $products->total() }} Products</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($products->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($product->primary_image_url)
                                                            <img src="{{ $product->primary_image_url }}"
                                                                alt="{{ $product->name }}" class="rounded me-3"
                                                                style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="fas fa-pills text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold">{{ $product->name }}</div>
                                                            @if ($product->dosage || $product->strength)
                                                                <small class="text-muted">
                                                                    {{ $product->dosage }} {{ $product->strength }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $product->brand ?? 'Generic' }}</td>
                                                <td>
                                                    @if ($product->category)
                                                        <span
                                                            class="badge bg-light text-dark">{{ $product->category->name }}</span>
                                                    @else
                                                        <span class="text-muted">No category</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($product->unit_price, 2) }}</strong>
                                                    @if ($product->mrp && $product->mrp > $product->unit_price)
                                                        <br><small
                                                            class="text-muted text-decoration-line-through">${{ number_format($product->mrp, 2) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product->stock_quantity > 0)
                                                        <span
                                                            class="badge bg-success">{{ $product->stock_quantity }}</span>
                                                    @else
                                                        <span class="badge bg-danger">Out of Stock</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product->status === 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ ucfirst($product->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.products.show', $product) }}"
                                                        class="btn btn-sm btn-outline-primary" title="View Product">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                                    {{ $products->total() }} products
                                </div>
                                {{ $products->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-box-open fa-3x text-muted"></i>
                                </div>
                                <h5 class="text-muted">No products found</h5>
                                <p class="text-muted">This generic name has no products associated with it yet.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
        }
    </style>
@endsection
