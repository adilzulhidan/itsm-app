@extends('layouts.app')

@section('title', 'Knowledge Base')

@section('content')


    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-8 text-center text-white mb-8 shadow-lg">
        <h2 class="text-2xl font-bold mb-2">Bagaimana kami bisa membantu?</h2>
        <p class="text-blue-100 mb-6">Cari panduan, solusi error, dan prosedur IT di sini.</p>
        
        <div class="max-w-2xl mx-auto relative">
            <input type="text" 
                   placeholder="Cari artikel (contoh: VPN, Printer, Reset Password)..." 
                   class="w-full py-3 px-5 pl-12 rounded-full text-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 absolute left-4 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <h3 class="text-lg font-bold text-gray-700 mb-4 border-l-4 border-blue-600 pl-3">Kategori Topik</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($categories as $cat)
        <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition cursor-pointer border-t-4 {{ $cat['border'] }}">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gray-50 rounded-lg {{ $cat['color'] }}">
                    @if($cat['icon'] == 'monitor') <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    @elseif($cat['icon'] == 'window') <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    @elseif($cat['icon'] == 'wifi') <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                    @else <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">{{ $cat['name'] }}</h4>
                    <p class="text-sm text-gray-500">{{ $cat['count'] }} Artikel</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Artikel Paling Populer</h3>
        <div class="space-y-4">
            @foreach($articles as $article)
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition border-b last:border-0 border-gray-100">
                <a href="#" class="flex items-center space-x-3 text-blue-600 font-medium hover:underline">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>{{ $article['title'] }}</span>
                </a>
                <div class="text-xs text-gray-400 flex items-center space-x-4">
                    <span><i class="far fa-eye mr-1"></i> {{ $article['views'] }}</span>
                    <span><i class="far fa-clock mr-1"></i> {{ $article['date'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection