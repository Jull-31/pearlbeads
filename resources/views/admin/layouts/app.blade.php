<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Pearlbeads</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden hidden"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-gradient-to-b from-purple-600 to-purple-800 text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl lg:shadow-none">
            
            <div class="p-6 border-b border-purple-500">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold tracking-wide">Pearlbeads</h1>
                        <p class="text-purple-200 text-xs uppercase tracking-widest mt-1">Admin Panel</p>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <nav class="mt-6 flex-1 px-2 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white text-purple-800 font-bold shadow-md' : 'text-purple-100 hover:bg-purple-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.banners.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-white text-purple-800 font-bold shadow-md' : 'text-purple-100 hover:bg-purple-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Banners
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-white text-purple-800 font-bold shadow-md' : 'text-purple-100 hover:bg-purple-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Products
                </a>
            </nav>

            <div class="p-4 border-t border-purple-500 bg-purple-900">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center px-4 py-2 text-sm text-purple-200 hover:text-white transition-colors mb-2">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Website
                </a>
                
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-sm text-red-300 hover:text-white hover:bg-red-600 rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="bg-white shadow-sm z-10 flex items-center justify-between px-6 py-4">
                
                <div class="flex items-center">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 focus:outline-none p-2 rounded-md hover:bg-gray-100 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 hidden md:inline-block">{{ auth()->user()->name }}</span>
                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-8">
                @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Buka Sidebar
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                // Tutup Sidebar
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>