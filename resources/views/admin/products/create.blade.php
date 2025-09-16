@extends('layouts.admin')

@section('title', 'Create Product')
@section('header', 'Create Product')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Product Information</h3>
            </div>

            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>



                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Leave empty to auto-generate">
                    </div>

                    <div>
                        <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="form" class="block text-sm font-medium text-gray-700">Form</label>
                        <select name="form" id="form"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Form</option>
                            <option value="tablet" {{ old('form') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="capsule" {{ old('form') == 'capsule' ? 'selected' : '' }}>Capsule</option>
                            <option value="syrup" {{ old('form') == 'syrup' ? 'selected' : '' }}>Syrup</option>
                            <option value="injection" {{ old('form') == 'injection' ? 'selected' : '' }}>Injection</option>
                            <option value="cream" {{ old('form') == 'cream' ? 'selected' : '' }}>Cream</option>
                            <option value="drops" {{ old('form') == 'drops' ? 'selected' : '' }}>Drops</option>
                            <option value="powder" {{ old('form') == 'powder' ? 'selected' : '' }}>Powder</option>
                        </select>
                    </div>
                </div>

                <!-- Medical Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="dosage" class="block text-sm font-medium text-gray-700">Dosage</label>
                        <input type="text" name="dosage" id="dosage" value="{{ old('dosage') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., 500mg">
                    </div>

                    <div>
                        <label for="strength" class="block text-sm font-medium text-gray-700">Strength</label>
                        <input type="text" name="strength" id="strength" value="{{ old('strength') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="package_size" class="block text-sm font-medium text-gray-700">Package Size</label>
                        <input type="text" name="package_size" id="package_size" value="{{ old('package_size') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., 10 tablets">
                    </div>
                </div>

                <!-- Category, Generic, and Supplier -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="generic_id" class="block text-sm font-medium text-gray-700">Generic Name</label>
                        <select name="generic_id" id="generic_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Generic</option>
                            @foreach ($generics as $generic)
                                <option value="{{ $generic->id }}"
                                    {{ old('generic_id') == $generic->id ? 'selected' : '' }}>
                                    {{ $generic->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            Don't see your generic?
                            <a href="{{ route('admin.generics.create') }}" target="_blank"
                                class="text-blue-600 hover:text-blue-800">Add new generic</a>
                        </p>
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                        <select name="supplier_id" id="supplier_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price *</label>
                        <input type="number" step="0.01" name="unit_price" id="unit_price"
                            value="{{ old('unit_price') }}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="mrp" class="block text-sm font-medium text-gray-700">MRP *</label>
                        <input type="number" step="0.01" name="mrp" id="mrp" value="{{ old('mrp') }}"
                            required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="discount"
                            id="discount" value="{{ old('discount', 0) }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="tax_rate" class="block text-sm font-medium text-gray-700">Tax Rate (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="tax_rate"
                            id="tax_rate" value="{{ old('tax_rate', 0) }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Stock Management -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity
                            *</label>
                        <input type="number" min="0" name="stock_quantity" id="stock_quantity"
                            value="{{ old('stock_quantity', 0) }}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="minimum_stock" class="block text-sm font-medium text-gray-700">Minimum Stock</label>
                        <input type="number" min="0" name="minimum_stock" id="minimum_stock"
                            value="{{ old('minimum_stock', 0) }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="maximum_stock" class="block text-sm font-medium text-gray-700">Maximum Stock</label>
                        <input type="number" min="0" name="maximum_stock" id="maximum_stock"
                            value="{{ old('maximum_stock', 0) }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                        <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Description and Instructions -->
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="usage_instructions" class="block text-sm font-medium text-gray-700">Usage
                            Instructions</label>
                        <textarea name="usage_instructions" id="usage_instructions" rows="2"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('usage_instructions') }}</textarea>
                    </div>

                    <div>
                        <label for="side_effects" class="block text-sm font-medium text-gray-700">Side Effects</label>
                        <textarea name="side_effects" id="side_effects" rows="2"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('side_effects') }}</textarea>
                    </div>

                    <div>
                        <label for="storage_instructions" class="block text-sm font-medium text-gray-700">Storage
                            Instructions</label>
                        <textarea name="storage_instructions" id="storage_instructions" rows="2"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('storage_instructions') }}</textarea>
                    </div>
                </div>

                <!-- Images and Tags -->
                <div class="space-y-6">
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-4">Product Images</label>

                        <!-- Image Previews Container -->
                        <div id="image-previews" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 empty:hidden">
                            <!-- Dynamic image previews will be added here -->
                        </div>

                        <!-- Upload Area -->
                        <div id="upload-area"
                            class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="images"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload files</span>
                                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                                            class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP up to 5MB each (Multiple files
                                    allowed)</p>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Images will be uploaded to Cloudinary with automatic
                            optimization</p>
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                        <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Comma separated tags">
                    </div>
                </div>

                <!-- Options -->
                <div class="flex items-center space-x-8">
                    <div class="flex items-center">
                        <input type="checkbox" name="prescription_required" id="prescription_required" value="1"
                            {{ old('prescription_required') ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="prescription_required" class="ml-2 block text-sm text-gray-900">
                            Prescription Required
                        </label>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued
                        </option>
                    </select>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Create Product
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Enhanced multiple image preview functionality for products
            const imageInput = document.getElementById('images');
            const imagePreviewsContainer = document.getElementById('image-previews');
            const uploadArea = document.getElementById('upload-area');
            let selectedFiles = [];

            imageInput.addEventListener('change', function(e) {
                handleFiles(e.target.files);
            });

            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                    if (!allowedTypes.includes(file.type)) {
                        alert(`${file.name}: Please select a valid image file (JPEG, PNG, GIF, WebP)`);
                        return;
                    }

                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert(`${file.name}: File size must be less than 5MB`);
                        return;
                    }

                    // Add file to selected files
                    selectedFiles.push(file);

                    // Create preview
                    createImagePreview(file, selectedFiles.length - 1);
                });

                // Update file input
                updateFileInput();

                // Show/hide upload area
                updateUploadAreaVisibility();
            }

            function createImagePreview(file, index) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.createElement('div');
                    previewContainer.className = 'relative group';
                    previewContainer.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" 
                            class="w-full h-24 object-cover rounded-lg border-2 border-gray-300">
                        <button type="button" onclick="removeImage(${index})" 
                            class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                            ×
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-lg">
                            <div class="flex items-center justify-center space-x-1">
                                <svg class="w-3 h-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Cloudinary</span>
                            </div>
                        </div>
                    `;
                    imagePreviewsContainer.appendChild(previewContainer);
                };
                reader.readAsDataURL(file);
            }

            function removeImage(index) {
                // Remove from selected files
                selectedFiles.splice(index, 1);

                // Clear and rebuild previews
                imagePreviewsContainer.innerHTML = '';
                selectedFiles.forEach((file, i) => {
                    createImagePreview(file, i);
                });

                // Update file input
                updateFileInput();

                // Update upload area visibility
                updateUploadAreaVisibility();
            }

            function updateFileInput() {
                // Create new FileList from selected files
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                imageInput.files = dt.files;
            }

            function updateUploadAreaVisibility() {
                if (selectedFiles.length > 0) {
                    imagePreviewsContainer.classList.remove('empty:hidden');
                    uploadArea.classList.add('border-dashed');
                    uploadArea.classList.remove('border-solid');
                } else {
                    imagePreviewsContainer.classList.add('empty:hidden');
                }
            }

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-blue-400', 'bg-blue-50');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFiles(files);
                }
            });

            // Dynamic Form Features

            // 1. Auto-generate SKU from product name and form
            function generateSKU() {
                const name = document.getElementById('name').value;
                const form = document.getElementById('form').value;
                const skuField = document.getElementById('sku');

                if (!skuField.value && name) {
                    let formPrefix = form ? form.substring(0, 3).toUpperCase() : 'PRD';
                    const namePrefix = name.toUpperCase()
                        .replace(/[^A-Z0-9]/g, '')
                        .substring(0, 6);
                    const randomSuffix = Math.random().toString(36).substring(2, 6).toUpperCase();

                    const sku = `${formPrefix}-${namePrefix}-${randomSuffix}`;
                    skuField.value = sku;
                }
            }

            // 2. Dynamic form sections based on form type
            function updateFormSections() {
                const formType = document.getElementById('form').value;
                const dosageField = document.getElementById('dosage').closest('div');
                const strengthField = document.getElementById('strength').closest('div');
                const packageSizeField = document.getElementById('package_size').closest('div');

                // Reset all fields visibility
                [dosageField, strengthField, packageSizeField].forEach(field => {
                    field.style.display = 'block';
                });

                switch (formType) {
                    case 'syrup':
                        document.getElementById('dosage').placeholder = 'e.g., 5ml, 10ml';
                        document.getElementById('strength').placeholder = 'e.g., 125mg/5ml';
                        document.getElementById('package_size').placeholder = 'e.g., 100ml bottle';
                        break;
                    case 'injection':
                        document.getElementById('dosage').placeholder = 'e.g., 1ml, 2ml';
                        document.getElementById('strength').placeholder = 'e.g., 50mg/ml';
                        document.getElementById('package_size').placeholder = 'e.g., 10 vials';
                        break;
                    case 'cream':
                        document.getElementById('dosage').placeholder = 'e.g., apply thin layer';
                        document.getElementById('strength').placeholder = 'e.g., 1% w/w';
                        document.getElementById('package_size').placeholder = 'e.g., 30g tube';
                        break;
                    case 'drops':
                        document.getElementById('dosage').placeholder = 'e.g., 2-3 drops';
                        document.getElementById('strength').placeholder = 'e.g., 10mg/ml';
                        document.getElementById('package_size').placeholder = 'e.g., 10ml bottle';
                        break;
                    default: // tablets, capsules
                        document.getElementById('dosage').placeholder = 'e.g., 1 tablet, 2 capsules';
                        document.getElementById('strength').placeholder = 'e.g., 500mg, 250mg';
                        document.getElementById('package_size').placeholder = 'e.g., 10 tablets';
                }
            }

            // 3. Auto-calculate final price
            function calculateFinalPrice() {
                const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
                const discount = parseFloat(document.getElementById('discount').value) || 0;

                if (unitPrice > 0) {
                    const discountAmount = (unitPrice * discount) / 100;
                    const finalPrice = unitPrice - discountAmount;

                    // Update MRP if not set
                    const mrpField = document.getElementById('mrp');
                    if (!mrpField.value || parseFloat(mrpField.value) < finalPrice) {
                        mrpField.value = (finalPrice * 1.1).toFixed(2); // 10% markup
                    }

                    // Show calculated values
                    showPriceCalculation(unitPrice, discount, discountAmount, finalPrice);
                }
            }

            function showPriceCalculation(unitPrice, discount, discountAmount, finalPrice) {
                let calculationDiv = document.getElementById('price-calculation');
                if (!calculationDiv) {
                    calculationDiv = document.createElement('div');
                    calculationDiv.id = 'price-calculation';
                    calculationDiv.className = 'mt-2 p-3 bg-blue-50 rounded-lg text-sm';
                    document.getElementById('discount').closest('div').appendChild(calculationDiv);
                }

                calculationDiv.innerHTML = `
                    <div class="text-blue-800">
                        <div class="font-medium">Price Calculation:</div>
                        <div>Unit Price: ₹${unitPrice.toFixed(2)}</div>
                        <div>Discount (${discount}%): -₹${discountAmount.toFixed(2)}</div>
                        <div class="font-medium border-t pt-1">Final Price: ₹${finalPrice.toFixed(2)}</div>
                    </div>
                `;
            }

            // 4. Generic-based suggestions
            function setupGenericSuggestions() {
                const genericSelect = document.getElementById('generic_id');
                const nameField = document.getElementById('name');

                genericSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value && !nameField.value) {
                        // Suggest product name based on generic
                        nameField.placeholder = `e.g., ${selectedOption.text} 500mg Tablets`;
                    }
                });
            }

            // 5. Smart form validation
            function setupSmartValidation() {
                const form = document.querySelector('form');
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    field.addEventListener('blur', function() {
                        validateField(this);
                    });
                });
            }

            function validateField(field) {
                const value = field.value.trim();
                let isValid = true;
                let message = '';

                switch (field.name) {
                    case 'unit_price':
                    case 'mrp':
                        if (value && parseFloat(value) <= 0) {
                            isValid = false;
                            message = 'Price must be greater than 0';
                        }
                        break;
                    case 'stock_quantity':
                        if (value && parseInt(value) < 0) {
                            isValid = false;
                            message = 'Stock quantity cannot be negative';
                        }
                        break;
                    case 'expiry_date':
                        if (value && new Date(value) <= new Date()) {
                            isValid = false;
                            message = 'Expiry date must be in the future';
                        }
                        break;
                }

                showFieldValidation(field, isValid, message);
            }

            function showFieldValidation(field, isValid, message) {
                // Remove existing validation message
                const existingMessage = field.parentNode.querySelector('.validation-message');
                if (existingMessage) {
                    existingMessage.remove();
                }

                if (!isValid && message) {
                    field.classList.add('border-red-300');
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'validation-message text-red-600 text-xs mt-1';
                    messageDiv.textContent = message;
                    field.parentNode.appendChild(messageDiv);
                } else {
                    field.classList.remove('border-red-300');
                    field.classList.add('border-green-300');
                }
            }

            // Event Listeners
            document.getElementById('name').addEventListener('input', generateSKU);
            document.getElementById('form').addEventListener('change', function() {
                generateSKU();
                updateFormSections();
            });
            document.getElementById('unit_price').addEventListener('input', calculateFinalPrice);
            document.getElementById('discount').addEventListener('input', calculateFinalPrice);

            // Initialize dynamic features
            document.addEventListener('DOMContentLoaded', function() {
                updateFormSections();
                setupGenericSuggestions();
                setupSmartValidation();
            });

            // Make removeImage function global
            window.removeImage = removeImage;
        </script>
    @endpush
@endsection
