@extends('layouts.app')

@section('title', 'Home - Pearlbeads')

@section('content')

<section class="relative overflow-hidden h-[250px] md:h-[500px] transition-all duration-300">
    <div id="heroSlider" class="relative w-full h-full">
        
        @forelse($banners as $index => $banner)
        <div class="slide {{ $index === 0 ? 'active' : '' }}" style="background: {{ $banner->background_color }};">
            
            @if($banner->image)
            <div class="w-full h-full flex items-center justify-center">
                <img src="{{ asset('images/banners/' . $banner->image) }}" 
                     alt="{{ $banner->title }}"
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-center text-gray-500 py-20\'><p>Banner image not found</p></div>'">
            </div>
            @else
            <div class="w-full h-full flex items-center justify-center" style="background: {{ $banner->background_color }};">
                <div class="text-center p-4 md:p-8">
                    <h1 class="text-2xl md:text-6xl font-bold mb-2 md:mb-4 text-white drop-shadow-lg">{{ $banner->title }}</h1>
                    @if($banner->subtitle)
                    <p class="text-sm md:text-3xl text-white">{{ $banner->subtitle }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @empty
        <div class="slide active" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="container mx-auto px-6 h-full relative z-10 flex flex-col justify-center items-center text-center text-white">
                <h1 class="text-2xl md:text-6xl font-bold mb-2 md:mb-4">Welcome to Pearlbeads</h1>
                <p class="text-sm md:text-2xl mb-4 md:mb-6">Handmade Accessories with Love</p>
                @if(auth()->check() && auth()->user()->is_admin)
                <div class="mt-4 md:mt-8">
                    <a href="{{ route('admin.banners.index') }}" class="bg-white text-purple-600 px-4 py-2 md:px-8 md:py-3 text-xs md:text-base rounded-full font-semibold hover:bg-gray-100 transition">
                        Add Banner
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    @if($banners->count() > 1)
    <button id="prevSlide" class="absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white p-2 md:p-4 rounded-full shadow-xl z-20 transition hover:scale-110">
        <svg class="w-4 h-4 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button id="nextSlide" class="absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white p-2 md:p-4 rounded-full shadow-xl z-20 transition hover:scale-110">
        <svg class="w-4 h-4 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <div class="absolute bottom-4 md:bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 md:space-x-3 z-20">
        @foreach($banners as $index => $banner)
        <button class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
        @endforeach
    </div>
    @endif
</section>


<section class="py-8 md:py-16">
    <div class="container mx-auto px-4 md:px-6">
        <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12" style="color: #87CEEB;">OUR PRODUCT</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-8">
            @forelse($bracelets as $product)
            <div class="product-card group bg-white rounded-xl md:rounded-2xl shadow-md md:shadow-lg overflow-hidden transition-all duration-300 hover:-translate-y-1 md:hover:-translate-y-3 hover:shadow-xl" style="border: 2px md:border-3 solid #87CEEB;">
                
                <div class="p-2 md:p-6 bg-gray-50">
                    <div class="aspect-square flex items-center justify-center bg-white rounded-lg overflow-hidden relative">
                        @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-110">
                        @else
                        <div class="text-gray-400 text-center">
                            <svg class="w-10 h-10 md:w-20 md:h-20 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="p-2 md:p-4 text-center">
                    <h3 class="text-xs md:text-xl font-bold mb-1 md:mb-2 group-hover:text-purple-600 transition-colors line-clamp-1" style="font-style: italic;">{{ $product->name }}</h3>
                    <p class="text-purple-600 font-bold text-xs md:text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-gray-400 text-[10px] md:text-xs mt-1">Stock: {{ $product->stock }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-sm md:text-lg">No bracelet products available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>


<section class="gradient-bg py-8 md:py-16 mt-8 md:mt-16">
    <div class="container mx-auto px-4 md:px-6 text-center">
        <div class="flex flex-col md:flex-row justify-center items-center gap-3 md:gap-6 mb-8 md:mb-12">
            <a href="{{ route('product.index') }}" 
               class="w-full md:w-auto bg-blue-400 hover:bg-blue-500 text-white px-6 py-2 md:px-10 md:py-3 rounded-full font-bold text-sm md:text-lg shadow-lg transform hover:scale-105 transition duration-300">
                SEMUA PRODUK
            </a>
            
            @php $phoneStrapCategory = $categories->where('slug', 'phone-strap')->first(); @endphp
            <a href="{{ $phoneStrapCategory ? route('product.index', ['category' => $phoneStrapCategory->id]) : route('product.index') }}" 
               class="w-full md:w-auto bg-teal-400 hover:bg-teal-500 text-white px-6 py-2 md:px-10 md:py-3 rounded-full font-bold text-sm md:text-lg shadow-lg transform hover:scale-105 transition duration-300">
                LIHAT SEMUA STRAPS
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:gap-6 mb-8 md:mb-12">
            @forelse($straps as $product)
            <div class="group bg-white border-2 md:border-4 border-white rounded-xl p-2 md:p-4 shadow-md transition-all duration-300 hover:-translate-y-1 md:hover:-translate-y-2 hover:shadow-xl">
                <div class="aspect-square flex items-center justify-center overflow-hidden rounded-lg">
                    @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:rotate-3 group-hover:scale-110">
                    @else
                    <svg class="w-8 h-8 md:w-16 md:h-16 text-gray-200 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <div class="mt-2 md:mt-3 text-center">
                    <p class="text-xs md:text-sm font-bold text-purple-800 line-clamp-1">{{ $product->name }}</p>
                    <p class="text-[10px] md:text-xs font-bold text-purple-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8">
                <p class="text-white text-sm md:text-lg">No phone strap products available yet.</p>
            </div>
            @endforelse
        </div>

        <h2 class="text-2xl md:text-6xl font-black text-white uppercase" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.2); letter-spacing: 0.05em;">
            STRAP PHONE THEME
        </h2>
    </div>
</section>


<section id="faq-section" class="py-8 md:py-16 bg-white">
    <div class="container mx-auto px-4 md:px-6">
        <h2 class="text-2xl md:text-4xl font-bold text-center mb-6 md:mb-12 text-purple-800">Frequently Asked Questions</h2>
        
        <div class="max-w-3xl mx-auto space-y-3 md:space-y-4">
            <div class="border-2 border-purple-100 rounded-xl md:rounded-2xl overflow-hidden shadow-sm">
                <button class="w-full p-4 md:p-5 text-left bg-purple-50 flex justify-between items-center group focus:outline-none" onclick="toggleFaq(1)">
                    <span class="font-bold text-sm md:text-base text-purple-900 group-hover:text-purple-600 transition">Berapa lama proses pembuatan produk custom?</span>
                    <svg id="icon-1" class="w-4 h-4 md:w-5 md:h-5 text-purple-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="faq-1" class="hidden p-4 md:p-5 bg-white text-xs md:text-base text-gray-600 border-t-2 border-purple-100 leading-relaxed">
                    Proses pembuatan aksesoris custom memakan waktu sekitar 1-3 hari kerja, tergantung pada tingkat kesulitan desain dan antrian pesanan.
                </div>
            </div>

            <div class="border-2 border-purple-100 rounded-xl md:rounded-2xl overflow-hidden shadow-sm">
                <button class="w-full p-4 md:p-5 text-left bg-purple-50 flex justify-between items-center group focus:outline-none" onclick="toggleFaq(2)">
                    <span class="font-bold text-sm md:text-base text-purple-900 group-hover:text-purple-600 transition">Apakah bisa dikirim ke seluruh Indonesia?</span>
                    <svg id="icon-2" class="w-4 h-4 md:w-5 md:h-5 text-purple-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="faq-2" class="hidden p-4 md:p-5 bg-white text-xs md:text-base text-gray-600 border-t-2 border-purple-100 leading-relaxed">
                    Ya, Pearlbeads melayani pengiriman ke seluruh wilayah Indonesia menggunakan ekspedisi terpercaya seperti J&T atau JNE.
                </div>
            </div>

            <div class="border-2 border-purple-100 rounded-xl md:rounded-2xl overflow-hidden shadow-sm">
                <button class="w-full p-4 md:p-5 text-left bg-purple-50 flex justify-between items-center group focus:outline-none" onclick="toggleFaq(3)">
                    <span class="font-bold text-sm md:text-base text-purple-900 group-hover:text-purple-600 transition">Bagaimana cara memesan lewat WhatsApp?</span>
                    <svg id="icon-3" class="w-4 h-4 md:w-5 md:h-5 text-purple-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="faq-3" class="hidden p-4 md:p-5 bg-white text-xs md:text-base text-gray-600 border-t-2 border-purple-100 leading-relaxed">
                    Pilih produk yang kamu suka, masukkan ke keranjang, lalu klik tombol "Checkout via WhatsApp". Kamu akan diminta mengisi nama & jadwal pengambilan, lalu otomatis diarahkan ke chat WA admin.
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Slider Styles */
    .slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out; }
    .slide.active { position: relative; opacity: 1; }
    
    /* Responsive Dots */
    .dot { width: 10px; height: 10px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); border: 2px solid white; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.3); }
    .dot:hover { background: rgba(255, 255, 255, 0.8); transform: scale(1.2); }
    .dot.active { background: white; width: 30px; border-radius: 5px; }

    @media (min-width: 768px) {
        .dot { width: 14px; height: 14px; border: 3px solid white; }
        .dot.active { width: 40px; border-radius: 7px; }
    }

    /* Product Card Styles */
    .product-card { backface-visibility: hidden; }
</style>

<script>
    // --- 1. SLIDER LOGIC ---
    @if($banners->count() > 1)
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = slides.length;
    let autoSlideInterval;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        if (index >= totalSlides) currentSlide = 0;
        if (index < 0) currentSlide = totalSlides - 1;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function nextSlide() { currentSlide++; showSlide(currentSlide); }
    function prevSlide() { currentSlide--; showSlide(currentSlide); }
    function startAutoSlide() { autoSlideInterval = setInterval(nextSlide, 3500); }
    function stopAutoSlide() { clearInterval(autoSlideInterval); }

    document.getElementById('prevSlide')?.addEventListener('click', () => { stopAutoSlide(); prevSlide(); startAutoSlide(); });
    document.getElementById('nextSlide')?.addEventListener('click', () => { stopAutoSlide(); nextSlide(); startAutoSlide(); });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => { stopAutoSlide(); currentSlide = index; showSlide(currentSlide); startAutoSlide(); });
    });

    startAutoSlide();
    const sliderContainer = document.getElementById('heroSlider');
    sliderContainer.addEventListener('mouseenter', stopAutoSlide);
    sliderContainer.addEventListener('mouseleave', startAutoSlide);
    @endif

    // --- 2. AUTH DATA FOR CART ---
    window.AUTH = {
        loggedIn: {{ Auth::check() ? 'true' : 'false' }},
        userId: {{ Auth::check() ? Auth::id() : 'null' }}
    };

    // --- 3. FAQ TOGGLE LOGIC ---
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
</script>

@endsection