@extends('layouts.app')

@section('title', 'Last Login Management')

@section('content')
    <div class="main-content overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">Last Login User</h1>
                    <p class="text-gray-600 mt-2">Pemantauan Riwayat Waktu Login Terakhir Akun Pengguna</p>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form method="GET" action="{{ route('management.lastlogin.index') }}" class="flex gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" placeholder="Cari berdasarkan Username, NIK, atau Role..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-900">
                    </div>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('management.lastlogin.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm flex items-center">
                            <i class="fas fa-times mr-2"></i> Clear
                        </a>
                    @endif
                    <a href="{{ route('management.lastlogin.export', ['search' => request('search')]) }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm flex items-center ml-auto">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </a>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-green-800 to-green-900 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 60px;">No.</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Username</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Waktu Login Terakhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-green-50 transition duration-150">
                                    <td class="px-6 py-4 text-gray-700 font-medium">
                                        {{ ($users->currentPage() - 1) * 10 + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold shadow-sm">{{ $user->username }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 font-medium">{{ $user->nik ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($user->role === 'admin')
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded text-xs font-bold tracking-wide">ADMIN</span>
                                        @elseif($user->role === 'superadmin')
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded text-xs font-bold tracking-wide">SUPERADMIN</span>
                                        @elseif($user->role === 'viewer_ho' || $user->role === 'viewer_unit')
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-xs font-bold tracking-wide">VIEWER</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold tracking-wide">{{ strtoupper($user->role ?? '-') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 font-medium">
                                        @if($user->last_login_at)
                                            {{ $user->last_login_at->format('d M Y H:i:s') }}
                                            <span class="text-xs text-gray-400 ml-2">({{ $user->last_login_at->diffForHumans() }})</span>
                                        @else
                                            <span class="text-gray-400 italic">Belum pernah login</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-history text-5xl mb-4 text-gray-300"></i>
                                            <p class="font-semibold text-lg text-gray-600">Belum ada riwayat login</p>
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
