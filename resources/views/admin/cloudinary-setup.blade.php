@extends('layouts.admin')

@section('title', 'Cloudinary Setup')
@section('header', 'Cloudinary Configuration')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Cloudinary Configuration Status</h3>
        </div>

        <div class="p-6">
            <div class="space-y-6">
                <!-- Configuration Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-3">Environment Variables</h4>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">CLOUDINARY_CLOUD_NAME</span>
                                <span
                                    class="text-sm {{ config('cloudinary.cloud_name') ? 'text-green-600' : 'text-red-600' }}">
                                    {{ config('cloudinary.cloud_name') ? '✓ Set' : '✗ Not Set' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">CLOUDINARY_API_KEY</span>
                                <span
                                    class="text-sm {{ config('cloudinary.api_key') ? 'text-green-600' : 'text-red-600' }}">
                                    {{ config('cloudinary.api_key') ? '✓ Set' : '✗ Not Set' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">CLOUDINARY_API_SECRET</span>
                                <span
                                    class="text-sm {{ config('cloudinary.api_secret') ? 'text-green-600' : 'text-red-600' }}">
                                    {{ config('cloudinary.api_secret') ? '✓ Set' : '✗ Not Set' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-3">Service Status</h4>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">CloudinaryService</span>
                                <span class="text-sm text-green-600">✓ Available</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Category Model</span>
                                <span class="text-sm text-green-600">✓ Updated</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Upload Forms</span>
                                <span class="text-sm text-green-600">✓ Enhanced</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-900 mb-2">Setup Instructions</h4>
                    <div class="text-sm text-blue-800 space-y-2">
                        <p><strong>1. Create a Cloudinary account</strong> at <a href="https://cloudinary.com"
                                target="_blank" class="underline">cloudinary.com</a></p>
                        <p><strong>2. Get your credentials</strong> from your Cloudinary dashboard</p>
                        <p><strong>3. Update your .env file</strong> with the following variables:</p>
                        <div class="bg-blue-100 p-3 rounded mt-2 font-mono text-xs">
                            <div>CLOUDINARY_CLOUD_NAME=your_cloud_name</div>
                            <div>CLOUDINARY_API_KEY=your_api_key</div>
                            <div>CLOUDINARY_API_SECRET=your_api_secret</div>
                            <div>CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name</div>
                        </div>
                        <p><strong>4. Test the upload</strong> by creating or editing a category with an image</p>
                    </div>
                </div>

                <!-- Features -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h4 class="font-medium text-green-900 mb-2">Features Implemented</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h5 class="font-medium text-green-800 mb-1">Image Upload</h5>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Drag & drop upload</li>
                                <li>• Image preview</li>
                                <li>• File validation (5MB, image types)</li>
                                <li>• Automatic Cloudinary upload</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-medium text-green-800 mb-1">Image Management</h5>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Multiple size variants</li>
                                <li>• Automatic optimization</li>
                                <li>• CDN delivery</li>
                                <li>• Old image cleanup</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Test Links -->
                <div class="flex space-x-4">
                    <a href="{{ route('admin.categories.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Test Upload - Create Category
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        View Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
