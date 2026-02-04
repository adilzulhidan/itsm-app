@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 py-8 px-4 dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-6xl mx-auto">
        
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-100 dark:text-gray-100">Detail Pengguna</h1>
                    <p class="text-gray-400 mt-1 dark:text-gray-400">Informasi lengkap pengguna sistem</p>
                </div>
                <a href="{{ route('users.index') }}" 
                   class="group flex items-center px-5 py-2.5 bg-gray-800 text-gray-300 rounded-xl shadow-sm hover:shadow-md hover:bg-gray-700 transition-all duration-200 border border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-700">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
        
            <div class="lg:w-2/5">
                <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700 hover:shadow-2xl transition-shadow duration-300 dark:bg-gray-800 dark:border-gray-700">
                    
                    <div class="relative h-32 bg-gradient-to-r from-blue-600 to-purple-700 dark:from-blue-600 dark:to-purple-700">
                        <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                            <div class="relative">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                         class="w-32 h-32 rounded-full border-4 border-gray-800 shadow-lg object-cover dark:border-gray-800">
                                @else
                                    <div class="w-32 h-32 rounded-full border-4 border-gray-800 shadow-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center dark:border-gray-800">
                                        <span class="text-4xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 rounded-full border-4 border-gray-800 flex items-center justify-center dark:border-gray-800">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="pt-20 px-8 pb-8">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-100 dark:text-gray-100">{{ $user->name }}</h2>
                            <p class="text-gray-400 mt-1 dark:text-gray-400">{{ $user->email }}</p>
                            
                            <div class="mt-4 inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-blue-900/30 to-blue-800/30 text-blue-300 border border-blue-700/50 dark:from-blue-900/30 dark:to-blue-800/30">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>
                                <span class="font-semibold capitalize">{{ $user->role }}</span>
                            </div>
                        </div>

                    
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-gray-700/50 rounded-xl p-4 text-center hover:bg-gray-700 transition-colors duration-200 dark:bg-gray-700/50">
                                <div class="text-2xl font-bold text-gray-100 dark:text-gray-100">
                                    {{ $user->created_at->format('d') }}
                                </div>
                                <div class="text-sm text-gray-400 dark:text-gray-400">Join</div>
                                <div class="text-xs text-gray-500 mt-1 dark:text-gray-500">{{ $user->created_at->format('M Y') }}</div>
                            </div>
                            <div class="bg-green-900/30 rounded-xl p-4 text-center hover:bg-green-800/30 transition-colors duration-200 dark:bg-green-900/30">
                                <div class="text-2xl font-bold text-green-400 dark:text-green-400">
                                    <svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="text-sm font-semibold text-green-300 mt-1 dark:text-green-300">Status</div>
                                <div class="text-xs text-green-400 dark:text-green-400">Active</div>
                            </div>
                        </div>

                        
                        <a href="{{ route('users.edit', $user->id) }}" 
                           class="group w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl hover:from-yellow-700 hover:to-yellow-800 transition-all duration-200 transform hover:-translate-y-0.5 dark:from-yellow-600 dark:to-yellow-700">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit User Data
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="lg:w-3/5">
                <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700 dark:bg-gray-800 dark:border-gray-700">
                    <div class="px-8 py-6 bg-gradient-to-r from-gray-700 to-gray-800 border-b border-gray-700 dark:from-gray-700 dark:to-gray-800">
                        <h2 class="text-xl font-bold text-gray-100 flex items-center dark:text-gray-100">
                            <svg class="w-6 h-6 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Detail Information
                        </h2>
                    </div>

                    <div class="p-8">
                        
                        <div class="space-y-6">
                            <div class="flex items-center p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-colors duration-200 group dark:bg-gray-700/50">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-900/30 text-blue-400 rounded-lg mr-4 group-hover:scale-110 transition-transform duration-200 dark:bg-blue-900/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-400 dark:text-gray-400">Department</div>
                                    <div class="font-semibold text-gray-100 dark:text-gray-100">{{ $user->department ?? 'Belum diatur' }}</div>
                                </div>
                                @if($user->department)
                                    <span class="px-3 py-1 text-xs bg-blue-900/30 text-blue-300 rounded-full dark:bg-blue-900/30">Terisi</span>
                                @else
                                    <span class="px-3 py-1 text-xs bg-yellow-900/30 text-yellow-300 rounded-full dark:bg-yellow-900/30">Kosong</span>
                                @endif
                            </div>

                            <div class="flex items-center p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-colors duration-200 group dark:bg-gray-700/50">
                                <div class="w-10 h-10 flex items-center justify-center bg-green-900/30 text-green-400 rounded-lg mr-4 group-hover:scale-110 transition-transform duration-200 dark:bg-green-900/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-400 dark:text-gray-400">Join Since</div>
                                    <div class="font-semibold text-gray-100 dark:text-gray-100">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                                <div class="text-sm text-gray-400 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-colors duration-200 group dark:bg-gray-700/50">
                                <div class="w-10 h-10 flex items-center justify-center bg-purple-900/30 text-purple-400 rounded-lg mr-4 group-hover:scale-110 transition-transform duration-200 dark:bg-purple-900/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-400 dark:text-gray-400">Status Akun</div>
                                    <div class="font-semibold text-green-400 flex items-center dark:text-green-400">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Active
                                    </div>
                                </div>
                                <div class="text-xs text-green-400 bg-green-900/30 px-3 py-1 rounded-full dark:bg-green-900/30">Verified</div>
                            </div>
                        </div>

                        
                        <div class="mt-8 p-6 bg-gradient-to-r from-blue-900/20 to-indigo-900/20 rounded-2xl border border-blue-800/30 dark:from-blue-900/20 dark:to-indigo-900/20">
                            <h3 class="font-bold text-gray-100 mb-3 flex items-center dark:text-gray-100">
                                <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Deskripsi Role
                            </h3>
                            <p class="text-sm text-gray-300 dark:text-gray-300">
                                @switch($user->role)
                                    @case('admin')
                                        Administrator memiliki akses penuh ke sistem, dapat mengelola semua pengguna, dan mengatur konfigurasi sistem.
                                        @break
                                    @case('manager')
                                        Manager dapat menyetujui permintaan dari departemennya dan melihat laporan terkait.
                                        @break
                                    @case('it_head')
                                        IT Dept Head bertanggung jawab untuk menyetujui permintaan teknis dan mengelola aset IT.
                                        @break
                                    @default
                                        User biasa dapat membuat permintaan dan melacak status permintaannya.
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styles for better dark mode experience */
    .dark .shadow-xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .dark .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    }
    
    /* Smooth transitions for all interactive elements */
    * {
        transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
    }
</style>
@endsection