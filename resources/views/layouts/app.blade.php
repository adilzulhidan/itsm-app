<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Gaya dasar untuk Sidebar */
        .sidebar-item { color: #d1d5db; } /* Text Gray 300 */
        .sidebar-item:hover { background-color: #4b5563; } /* Gray-600 */
        .active-link { background-color: #3b82f6; color: white !important; font-weight: bold; }
        .active-link svg { color: white !important; }
        .logout-btn { color: #f87171; } 
        .logout-btn:hover { background-color: #ef4444; color: white !important; } 

        /* Transisi untuk animasi penutup/pembuka */
        .transition-width { transition: width 0.3s ease; }
        .transition-opacity { transition: opacity 0.3s ease; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">
    
    <div class="flex min-h-screen w-full">

        <div id="sidebar" class="w-64 bg-gray-800 text-white flex flex-col min-h-screen shadow-2xl transition-width duration-300 flex-shrink-0">
            
            <div id="sidebar-header" class="p-4 text-2xl font-extrabold border-b border-gray-700 text-center bg-gray-900 flex justify-between items-center whitespace-nowrap overflow-hidden">
                <span id="header-text">JTEKT ITSM</span>
                
                <button id="sidebarToggle" class="text-gray-400 hover:text-white focus:outline-none flex-shrink-0">
                    <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8m-11 3V9m0 0h12" />
                    </svg>
                </button>
            </div>
            
            <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
                
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'it_head')
                    <p class="text-xs uppercase text-gray-500 font-semibold mt-4 mb-1 px-4 sidebar-text">Admin Tools</p>
                    
                    <a href="{{ route('dashboard') }}" class="sidebar-item block px-4 py-2 rounded transition duration-150 ease-in-out 
                        {{ Request::routeIs('dashboard') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 8V20L12 22L21 20V8L12 2Z"/><path d="M12 22V12"/></svg>
                            <span class="sidebar-text whitespace-nowrap">Dashboard</span>
                        </div>
                    </a>

                    <a href="{{ route('users.index') }}" class="sidebar-item block px-4 py-2 rounded transition duration-150 ease-in-out 
                        {{ Request::routeIs('users.*') ? 'active-link' : '' }}">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M17 11l-3 3-5-5"/></svg>
                            <span class="sidebar-text whitespace-nowrap">Kelola User</span>
                        </div>
                    </a>
                @endif

                <p class="text-xs uppercase text-gray-500 font-semibold mt-4 mb-1 px-4 sidebar-text">Request & Tracking</p>

                <a href="{{ route('tickets.index') }}" class="sidebar-item block px-4 py-2 rounded transition duration-150 ease-in-out 
                    {{ Request::routeIs('tickets.index') || Request::routeIs('tickets.show') || Request::routeIs('tickets.edit') ? 'active-link' : '' }}">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6m-8 7h6m-6 4h6"/></svg>
                        <span class="sidebar-text whitespace-nowrap">Daftar Tiket</span>
                    </div>
                </a>

                <a href="{{ route('tickets.create') }}" class="sidebar-item block px-4 py-2 rounded transition duration-150 ease-in-out 
                    {{ Request::routeIs('tickets.create') ? 'active-link' : '' }}">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v8m-4-4h8"/></svg>
                        <span class="sidebar-text whitespace-nowrap">Buat Request Baru</span>
                    </div>
                </a>
                
            </nav>
            
            <div id="logout-container" class="p-4 mt-auto border-t border-gray-700 transition-opacity">
                <p class="text-xs text-gray-400 mb-2 sidebar-text">Logged in as: <span class="font-bold text-white">{{ Auth::user()->name }}</span></p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn block w-full text-left px-4 py-2 rounded transition duration-150 ease-in-out font-semibold flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span class="sidebar-text whitespace-nowrap">Logout ({{ ucfirst(Auth::user()->role) }})</span>
                    </button>
                </form>
            </div>
            
        </div>

        <div id="main-content" class="flex-1 p-6 overflow-y-auto">
            
            <header class="bg-white shadow p-4 rounded mb-6 flex justify-between items-center sticky top-0 z-10">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-semibold text-gray-700">@yield('title')</h1>
                </div>
                <span class="text-sm text-gray-500">Welcome back, {{ Auth::user()->name }}!</span>
            </header>

            @yield('content')
        </div>
    </div>

</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('sidebarToggle');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const headerText = document.getElementById('header-text');
        const logoutContainer = document.getElementById('logout-container');

      
        let isSidebarOpen = true; 

        function toggleSidebar() {
            if (isSidebarOpen) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
                sidebarTexts.forEach(text => {
                    text.style.opacity = 0;
                    text.style.width = '0';
                    text.style.overflow = 'hidden';
                });
                
             
                headerText.style.display = 'none';

           
                toggleButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5h12M5 12h12M5 19h12" />
                    </svg>
                `;

                isSidebarOpen = false;
            } else {
                
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                
             
                headerText.style.display = 'block';

               
                sidebarTexts.forEach(text => {
                    text.style.opacity = 1;
                    text.style.width = 'auto';
                    text.style.overflow = 'visible';
                });
                
                
                toggleButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8m-11 3V9m0 0h12" />
                    </svg>
                `;

                isSidebarOpen = true;
            }
        }

        
        toggleButton.addEventListener('click', toggleSidebar);
        
        
        sidebarTexts.forEach(text => {
            text.style.transition = 'opacity 0.3s ease, width 0.3s ease';
        });

       
    });
</script>
</html>