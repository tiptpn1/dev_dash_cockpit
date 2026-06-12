@extends('layouts.app')

@section('title', 'Ubah Password - AGRINAV')

@section('content')
<div class="main-content" id="mainContent">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Ubah Password</h2>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 font-bold mb-2">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-red-500 @enderror" required>
                    @error('current_password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 font-bold mb-2">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('new_password') border-red-500 @enderror" required>
                    @error('new_password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="new_password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi Password Baru</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Simpan Password
                    </button>
                    <a href="{{ url('/') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
