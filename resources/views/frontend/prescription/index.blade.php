@extends('layouts.frontend.app')

@section('title', 'Prescription - ' . config('app.name'))

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
            <h1 class="text-3xl font-bold">Prescriptions</h1>
        </div>
        <p class="mt-4 text-cyan-100 text-lg max-w-2xl">
            All submitted prescriptions
        </p>
    </div>
</section>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($prescriptions->isEmpty())
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No prescriptions yet</h3>
                <p class="mt-2 text-gray-500">No prescriptions have been submitted yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($prescriptions as $prescription)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-cyan-100 rounded-full p-2">
                                        <svg class="w-6 h-6 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $prescription->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $prescription->phone }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $prescription->created_at->format('d M, Y') }}</span>
                            </div>

                            @if($prescription->email)
                                <p class="text-sm text-gray-600 mb-1">
                                    <span class="font-medium">Email:</span> {{ $prescription->email }}
                                </p>
                            @endif

                            <p class="text-sm text-gray-600 mb-4">
                                <span class="font-medium">Address:</span> {{ $prescription->address }}
                            </p>

                            @if($prescription->notes)
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Notes:</span> {{ $prescription->notes }}
                                    </p>
                                </div>
                            @endif

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-400">ID: #{{ $prescription->id }}</span>
                                @if($prescription->prescription)
                                    <a href="{{ asset('storage/' . $prescription->prescription) }}" target="_blank"
                                        class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        View File
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
