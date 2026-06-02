@extends('layouts.app')

@section('title', 'Edit Feature')

@section('content')
<div class="main-content overflow-y-auto" style="height: 100vh;">
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Feature: <span class="text-green-700">{{ $feature->slug }}</span></h1>
        <p class="text-gray-600">Update system feature information</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-green-700"></div>
        
        <form method="POST" action="{{ route('management.features.update', $feature) }}">
            @csrf
            @method('PUT')

            <!-- Slug -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="slug">Slug <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-link text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('slug') border-red-500 ring-1 ring-red-500 @enderror"
                        type="text" name="slug" id="slug" value="{{ old('slug', $feature->slug) }}" required>
                </div>
                <p class="text-gray-500 text-xs mt-2 ml-1"><i class="fas fa-info-circle text-blue-400 mr-1"></i>Use lowercase letters, numbers, and hyphens only.</p>
                @error('slug')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">Feature Name <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-cube text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('name') border-red-500 ring-1 ring-red-500 @enderror"
                        type="text" name="name" id="name" value="{{ old('name', $feature->name) }}" required>
                </div>
                @error('name')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8 flex items-start shadow-sm">
                <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3 text-lg"></i>
                <p class="text-blue-800 text-sm"><strong>Note:</strong> This feature is currently assigned to <span class="bg-blue-200 text-blue-900 px-2 py-0.5 rounded font-bold">{{ $feature->users->count() }}</span> user(s).</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4 border-t border-gray-100 mt-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Update Feature
                </button>
                <a href="{{ route('management.features.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-lg transition duration-200 text-center flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
</div>

<style>
    html, body {
        height: auto !important;
        overflow-y: auto !important;
    }
    .container {
        max-width: 1000px;
    }
</style>
@endsection
