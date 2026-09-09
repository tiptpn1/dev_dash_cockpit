@extends('layouts.app')

@section('title', 'User Management')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .user-mgmt-scope {
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        letter-spacing: -0.011em;
    }
    .user-mgmt-scope i,
    .user-mgmt-scope .fas,
    .user-mgmt-scope .far,
    .user-mgmt-scope .fab,
    .user-mgmt-scope .fa,
    .user-mgmt-scope [class*="fa-"] {
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
    }
</style>
@endsection

@section('content')
    <div class="main-content user-mgmt-scope overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-6" style="max-width: 1280px;">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2" style="letter-spacing: -0.02em;">
                        <i class="fas fa-users text-green-600"></i> Manajemen User
                    </h1>
                    <p class="text-gray-500 text-xs mt-0.5 font-normal">Pengelolaan akun dan informasi pengguna sistem.</p>
                </div>
                <a href="{{ route('management.users.create') }}"
                    class="font-semibold py-1.5 px-3.5 rounded-lg shadow-sm transition flex items-center gap-1.5 text-xs"
                    style="background-color: #166534; color: #ffffff;">
                    <i class="fas fa-plus"></i> Tambah User Baru
                </a>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="p-3 mb-4 rounded-lg shadow-sm text-xs" style="background-color: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b;">
                    <p class="font-semibold mb-1">Errors:</p>
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="p-3 mb-4 rounded-lg shadow-sm flex items-center justify-between text-xs" style="background-color: #f0fdf4; border-left: 4px solid #22c55e; color: #166534;">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-sm" style="color: #16a34a;"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 mb-4">
                <form method="GET" action="{{ route('management.users.index') }}" class="flex flex-col md:flex-row gap-2 items-center justify-between">
                    <div class="flex-1 relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </span>
                        <input type="text" name="search" placeholder="Cari username atau NIK..."
                            value="{{ request('search') }}"
                            class="w-full pl-9 pr-3 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-gray-800 text-xs">
                    </div>
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <button type="submit"
                            class="font-semibold py-1.5 px-3.5 rounded-md shadow-sm transition text-xs flex items-center gap-1"
                            style="background-color: #16a34a; color: #ffffff;">
                            <i class="fas fa-search text-[10px]"></i> Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('management.users.index') }}"
                                class="font-semibold py-1.5 px-3.5 rounded-md border transition text-xs flex items-center gap-1"
                                style="background-color: #f3f4f6; color: #4b5563; border-color: #d1d5db;">
                                <i class="fas fa-times text-[10px]"></i> Clear
                            </a>
                        @endif
                        <a href="{{ route('management.users.export', ['search' => request('search')]) }}"
                            class="font-semibold py-1.5 px-3.5 rounded-md shadow-sm transition text-xs flex items-center gap-1.5"
                            style="background-color: #059669; color: #ffffff;">
                            <i class="fas fa-file-excel text-[10px]"></i> Export Excel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead style="background-color: #14532d; color: #ffffff;">
                            <tr>
                                <th class="px-4 py-2.5 font-semibold text-xs uppercase tracking-wider" style="width: 50px;">No.</th>
                                <th class="px-4 py-2.5 font-semibold text-xs uppercase tracking-wider">Username</th>
                                <th class="px-4 py-2.5 font-semibold text-xs uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-2.5 font-semibold text-xs uppercase tracking-wider">Plant</th>
                                <th class="px-4 py-2.5 font-semibold text-xs uppercase tracking-wider">Role</th>
                                <th class="px-4 py-2.5 font-semibold text-xs uppercase tracking-wider text-right" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-green-50/40 transition duration-150">
                                    <td class="px-4 py-2.5 text-gray-500 font-medium">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <span class="font-semibold text-gray-800 text-xs">{{ $user->username }}</span>
                                    </td>
                                    <td class="px-4 py-2.5 text-gray-600 font-medium">{{ $user->nik ?? '-' }}</td>
                                    <td class="px-4 py-2.5">
                                        @if($user->plant)
                                            <span class="text-[10px] font-medium px-2 py-0.5 rounded border"
                                                  style="background-color: #e0e7ff; color: #3730a3; border-color: #c7d2fe;">{{ $user->plant }}</span>
                                        @else
                                            <span class="text-gray-400 italic text-[11px]">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2.5">
                                        @if($user->role === 'admin')
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded border"
                                                  style="background-color: #fee2e2; color: #991b1b; border-color: #fecaca;">ADMIN</span>
                                        @elseif($user->role === 'superadmin')
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded border"
                                                  style="background-color: #f3e8ff; color: #6b21a8; border-color: #e9d5ff;">SUPERADMIN</span>
                                        @elseif($user->role === 'viewer_ho' || $user->role === 'viewer_unit')
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded border"
                                                  style="background-color: #fef3c7; color: #92400e; border-color: #fde68a;">VIEWER</span>
                                        @else
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded border"
                                                  style="background-color: #f3f4f6; color: #374151; border-color: #e5e7eb;">{{ strtoupper($user->role ?? '-') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2.5 text-right font-medium">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('management.users.edit', $user) }}"
                                               title="Edit User"
                                               class="font-semibold text-xs py-1 px-2 rounded border transition flex items-center gap-1"
                                               style="background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe;">
                                                <i class="fas fa-edit text-[10px]"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('management.users.destroy', $user) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Hapus User"
                                                        class="font-semibold text-xs py-1 px-2 rounded border transition flex items-center gap-1"
                                                        style="background-color: #fef2f2; color: #b91c1c; border-color: #fecaca;"
                                                        onclick="return confirm('Yakin ingin menghapus user {{ $user->username }}?');">
                                                    <i class="fas fa-trash-alt text-[10px]"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users text-3xl mb-2 text-gray-300"></i>
                                            <p class="font-medium text-xs text-gray-600">Belum ada data user</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4 bg-white p-3 rounded-lg shadow-sm border border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="text-xs text-gray-600 font-medium">
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
        .custom-pagination .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            margin: 0;
            font-size: 0.75rem;
        }

        .custom-pagination .page-item.disabled .page-link {
            color: #9ca3af;
            pointer-events: none;
            background-color: #f9fafb;
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
            padding: 0.35rem 0.65rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #16a34a;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            font-weight: 500;
        }

        .custom-pagination .page-link:hover {
            color: #15803d;
            background-color: #f0fdf4;
            border-color: #e5e7eb;
        }
    </style>
@endsection