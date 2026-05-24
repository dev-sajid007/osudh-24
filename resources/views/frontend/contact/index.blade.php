@extends('layouts.frontend.app')

@section('title', 'Contact Us - ' . config('app.name'))

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
            <h1 class="text-3xl font-bold">Contact Us</h1>
        </div>
        <p class="mt-4 text-cyan-100 text-lg max-w-2xl">
            Get in touch with us. We're here to help you with any questions or concerns.
        </p>
    </div>
</section>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">

            <div class="lg:col-span-7">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-6 sm:px-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-6">Send us a Message</h2>
                        <form>
                            @csrf
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Your name">
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <div class="mt-1">
                                        <input type="email" name="email" id="email"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="you@example.com">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <div class="mt-1">
                                    <input type="text" name="subject" id="subject"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="How can we help?">
                                </div>
                            </div>
                            <div class="mt-6">
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <div class="mt-1">
                                    <textarea name="message" id="message" rows="5"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Write your message..."></textarea>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full bg-indigo-600 text-white hover:bg-indigo-700 rounded-md shadow-sm py-3 px-4 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 mt-8 lg:mt-0">
                <div class="sticky top-6 space-y-6">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-6 sm:px-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-6">Contact Information</h3>
                            <div class="space-y-5">
                                <div class="flex items-start">
                                    <div class="bg-cyan-100 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">Address</h4>
                                        <p class="mt-1 text-sm text-gray-600">{{ $settings['footer_address'] ?? '123 Health Street, Medical City, MC 12345' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-cyan-100 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">Phone</h4>
                                        <p class="mt-1 text-sm text-gray-600">{{ $settings['footer_phone'] ?? '+1 (555) 123-4567' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-cyan-100 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">Email</h4>
                                        <p class="mt-1 text-sm text-gray-600">{{ $settings['footer_email'] ?? 'info@pharmacare.com' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-cyan-100 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">Working Hours</h4>
                                        <p class="mt-1 text-sm text-gray-600">{{ $settings['footer_support_hours'] ?? '24/7 Customer Support' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
