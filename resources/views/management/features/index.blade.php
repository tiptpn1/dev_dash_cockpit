@extends('layouts.app')

@section('title', 'Feature Management')

@section('content')
    <div class="main-content overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">Feature Management</h1>
                    <p class="text-gray-600 mt-2">Manage system features and capabilities</p>
                </div>
                <a href="{{ route('management.features.create') }}"
                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                    <i class="fas fa-plus"></i> Add New Feature
                </a>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                    <p class="font-bold mb-2">Errors:</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form method="GET" action="{{ route('management.features.index') }}" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Search by slug or name..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-900">
                    </div>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('management.features.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Statistics -->
            <!-- <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg p-4 shadow-md">
                <p class="text-sm opacity-90">Total Features</p>
                <p class="text-3xl font-bold">{{ $features->total() }}</p>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg p-4 shadow-md">
                <p class="text-sm opacity-90">Features Assigned</p>
                <p class="text-3xl font-bold">{{ $features->sum(fn($f) => $f->users->count()) }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg p-4 shadow-md">
                <p class="text-sm opacity-90">Avg Users/Feature</p>
                <p class="text-3xl font-bold">{{ $features->total() > 0 ? round($features->sum(fn($f) => $f->users->count()) / $features->total()) : 0 }}</p>
            </div>
        </div> -->

            <!-- Features Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-green-800 to-green-900 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 60px;">
                                    No.</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Feature Name</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Users Assigned</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 180px;">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($features as $index => $feature)
                                <tr class="border-b hover:bg-green-50 transition">
                                    <td class="px-6 py-4 text-gray-700 font-medium">
                                        {{ ($features->currentPage() - 1) * 5 + $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $feature->slug }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-800 font-medium">{{ $feature->name }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $feature->users->count() }}
                                            users</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($feature->users->count() > 0)
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-check-circle"></i> Active
                                            </span>
                                        @else
                                            <span
                                                class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-exclamation-circle"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $feature->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('management.features.edit', $feature) }}"
                                                class="text-green-600 hover:text-green-900 transition flex items-center bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-md">
                                                <i class="fas fa-edit mr-1.5"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('management.features.destroy', $feature) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition flex items-center bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md"
                                                    onclick="return confirm('Delete {{ $feature->name }}? This will remove it from {{ $feature->users->count() }} user(s).')">
                                                    <i class="fas fa-trash-alt mr-1.5"></i> Del
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3 block opacity-50"></i>
                                        <p class="font-semibold">No features found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600 font-medium">
                        Menampilkan <span class="font-bold text-green-700">{{ $features->firstItem() ?? 0 }}</span> sampai
                        <span class="font-bold text-green-700">{{ $features->lastItem() ?? 0 }}</span> dari
                        <span class="font-bold text-green-700">{{ $features->total() }}</span> total data
                    </div>
                    <div class="overflow-x-auto w-full md:w-auto custom-pagination">
                        {{ $features->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        html,
        body {
            height: auto !important;
            overflow-y: auto !important;
        }

        .container {
            max-width: 1400px;
        }

        /* Custom Pagination Styles */
        .custom-pagination .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            margin: 0;
        }

        .custom-pagination .page-item.disabled .page-link {
            color: #6b7280;
            pointer-events: none;
            background-color: #f3f4f6;
            border-color: #e5e7eb;
        }

        .custom-pagination .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #16a34a;
            border-color: #16a34a;
        }

        .custom-pagination .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #16a34a;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            font-weight: 500;
        }

        .custom-pagination .page-link:hover {
            z-index: 2;
            color: #15803d;
            text-decoration: none;
            background-color: #f0fdf4;
            border-color: #e5e7eb;
        }

        .custom-pagination .page-item:first-child .page-link {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .custom-pagination .page-item:last-child .page-link {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }
    </style>
@endsection