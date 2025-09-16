@extends('layouts.admin')

@section('title', 'Edit Generic: ' . $generic->name)

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Generic Name</h1>
                <p class="text-gray-600">Update pharmaceutical generic name information</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.generics.show', $generic) }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Details</span>
                </a>
                <a href="{{ route('admin.generics.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span>All Generics</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Generic Information</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.generics.update', $generic) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Generic Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $generic->name) }}"
                                    placeholder="e.g., Paracetamol, Ibuprofen, Amoxicillin" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Enter the generic/scientific name of the medication</div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Brief description of the generic medication, its uses, or therapeutic category">{{ old('description', $generic->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Optional: Add a description about this generic medication</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $generic->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Status
                                    </label>
                                </div>
                                <div class="form-text">Active generics will be available for product assignment</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.generics.show', $generic) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Generic
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-info-circle"></i> Current Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Current Slug:</strong>
                            <div><code class="text-muted">{{ $generic->slug }}</code></div>
                            <small class="text-muted">Will be auto-updated when name changes</small>
                        </div>

                        <div class="mb-3">
                            <strong>Associated Products:</strong>
                            <div>
                                <span
                                    class="badge bg-info fs-6">{{ $generic->products_count ?? $generic->products()->count() }}
                                    products</span>
                            </div>
                            @if ($generic->products()->count() > 0)
                                <small class="text-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Products are using this generic name
                                </small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <strong>Created:</strong>
                            <div class="text-muted">{{ $generic->created_at->format('M d, Y') }}</div>
                        </div>

                        <div class="mb-0">
                            <strong>Last Updated:</strong>
                            <div class="text-muted">{{ $generic->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                @if ($generic->products()->count() > 0)
                    <div class="card shadow mt-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-exclamation-triangle"></i> Important Note
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-2">
                                This generic name is currently associated with {{ $generic->products()->count() }}
                                product(s).
                            </p>
                            <p class="small text-muted mb-0">
                                Changes to the name will affect how these products are grouped and displayed.
                            </p>
                        </div>
                    </div>
                @endif

                <div class="card shadow mt-3">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">
                            <i class="fas fa-trash"></i> Delete Generic
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($generic->products()->count() == 0)
                            <p class="small text-muted mb-3">
                                This generic has no associated products and can be safely deleted.
                            </p>
                            <form method="POST" action="{{ route('admin.generics.destroy', $generic) }}"
                                onsubmit="return confirm('Are you sure you want to delete this generic? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete Generic
                                </button>
                            </form>
                        @else
                            <p class="small text-muted mb-0">
                                Cannot delete this generic because it has {{ $generic->products()->count() }} associated
                                product(s).
                                Remove all products first to enable deletion.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
        });
    </script>
@endsection
