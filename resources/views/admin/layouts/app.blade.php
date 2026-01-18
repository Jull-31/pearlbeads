<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Pearlbeads</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Poppins', sans-serif; }
        /* Scrollbar Halus */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d8b4fe; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a855f7; }
        
        .active-nav {
            background-color: white;
            color: #9333ea; /* Purple-600 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            font-weight: 700;
            transform: scale(1.02);
        }
        .inactive-nav {
            color: rgba(255, 255, 255, 0.9);
        }
        .inactive-nav:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 z-20 bg-black/50 backdrop-blur-sm transition-opacity lg:hidden hidden"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-72 bg-gradient-to-b from-purple-600 to-pink-500 text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl">
            
            <div class="h-24 flex items-center justify-center border-b border-white/10 relative">
                <div class="text-center">
                    <h1 class="text-3xl font-black tracking-wider drop-shadow-md">Pearlbeads</h1>
                    <p class="text-white/80 text-xs uppercase tracking-[0.2em] mt-1">Admin Panel</p>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden absolute top-6 right-6 text-white/80 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="mt-6 flex-1 px-4 space-y-3 overflow-y-auto py-4">
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'active-nav' : 'inactive-nav' }}">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center px-6 py-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.orders.index') ? 'active-nav' : 'inactive-nav' }}">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Pesanan Masuk
                    @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                    @if($pendingCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm animate-pulse">
                        {{ $pendingCount }}
                    </span>
                    @endif
                </a>

                <a href="{{ route('admin.orders.history') }}" 
                   class="flex items-center px-6 py-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.orders.history') ? 'active-nav' : 'inactive-nav' }}">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat Order
                </a>

                <a href="{{ route('admin.banners.index') }}" 
                   class="flex items-center px-6 py-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.banners.*') ? 'active-nav' : 'inactive-nav' }}">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Banners
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center px-6 py-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.products.*') ? 'active-nav' : 'inactive-nav' }}">
                    <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>

            </nav>

            <div class="p-6 border-t border-white/10 bg-white/5 space-y-2">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center px-4 py-3 text-sm text-white/90 hover:bg-white/10 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Website
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm text-red-100 hover:bg-red-500/80 hover:text-white rounded-xl transition cursor-pointer">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            
            <header class="bg-white shadow-sm z-10 flex items-center justify-between px-6 py-4 lg:hidden">
                <button onclick="toggleSidebar()" class="text-gray-500 focus:outline-none p-2 rounded-xl hover:bg-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h2 class="text-lg font-bold text-gray-800 tracking-wide">Admin Panel</h2>
                <div class="w-8"></div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
                @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center animate-bounce">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <div><p class="font-bold">Sukses!</p><p class="text-sm">{{ session('success') }}</p></div>
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
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>