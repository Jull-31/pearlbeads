<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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

        .spider-web {
            background-image: 
                linear-gradient(90deg, rgba(139, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(rgba(139, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        @keyframes custom-bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow {
            animation: custom-bounce 3s infinite;
        }

        body {
            overflow-x: hidden;
            width: 100%;
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="navbar shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6 py-3 md:py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 md:h-12 md:w-12" onerror="this.style.display='none'">
                    <span class="text-xl md:text-2xl font-bold text-purple-800">Pearlbeads</span>
                </div>

                <div class="hidden md:flex items-center justify-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-800 hover:text-purple-600 font-bold transition">Beranda</a>
                    <a href="{{ route('product.index') }}" class="text-gray-800 hover:text-purple-600 font-bold transition">Produk Kami</a>
                    <a href="#faq-section" class="text-gray-800 hover:text-purple-600 font-bold transition">FAQ</a>
                </div>

                <div class="flex items-center space-x-2 md:space-x-4">
                    <button onclick="cart.toggleCartSidebar()" class="relative p-2 text-gray-800 hover:text-purple-600 transition">
                        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span id="cartBadge" class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full hidden border border-white">0</span>
                    </button>

                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-white text-purple-600 px-3 py-1.5 md:px-5 md:py-2 rounded-full font-semibold border-2 border-purple-600 text-[10px] md:text-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-purple-600 px-4 py-1.5 md:px-6 md:py-2 rounded-full font-semibold border-2 border-purple-600 text-[10px] md:text-sm">
                            Login
                        </a>
                    @endauth

                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-800 p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menuIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobileMenu" class="hidden md:hidden flex flex-col space-y-3 pt-4 pb-2 border-t border-purple-200 mt-3">
                <a href="{{ route('home') }}" class="text-gray-800 font-bold hover:text-purple-600">Beranda</a>
                <a href="{{ route('product.index') }}" class="text-gray-800 font-bold hover:text-purple-600">Produk Kami</a>
                <a href="#faq-section" onclick="toggleMobileMenu()" class="text-gray-800 font-bold hover:text-purple-600">FAQ</a>
                @if(auth()->check() && auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="text-purple-600 font-bold">Admin Panel</a>
                @endif
            </div>
        </div>
    </nav>

    <main class="spider-web min-h-screen">
        @yield('content')

        <section id="faq-section" class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-bold text-center mb-12 text-purple-800">Frequently Asked Questions</h2>
                
                <div class="max-w-3xl mx-auto space-y-4">
                    <div class="border-2 border-purple-100 rounded-2xl overflow-hidden shadow-sm">
                        <button class="w-full p-5 text-left bg-purple-50 flex justify-between items-center group" onclick="toggleFaq(1)">
                            <span class="font-bold text-purple-900 group-hover:text-purple-600 transition">Berapa lama proses pembuatan produk custom?</span>
                            <svg id="icon-1" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div id="faq-1" class="hidden p-5 bg-white text-gray-600 border-t-2 border-purple-100 animate-fade-in">
                            Proses pembuatan aksesoris custom memakan waktu sekitar 1-3 hari kerja tergantung tingkat kesulitan desain.
                        </div>
                    </div>

                    <div class="border-2 border-purple-100 rounded-2xl overflow-hidden shadow-sm">
                        <button class="w-full p-5 text-left bg-purple-50 flex justify-between items-center group" onclick="toggleFaq(2)">
                            <span class="font-bold text-purple-900 group-hover:text-purple-600 transition">Apakah bisa dikirim ke seluruh Indonesia?</span>
                            <svg id="icon-2" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div id="faq-2" class="hidden p-5 bg-white text-gray-600 border-t-2 border-purple-100 animate-fade-in">
                            Ya, Pearlbeads melayani pengiriman ke seluruh wilayah Indonesia menggunakan ekspedisi J&T atau JNE.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-purple-900 text-white pt-12 pb-6 mt-10 md:mt-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10 text-center md:text-left">
                <div class="space-y-3">
                    <h3 class="text-xl md:text-2xl font-bold">Pearlbeads.co</h3>
                    <p class="text-purple-200 text-xs md:text-sm leading-relaxed">
                        Handmade Accessories with Love ❤️
                    </p>
                </div>
                <div class="space-y-3">
                    <h4 class="text-lg font-semibold text-white">Navigasi</h4>
                    <ul class="text-purple-200 text-xs md:text-sm space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('product.index') }}" class="hover:text-white transition">Katalog Produk</a></li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h4 class="text-lg font-semibold text-white">Follow Us</h4>
                    <div class="flex flex-col items-center md:items-start space-y-2 text-xs md:text-sm">
                        <a href="https://www.instagram.com/pearlbeads.co" target="_blank" class="text-purple-300 hover:text-white transition">Instagram</a>
                        <a href="https://wa.me/6283836295352" target="_blank" class="text-purple-300 hover:text-white transition">WhatsApp</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-purple-800 pt-6 text-center">
                <p class="text-purple-300 text-[10px]">&copy; 2025 Pearlbeads.co. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6283836295352" target="_blank" class="fixed bottom-6 left-6 z-50 group animate-bounce-slow">
        <div class="bg-green-500 text-white p-3 md:p-4 rounded-full shadow-2xl transition-all duration-300 transform group-hover:scale-110 flex items-center justify-center">
            <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        </div>
    </a>

    <div id="cartOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>
    <div id="cartSidebar" class="fixed top-0 right-0 h-full w-[85%] md:w-96 bg-gray-50 shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex flex-col h-full">
            <div class="bg-purple-600 text-white p-4 flex justify-between items-center">
                <h2 class="text-lg font-bold">Keranjang Belanja</h2>
                <button onclick="cart.toggleCartSidebar()" class="p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="cartItems" class="flex-1 overflow-y-auto p-4 text-sm"></div>
            <div class="border-t bg-white p-4 space-y-4">
                <div class="flex justify-between items-center font-bold">
                    <span>Total:</span>
                    <span class="text-purple-600">Rp <span id="cartTotal">0</span></span>
                </div>
                <button onclick="sendToWhatsApp()" class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-bold flex items-center justify-center space-x-2 transition shadow-lg text-sm">
                    <span>Checkout via WhatsApp</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Script FAQ
        function toggleFaq(id) {
            const content = document.getElementById(`faq-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // (Fungsi WhatsApp tetap ada di sini)
        function sendToWhatsApp() {
            if (typeof cart !== 'undefined' && cart.items.length === 0) {
                alert('Keranjang belanja anda masih kosong!');
                return;
            }
            document.getElementById('orderModal').classList.remove('hidden');
        }
        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }
        function confirmAndSendWA() {
            // ... logika kirim WA ...
        }
    </script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>