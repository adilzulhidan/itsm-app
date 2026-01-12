@extends('layouts.app')

@section('title', 'Tambah Aset Baru')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('assets.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Create New Asset</h2>
                   
                </div>

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Ada kesalahan!</strong>
                        <ul class="mt-1 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('assets.store') }}" method="POST">
                    @csrf <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Asset</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Contoh: Laptop Dell XPS 13">
                        </div>

                        <div>
                            <label for="asset_code" class="block text-sm font-medium text-gray-700">Asset Code</label>
                            <input type="text" name="asset_code" id="asset_code" value="{{ old('asset_code') }}" required 
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Contoh: IT-LPT-001">
                        </div>

                        <div>
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number (SN)</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" 
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="PC">PC</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Monitor">Monitor</option>
                              
                            </select>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" 
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Contoh: Ruang Meeting Lt. 2">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Asset Status</label>
                            <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="Active">Active (Digunakan)</option>
                                <option value="Maintenance">Maintenance (Sedang Diperbaiki)</option>
                                <option value="Broken">Broken (Rusak)</option>
                                <option value="Inactive">Inactive (Disimpan/Gudang)</option>
                            </select>
                        </div>

                       
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Simpan Aset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection