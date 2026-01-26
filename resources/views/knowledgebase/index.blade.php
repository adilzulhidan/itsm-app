@extends('layouts.app')

@section('title', 'Knowledge Base')

@section('content')
<div class="space-y-8">
    <!-- Header dengan search -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-800 dark:to-blue-900 rounded-xl p-8 text-center text-white shadow-lg">
        <h2 class="text-2xl font-bold mb-2 dark:text-blue-100">Bagaimana kami bisa membantu?</h2>
        <p class="text-blue-100 dark:text-blue-200 mb-6">Cari panduan, solusi error, dan prosedur IT di sini.</p>
        
        <div class="max-w-2xl mx-auto relative">
            <input type="text" 
                   placeholder="Cari artikel (contoh: VPN, Printer, Reset Password)..." 
                   class="w-full py-3 px-5 pl-12 rounded-full text-gray-800 dark:text-gray-200 
                          bg-white dark:bg-gray-700 
                          focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-700 
                          shadow-lg transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 dark:text-gray-500 absolute left-4 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Kategori Topik -->
    <div>
        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-4 border-l-4 border-blue-600 dark:border-blue-500 pl-3">Kategori Topik</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($categories as $cat)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm hover:shadow-md dark:hover:shadow-gray-900/50 
                        transition-all duration-300 cursor-pointer border-t-4 {{ $cat['border'] }} 
                        border border-gray-100 dark:border-gray-700 
                        hover:translate-y-[-2px]">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/80 rounded-lg {{ $cat['color'] }} transition-colors duration-200">
                        @if($cat['icon'] == 'monitor') 
                        <svg class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        @elseif($cat['icon'] == 'window') 
                        <svg class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        @elseif($cat['icon'] == 'wifi') 
                        <svg class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                        </svg>
                        @else 
                        <svg class="w-8 h-8 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200">{{ $cat['name'] }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cat['count'] }} Artikel</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Artikel Populer -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 p-6 border border-gray-100 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Artikel Paling Populer</h3>
            <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                Lihat semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        
        <div class="space-y-4">
            @foreach($articles as $article)
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 
                        rounded-lg transition-all duration-200 border-b last:border-0 
                        border-gray-100 dark:border-gray-700/50">
                <a href="#" class="flex items-center space-x-3 text-blue-600 dark:text-blue-400 font-medium hover:underline group">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-md group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors duration-200">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors duration-200">{{ $article['title'] }}</span>
                </a>
                <div class="text-xs text-gray-400 dark:text-gray-500 flex items-center space-x-4">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $article['views'] }}
                    </span>
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $article['date'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        
        @if(count($articles) === 0)
        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p>Belum ada artikel tersedia</p>
        </div>
        @endif
    </div>

    <!-- Artikel Terbaru (Opsional Tambahan) -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 p-6 border border-gray-100 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Artikel Terbaru</h3>
            <button class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200">
                Filter
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach(array_slice($articles, 0, 4) as $article)
            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700 
                        bg-gray-50/50 dark:bg-gray-700/30 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 
                        transition-all duration-200 group">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-white dark:bg-gray-700 rounded-md shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                            {{ $article['title'] }}
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                            Panduan lengkap untuk mengatasi masalah yang sering terjadi...
                        </p>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-400 dark:text-gray-500">
                            <span>{{ $article['date'] }}</span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $article['views'] }} views
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Custom Styles untuk truncate text -->
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Smooth transitions */
    * {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
@endsection