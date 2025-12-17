<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pearlbeads - Handmade Accessories')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #e4b3ff 0%, #d9a5ff 100%);
        }

        .navbar {
            background: linear-gradient(135deg, #e4b3ff 0%, #f0d9ff 100%);
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .spider-web {
            background-image: 
                linear-gradient(90deg, rgba(139, 0, 0, 0.1) 1px, transparent 1px),
                linear-gradient(rgba(139, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="navbar shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12" onerror="this.style.display='none'">
                    <span class="text-2xl font-bold text-purple-800">Pearlbeads.co</span>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-800 hover:text-purple-600 font-medium transition">Home</a>
                    <a href="{{ route('product.index') }}" class="text-gray-800 hover:text-purple-600 font-medium transition">Product</a>
                    <a href="{{ route('contact') }}" class="text-gray-800 hover:text-purple-600 font-medium transition">Contact</a>
                </div>

                <!-- Login/Logout Button -->
                <div>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-purple-700 transition shadow-md mr-2">
                                Admin Panel
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-white text-purple-600 px-6 py-2 rounded-full font-semibold hover:bg-purple-600 hover:text-white transition shadow-md">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-purple-600 px-6 py-2 rounded-full font-semibold hover:bg-purple-600 hover:text-white transition shadow-md">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-purple-900 text-white py-8 mt-20">
        <div class="container mx-auto px-6 text-center">
            <div class="mb-4">
                <p class="text-xl font-semibold">Pearlbeads.co</p>
                <p class="text-purple-200">Handmade Accessories with Love</p>
            </div>
            <div class="flex justify-center space-x-6 mb-4">
                <a href="#" class="hover:text-purple-300 transition">Instagram</a>
                <a href="#" class="hover:text-purple-300 transition">Shopee</a>
                <a href="#" class="hover:text-purple-300 transition">WhatsApp</a>
            </div>
            <p class="text-purple-300 text-sm">&copy; 2024 Pearlbeads.co. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>