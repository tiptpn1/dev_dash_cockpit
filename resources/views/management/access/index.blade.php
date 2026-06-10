@extends('layouts.app')

@section('title', 'User Feature Access')

@section('content')
    <div class="main-content overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">Manajemen Akses User</h1>
                    <p class="text-gray-600 mt-2">Mengelola dan menetapkan fitur kepada pengguna untuk kontrol akses</p>
                </div>
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
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-100">
                <form method="GET" action="{{ route('management.access.index') }}" class="flex gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" placeholder="Search by username or name..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-900">
                    </div>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('management.access.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm flex items-center">
                            <i class="fas fa-times mr-2"></i> Clear
                        </a>
                    @endif
                    <a href="{{ route('management.access.export', ['search' => request('search')]) }}"
                        class="text-white font-bold py-3 px-6 rounded-lg transition shadow-sm flex items-center ml-auto" style="background-color: #059669;">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </a>
                </form>
            </div>

            <!-- Statistics -->
            <!-- <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                                    <div class="bg-gradient-to-br from-green-600 to-green-700 text-white rounded-lg p-4 shadow-md">
                                        <p class="text-sm font-medium opacity-90">Total Users</p>
                                        <p class="text-3xl font-bold">{{ $users->total() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-lg p-4 shadow-md">
                                        <p class="text-sm font-medium opacity-90">With Features</p>
                                        <p class="text-3xl font-bold">{{ $users->whereNotNull('features')->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-lg p-4 shadow-md">
                                        <p class="text-sm font-medium opacity-90">No Access</p>
                                        <p class="text-3xl font-bold">{{ $users->filter(fn($u) => $u->features->count() === 0)->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-green-800 to-green-900 text-white rounded-lg p-4 shadow-md">
                                        <p class="text-sm font-medium opacity-90">Total Assignments</p>
                                        <p class="text-3xl font-bold">{{ $users->sum(fn($u) => $u->features->count()) }}</p>
                                    </div>
                                </div> -->

            <!-- Users Access Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-green-800 to-green-900 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 60px;">
                                    No.</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Username</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Fitur yang Dibagikan
                                </th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Jumlah Fitur</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 120px;">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-green-50 transition duration-150">
                                    <td class="px-6 py-4 text-gray-700 font-medium">
                                        {{ ($users->currentPage() - 1) * 5 + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $user->username }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->role === 'admin')
                                            <span
                                                class="bg-red-100 text-red-800 px-3 py-1 rounded text-xs font-bold tracking-wide">ADMIN</span>
                                        @elseif($user->role === 'superadmin')
                                            <span
                                                class="bg-purple-100 text-purple-800 px-3 py-1 rounded text-xs font-bold tracking-wide">SUPERADMIN</span>
                                        @elseif($user->role === 'viewer_ho' || $user->role === 'viewer_unit')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-xs font-bold tracking-wide">VIEWER</span>
                                        @else
                                            <span
                                                class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold tracking-wide">{{ $user->role ?? '-' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @if($user->features->count() > 0)
                                                @foreach($user->features->take(4) as $feature)
                                                    <span
                                                        class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-xs font-bold border border-green-200 shadow-sm">
                                                        {{ $feature->slug }}
                                                    </span>
                                                @endforeach
                                                @if($user->features->count() > 4)
                                                    <span
                                                        class="bg-gray-200 text-gray-800 px-2 py-1 rounded-md text-xs font-bold border border-gray-300 shadow-sm">
                                                        +{{ $user->features->count() - 4 }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 italic font-medium">No features assigned</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-bold border border-indigo-200">
                                            {{ $user->features->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <a href="{{ route('management.access.edit', $user) }}"
                                            class="text-green-600 hover:text-green-900 transition flex items-center bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-md">
                                            <i class="fas fa-key mr-1.5"></i> Manage
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                                            <p class="font-semibold text-lg text-gray-600">No users found</p>
                                        </div>
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
                        Menampilkan <span class="font-bold text-green-700">{{ $users->firstItem() ?? 0 }}</span> sampai
                        <span class="font-bold text-green-700">{{ $users->lastItem() ?? 0 }}</span> dari
                        <span class="font-bold text-green-700">{{ $users->total() }}</span> total data
                    </div>
                    <div class="overflow-x-auto w-full md:w-auto custom-pagination">
                        {{ $users->links('pagination::bootstrap-4') }}
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