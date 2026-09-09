@extends('layouts.app')

@section('title', 'Feature Management (Backup View)')

@section('content')
    <div class="main-content overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">Management Fitur (Tabel Lama)</h1>
                    <p class="text-gray-600 mt-2">Pengelolaan Fitur dan Kapabilitas</p>
                </div>
                <a href="{{ route('management.features.create') }}"
                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                    <i class="fas fa-plus"></i> Tambah Fitur Baru
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
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('management.features.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition">
                            Clear
                        </a>
                    @endif
                    <a href="{{ route('management.features.export', ['search' => request('search')]) }}"
                        class="text-white font-bold py-2 px-6 rounded-lg transition shadow-sm flex items-center ml-auto" style="background-color: #059669;">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </a>
                </form>
            </div>

            <!-- Features Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-green-800 to-green-900 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 60px;">
                                    No.</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Nama Fitur</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 180px;">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($features as $index => $feature)
                                <tr class="border-b hover:bg-green-50 transition">
                                    <td class="px-6 py-4 text-gray-700 font-medium">
                                        {{ method_exists($features, 'currentPage') ? ($features->currentPage() - 1) * $features->perPage() + $index + 1 : $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $feature->slug }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-800 font-medium">{{ $feature->name }}</td>
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
                                                    onclick="return confirm('Delete {{ $feature->name }}?')">
                                                    <i class="fas fa-trash-alt mr-1.5"></i> Del
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3 block opacity-50"></i>
                                        <p class="font-semibold">No features found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($features, 'links'))
                    <div class="p-4 bg-gray-50 border-t">
                        {{ $features->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        html, body {
            height: auto !important;
            overflow-y: auto !important;
        }
    </style>
@endsection
