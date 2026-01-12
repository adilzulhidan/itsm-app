@extends('layouts.app')

@section('title', 'Import Assets')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Import Data Assets</h1>
                <p class="text-gray-600 mt-1">Import data aset dari file CSV.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('assets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white shadow overflow-hidden border border-gray-200 rounded-lg">
            <div class="p-6">
                <!-- Instructions -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                    <h3 class="text-lg font-medium text-blue-800 mb-2">Instruksi Import:</h3>
                    <ul class="list-disc pl-5 text-sm text-blue-700 space-y-1">
                        <li>Pastikan file berformat CSV dengan delimiter titik koma (;)</li>
                        <li>File harus memiliki header pada baris pertama</li>
                        <li>Kolom yang diperlukan: Name, Status, Type, Location, Serial Number, Asset Code, Purchase Date</li>
                        <li>Data yang sudah ada akan diupdate berdasarkan Serial Number</li>
                        <li>Format tanggal: YYYY-MM-DD (contoh: 2024-01-15)</li>
                    </ul>
                </div>

                <!-- Upload Form -->
                <form action="{{ route('assets.import.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- File Upload -->
                        <div>
                            <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih File CSV
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="csv_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload file</span>
                                            <input id="csv_file" name="csv_file" type="file" class="sr-only" accept=".csv,.txt" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">CSV atau TXT hingga 10MB</p>
                                </div>
                            </div>
                            @error('csv_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CSV Template -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Template CSV</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-md p-4 overflow-x-auto">
                                <pre class="text-xs text-gray-600">Name;Status;Type;Location;Serial Number;Asset Code;Purchase Date
Laptop Dell XPS;Active;Laptop;IT Department;SN123456;AST001;2024-01-15
Monitor HP;Active;Monitor;Finance;SN789012;AST002;2024-01-20</pre>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Download <a href="#" class="text-indigo-600 hover:text-indigo-500">template CSV</a> untuk format yang benar</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                Import Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Section (if any previous imports) -->
        @if(session('success') || session('error'))
        <div class="mt-6">
            <div class="bg-white shadow border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Hasil Import</h3>
                
                @if(session('success'))
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mt-4 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    {{ session('error') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection