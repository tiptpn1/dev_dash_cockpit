@extends('layouts.app')

@section('title', 'Create Feature')

@section('content')
<div class="main-content overflow-y-auto" style="height: 100vh;">
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Add New Feature</h1>
        <p class="text-gray-600">Create a new system feature</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-green-700"></div>
        
        <form method="POST" action="{{ route('management.features.store') }}">
            @csrf

            <!-- Slug -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="slug">Slug <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-link text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('slug') border-red-500 ring-1 ring-red-500 @enderror"
                        type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="e.g., mrc, finansial, gis" required>
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
                        type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g., Monthly Report Cycle" required>
                </div>
                @error('name')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Parent Feature -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="parent_id">Parent Feature (Menu Induk)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-folder text-green-600 opacity-70"></i>
                    </div>
                    <select class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200"
                        name="parent_id" id="parent_id">
                        <option value="">-- None (Top Level Menu) --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }} ({{ $parent->slug }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('parent_id')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- URL -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="url">URL Path / Tautan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-globe text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('url') border-red-500 ring-1 ring-red-500 @enderror"
                        type="text" name="url" id="url" value="{{ old('url') }}" placeholder="e.g., /mrc or https://...">
                </div>
                @error('url')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Icon -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="icon">Icon Class (FontAwesome)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-icons text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('icon') border-red-500 ring-1 ring-red-500 @enderror"
                        type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="e.g., fa-solid fa-cube">
                </div>
                @error('icon')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Sort Order -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="sort_order">Sort Order <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-sort-numeric-down text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('sort_order') border-red-500 ring-1 ring-red-500 @enderror"
                        type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', '0') }}" required>
                </div>
                @error('sort_order')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Toggle Flags -->
            <div class="grid grid-cols-2 gap-6 mb-8">
                <!-- Is Sidebar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="is_sidebar">Show in Sidebar? <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-bars text-green-600 opacity-70"></i>
                        </div>
                        <select class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200"
                            name="is_sidebar" id="is_sidebar">
                            <option value="1" {{ old('is_sidebar', '1') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_sidebar', '1') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <!-- Is Active -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="is_active">Status <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-toggle-on text-green-600 opacity-70"></i>
                        </div>
                        <select class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200"
                            name="is_active" id="is_active">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', '1') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4 border-t border-gray-100 mt-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Save Feature
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
