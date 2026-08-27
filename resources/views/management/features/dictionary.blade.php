@extends('layouts.app')

@section('title', 'Kamus Fitur')

@section('content')
    <div class="main-content overflow-y-auto" style="height: 100vh;">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-book-bookmark text-green-600"></i> Kamus Fitur & Akses Kontrol
                    </h1>
                    <p class="text-gray-600 mt-2">Daftar rujukan slug, rute Laravel, dan posisi sidebar untuk mempermudah pengaturan Hak Akses.</p>
                </div>
                <a href="{{ route('management.features.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Manajemen Fitur
                </a>
            </div>

            <!-- Search and Filter Panel -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <form method="GET" action="{{ route('management.features.dictionary') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="text" name="search" placeholder="Cari slug, nama, atau deskripsi..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-900">
                    </div>

                    <!-- Category Filter -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fa-solid fa-folder-open text-gray-400"></i>
                        </span>
                        <select name="category" onchange="this.form.submit()"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-gray-900 bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat }}" {{ $selectedCategory == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Button & Clear -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm">
                            Cari
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('management.features.dictionary') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-lg transition border border-gray-300">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Feature Dictionary Table Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gradient-to-r from-green-800 to-green-950 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider text-center" style="width: 70px;">No.</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Nama Fitur & Deskripsi</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Slug Fitur</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Posisi Menu Sidebar</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider">Rute URL / Nama Rute</th>
                                <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wider" style="width: 140px;">Sumber</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($dictionary as $index => $item)
                                <tr class="hover:bg-green-50/50 transition">
                                    <td class="px-6 py-5 text-center text-gray-500 font-medium text-sm">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200 shadow-xs">
                                            {{ $item['category'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-gray-800 text-base">{{ $item['name'] }}</div>
                                        <div class="text-sm text-gray-500 mt-1 max-w-sm font-normal">{{ $item['description'] }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-md text-sm font-mono border border-blue-100 select-all cursor-pointer shadow-xs" title="Klik untuk menyeleksi">
                                            {{ $item['slug'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm text-gray-700 font-medium flex items-center gap-1.5">
                                            @php
                                                $parts = explode('->', $item['position']);
                                            @endphp
                                            @foreach($parts as $partIndex => $part)
                                                @if($partIndex > 0)
                                                    <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                                                @endif
                                                <span class="{{ $partIndex == count($parts) - 1 ? 'text-green-800 font-bold' : 'text-gray-500' }}">
                                                    {{ trim($part) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm text-gray-700 font-semibold font-mono">{{ $item['url'] }}</div>
                                        @if($item['route_name'] && $item['route_name'] !== '-')
                                            <div class="text-xs text-gray-400 font-normal mt-0.5">Route: <span class="bg-gray-100 px-1 py-0.5 rounded font-mono">{{ $item['route_name'] }}</span></div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $item['source'] == 'Looker Studio' ? 'bg-orange-100 text-orange-800 border border-orange-200' : '' }}
                                            {{ $item['source'] == 'Aplikasi Lokal' || $item['source'] == 'Aplikasi Lokal (CRUD)' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                            {{ $item['source'] == 'Situs Eksternal' || $item['source'] == 'Situs Eksternal (SSO)' ? 'bg-purple-100 text-purple-800 border border-purple-200' : '' }}
                                        ">
                                            @if($item['source'] == 'Looker Studio')
                                                <i class="fa-solid fa-chart-pie text-xs"></i>
                                            @elseif($item['source'] == 'Aplikasi Lokal' || $item['source'] == 'Aplikasi Lokal (CRUD)')
                                                <i class="fa-solid fa-laptop-code text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                            @endif
                                            {{ $item['source'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <i class="fas fa-inbox text-5xl mb-4 block opacity-40"></i>
                                        <p class="font-bold text-lg">Tidak ada data fitur yang cocok</p>
                                        <p class="text-sm text-gray-400 mt-1">Coba gunakan kata kunci pencarian atau filter kategori lainnya.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    </style>
@endsection
