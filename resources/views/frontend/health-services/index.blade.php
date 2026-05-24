@extends('layouts.frontend.app')

@section('title', 'Health Services - ' . config('app.name'))

@section('content')

<section class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="flex items-center text-cyan-200 hover:text-white transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Home
            </a>
            <div class="border-l border-cyan-400 h-6"></div>
            <h1 class="text-3xl font-bold">Health Services</h1>
        </div>
        <p class="mt-4 text-cyan-100 text-lg max-w-2xl">
            Comprehensive healthcare services designed for your well-being. From online consultations to lab tests, we've got you covered.
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">What We Offer</h2>
            <p class="mt-4 text-gray-600 text-lg max-w-2xl mx-auto">
                A complete range of healthcare services at your fingertips
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- Online Consultation --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-8">
                    <div class="bg-cyan-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="video" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Online Consultation</h3>
                    <p class="text-gray-600 mb-4">
                        Consult with certified doctors from the comfort of your home. Secure video calls, chat, and quick prescriptions.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Verified doctors
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Quick appointment booking
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            E-prescriptions
                        </li>
                    </ul>
                    <button class="w-full bg-cyan-600 text-white hover:bg-cyan-700 rounded-lg px-4 py-2 font-medium transition-colors">
                        Book Now
                    </button>
                </div>
            </div>

            {{-- Lab Tests --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-8">
                    <div class="bg-cyan-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="test-tube" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Lab Tests</h3>
                    <p class="text-gray-600 mb-4">
                        Book lab tests from certified diagnostic centers. Get accurate results delivered digitally to your phone or email.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            500+ test packages
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Home sample collection
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Digital reports
                        </li>
                    </ul>
                    <button class="w-full bg-cyan-600 text-white hover:bg-cyan-700 rounded-lg px-4 py-2 font-medium transition-colors">
                        Browse Tests
                    </button>
                </div>
            </div>

            {{-- Prescription Upload --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-8">
                    <div class="bg-cyan-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="upload" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Prescription Upload</h3>
                    <p class="text-gray-600 mb-4">
                        Upload your doctor's prescription and we'll prepare your medicines. Fast processing and doorstep delivery.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Quick upload process
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Pharmacy verification
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Free delivery
                        </li>
                    </ul>
                    <a href="{{ route('prescription.index') }}" class="block w-full bg-cyan-600 text-white hover:bg-cyan-700 rounded-lg px-4 py-2 font-medium transition-colors text-center">
                        Upload Now
                    </a>
                </div>
            </div>

            {{-- Medicine Delivery --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-8">
                    <div class="bg-cyan-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="truck" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Medicine Delivery</h3>
                    <p class="text-gray-600 mb-4">
                        Order medicines online and get them delivered to your doorstep. Safe packaging and timely delivery guaranteed.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Wide range of medicines
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Same-day delivery
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Free delivery on orders over ৳500
                        </li>
                    </ul>
                    <a href="{{ route('products.index') }}" class="block w-full bg-cyan-600 text-white hover:bg-cyan-700 rounded-lg px-4 py-2 font-medium transition-colors text-center">
                        Order Now
                    </a>
                </div>
            </div>

            {{-- Health Checkups --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-8">
                    <div class="bg-cyan-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="heart-pulse" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Health Checkups</h3>
                    <p class="text-gray-600 mb-4">
                        Comprehensive health checkup packages designed for every age group. Early detection for a healthier life.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Basic to advanced packages
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Certified labs
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Discounted rates
                        </li>
                    </ul>
                    <button class="w-full bg-cyan-600 text-white hover:bg-cyan-700 rounded-lg px-4 py-2 font-medium transition-colors">
                        View Packages
                    </button>
                </div>
            </div>

            {{-- Health Blog --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-8">
                    <div class="bg-cyan-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="newspaper" class="w-8 h-8 text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Health Blog</h3>
                    <p class="text-gray-600 mb-4">
                        Stay informed with expert-written articles on health, wellness, medicine, and lifestyle tips.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Expert health tips
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Medicine guides
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Wellness advice
                        </li>
                    </ul>
                    <button class="w-full bg-cyan-600 text-white hover:bg-cyan-700 rounded-lg px-4 py-2 font-medium transition-colors">
                        Read Articles
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="py-16 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Why Choose Osudh24?</h2>
            <p class="mt-4 text-gray-600 text-lg max-w-2xl mx-auto">
                We're committed to making healthcare accessible and convenient for everyone
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="shield-check" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Trusted & Verified</h3>
                <p class="text-gray-600 text-sm">Licensed pharmacy with verified healthcare professionals</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="zap" class="w-8 h-8 text-blue-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Fast & Reliable</h3>
                <p class="text-gray-600 text-sm">Same-day delivery and quick service processing</p>
            </div>
            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="clock" class="w-8 h-8 text-purple-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-600 text-sm">Round-the-clock customer service for all your needs</p>
            </div>
            <div class="text-center">
                <div class="bg-cyan-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="wallet" class="w-8 h-8 text-cyan-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Affordable Prices</h3>
                <p class="text-gray-600 text-sm">Competitive prices and regular discounts on all services</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="bg-gradient-to-r from-cyan-600 to-cyan-800 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
        <p class="text-cyan-100 text-lg mb-8 max-w-2xl mx-auto">
            Experience the convenience of online healthcare. Your health is our priority.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('products.index') }}"
                class="bg-white text-cyan-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Browse Medicines
            </a>
            <a href="{{ route('prescription.index') }}"
                class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-cyan-600 transition-colors">
                Upload Prescription
            </a>
        </div>
    </div>
</section>

@endsection
