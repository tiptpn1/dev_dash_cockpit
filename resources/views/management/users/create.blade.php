@extends('layouts.app')

@section('title', 'Add New User')

@section('content')
<div class="main-content overflow-y-auto" style="height: 100vh;">
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Add New User</h1>
        <p class="text-gray-600">Create a new system user account</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-green-700"></div>
        
        <form method="POST" action="{{ route('management.users.store') }}">
            @csrf

            <!-- Username -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="username">Username <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-user text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('username') border-red-500 ring-1 ring-red-500 @enderror"
                        type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Enter username" required>
                </div>
                @error('username')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- NIK -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="nik">Nomor Induk Karyawan (NIK)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-id-badge text-green-600 opacity-70"></i>
                        </div>
                        <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('nik') border-red-500 ring-1 ring-red-500 @enderror"
                            type="text" name="nik" id="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK">
                    </div>
                    @error('nik')
                        <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-green-600 opacity-70"></i>
                        </div>
                        <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200 @error('password') border-red-500 ring-1 ring-red-500 @enderror"
                            type="password" name="password" id="password" placeholder="Min. 6 characters" required>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr class="border-gray-100 mb-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Plant -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="plant">Plant / Lokasi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-industry text-green-600 opacity-70"></i>
                        </div>
                        <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200"
                            type="text" name="plant" id="plant" value="{{ old('plant') }}" placeholder="e.g. HA00">
                    </div>
                </div>

                <!-- Regional -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="regional">Regional</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-map-marker-alt text-green-600 opacity-70"></i>
                        </div>
                        <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200"
                            type="text" name="regional" id="regional" value="{{ old('regional') }}" placeholder="Wilayah regional">
                    </div>
                </div>
            </div>

            <!-- Role -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="role">Hak Akses / Role</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-user-shield text-green-600 opacity-70"></i>
                    </div>
                    <input class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white text-gray-900 font-medium transition duration-200"
                        type="text" name="role" id="role" value="{{ old('role') }}" placeholder="e.g., admin, superadmin, viewer_ho">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4 border-t border-gray-100 mt-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan User Baru
                </button>
                <a href="{{ route('management.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-lg transition duration-200 text-center flex items-center">
                    <i class="fas fa-times mr-2"></i> Batal
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
