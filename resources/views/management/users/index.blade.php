@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="main-content overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">User Management</h1>
                    <p class="text-gray-600 mt-2">Manage all system users and their information</p>
                </div>
                <a href="{{ route('management.users.create') }}"
                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                    <i class="fas fa-plus"></i> Add New User
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
                <form method="GET" action="{{ route('management.users.index') }}" class="flex gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" placeholder="Search by username or NIK..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('management.users.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm flex items-center">
                            <i class="fas fa-times mr-2"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-green-800 to-green-900 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 60px;">
                                    No.</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Username</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Plant</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 180px;">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-green-50 transition duration-150">
                                    <td class="px-6 py-4 text-gray-700 font-medium">
                                        {{ ($users->currentPage() - 1) * 5 + $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $user->username }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 font-medium">{{ $user->nik ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($user->plant)
                                            <span
                                                class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-md text-sm font-semibold border border-indigo-200">{{ $user->plant }}</span>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
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
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('management.users.edit', $user) }}"
                                                class="text-green-600 hover:text-green-900 transition flex items-center bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-md">
                                                <i class="fas fa-edit mr-1.5"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('management.users.destroy', $user) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition flex items-center bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md"
                                                    onclick="return confirm('Yakin ingin menghapus user {{ $user->username }}?');">
                                                    <i class="fas fa-trash-alt mr-1.5"></i> Del
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
                                            <p class="font-semibold text-lg text-gray-600">Belum ada data user</p>
                                            <p class="text-sm text-gray-400 mt-1">Silakan tambahkan user baru</p>
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

        /* Custom Pagination Styles to ensure Next/Prev show up */
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