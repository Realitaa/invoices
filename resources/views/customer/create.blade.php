@extends('layouts.app')

@section('title', 'Insert customer')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">Buat Customer Baru</h2>
            <p class="mt-1 text-sm text-gray-600">Isi detail di bawah untuk membuat customer baru.</p>
        </div>

        <!-- Form Body -->
        <form action="{{ route('customer.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="id" class="block text-sm font-medium text-gray-700 mb-2">
                    ID <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="id"
                       name="id"
                       value="{{ old('id') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('id') border-red-500 @enderror"
                       placeholder="Masukkan ID"
                       required>
                @error('id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror"
                       placeholder="Masukkan Nama"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="npwp" class="block text-sm font-medium text-gray-700 mb-2">
                    NPWP <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="npwp"
                       name="npwp"
                       value="{{ old('npwp') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('id') border-red-500 @enderror"
                       placeholder="Masukkan NPWP"
                       required>
                @error('npwp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

                    <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Address
                </label>
                <textarea id="address"
                          name="address"
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('address') border-red-500 @enderror"
                          placeholder="Enter any additional address or comments">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('customer.index') }}"
                   class="px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Buat customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
