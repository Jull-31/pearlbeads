@extends('layouts.app')

@section('title', 'Home - Pearlbeads')

@section('content')

<!-- Hero Slider Section - PURE IMAGE ONLY -->
<section class="relative overflow-hidden" style="min-height: 500px;">
    <!-- Slider Container -->
    <div id="heroSlider" class="relative w-full h-full">
        
        @forelse($banners as $index => $banner)
        <!-- Slide {{ $index + 1 }}: {{ $banner->title }} -->
        <div class="slide {{ $index === 0 ? 'active' : '' }}" style="background: {{ $banner->background_color }};">
            
            @if($banner->image)
            <!-- PURE Banner Image - Full Width, No Text -->
            <div class="w-full h-full min-h-[500px] flex items-center justify-center">
                <img src="{{ asset('images/banners/' . $banner->image) }}" 
                     alt="{{ $banner->title }}"
                     class="w-full h-full object-cover"
                     style="max-height: 600px; object-fit: cover;"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-center text-gray-500 py-20\'><p>Banner image not found</p></div>'">
            </div>
            @else
            <!-- Fallback if no image -->
            <div class="w-full h-full min-h-[500px] flex items-center justify-center" style="background: {{ $banner->background_color }};">
                <div class="text-center p-8">
                    <h1 class="text-6xl font-bold mb-4 text-white drop-shadow-lg">{{ $banner->title }}</h1>
                    @if($banner->subtitle)
                    <p class="text-3xl text-white">{{ $banner->subtitle }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @empty
        <!-- Default Slide if No Banners -->
        <div class="slide active" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="container mx-auto px-6 py-16 relative z-10">
                <div class="text-center text-white min-h-[400px] flex flex-col justify-center">
                    <h1 class="text-6xl font-bold mb-4">Welcome to Pearlbeads.co</h1>
                    <p class="text-2xl mb-6">Handmade Accessories with Love</p>
                    <p class="text-gray-200">No banners yet. Please add banners from admin panel.</p>
                    @if(auth()->check() && auth()->user()->is_admin)
                    <div class="mt-8">
                        <a href="{{ route('admin.banners.index') }}" class="bg-white text-purple-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                            Add Banner
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Navigation Arrows (only show if more than 1 banner) -->
    @if($banners->count() > 1)
    <button id="prevSlide" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white p-4 rounded-full shadow-xl z-20 transition hover:scale-110">
        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button id="nextSlide" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white p-4 rounded-full shadow-xl z-20 transition hover:scale-110">
        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Dots Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
        @foreach($banners as $index => $banner)
        <button class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
        @endforeach
    </div>
    @endif
</section>

<style>
    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        min-height: 500px;
    }

    .slide.active {
        position: relative;
        opacity: 1;
    }

    .dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: 3px solid white;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .dot:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.2);
    }

    .dot.active {
        background: white;
        width: 40px;
        border-radius: 7px;
    }
</style>

<script>
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

    function nextSlide() {
        currentSlide++;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide--;
        showSlide(currentSlide);
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 5000); // Auto slide every 5 seconds
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    // Event Listeners
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    
    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            prevSlide();
            startAutoSlide();
        });

        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            nextSlide();
            startAutoSlide();
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            stopAutoSlide();
            currentSlide = index;
            showSlide(currentSlide);
            startAutoSlide();
        });
    });

    // Auto slide
    startAutoSlide();

    // Pause on hover
    const slider = document.getElementById('heroSlider');
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
@endif
</script>

<!-- Our Products Section -->
<section class="py-16">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12" style="color: #87CEEB;">OUR PRODUCT</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($bracelets as $product)
            <!-- Product Card -->
            <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden" style="border: 3px solid #87CEEB;">
                <div class="p-6 bg-gray-100">
                    <div class="aspect-square flex items-center justify-center bg-white rounded-lg overflow-hidden">
                        @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="max-h-full max-w-full object-contain">
                        @else
                        <div class="text-gray-400 text-center">
                            <svg class="w-20 h-20 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm">No Image</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold mb-2" style="font-style: italic;">{{ $product->name }}</h3>
                    <p class="text-purple-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-gray-500 text-sm mt-1">Stock: {{ $product->stock }}</p>
                </div>
            </div>
            @empty
            <!-- Jika tidak ada produk -->
            <div class="col-span-4 text-center py-12">
                <p class="text-gray-500 text-lg">No bracelet products available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Strap Phone Theme Section -->
<section class="gradient-bg py-16 mt-16">
    <div class="container mx-auto px-6">
       <!-- Top Navigation -->
<div class="text-center mb-8">
    <div class="flex justify-center items-center space-x-6">
        <div class="hidden md:block w-32 h-1 bg-blue-300 rounded"></div>
        <div class="hidden md:block w-32 h-1 bg-blue-300 rounded"></div>
        
        <!-- Product Button - Link to All Products -->
        <a href="{{ route('product.index') }}" 
           class="bg-blue-400 hover:bg-blue-500 text-white px-10 py-3 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
            ALL PRODUCTS
        </a>
        
        <div class="hidden md:block w-32 h-1 bg-blue-300 rounded"></div>
        <div class="hidden md:block w-32 h-1 bg-blue-300 rounded"></div>
    </div>
</div>

<!-- See All Button - Link to Phone Strap Category -->
<div class="text-center mb-10">
    @php
        $phoneStrapCategory = $categories->where('slug', 'phone-strap')->first();
    @endphp
    
    @if($phoneStrapCategory)
    <a href="{{ route('product.index', ['category' => $phoneStrapCategory->id]) }}" 
       class="inline-block bg-teal-400 hover:bg-teal-500 text-white px-16 py-4 rounded-full font-bold text-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
        SEE ALL STRAPS
    </a>
    @else
    <a href="{{ route('product.index') }}" 
       class="inline-block bg-teal-400 hover:bg-teal-500 text-white px-16 py-4 rounded-full font-bold text-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
        SEE ALL PRODUCTS
    </a>
    @endif
</div>

        <!-- Phone Strap Products -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-8">
            @forelse($straps as $product)
            <div class="bg-white border-4 border-white rounded-xl p-4 shadow-lg">
                <div class="aspect-square flex items-center justify-center overflow-hidden rounded-lg">
                    @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="max-h-full max-w-full object-contain">
                    @else
                    <div class="text-gray-400 text-center">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="mt-2 text-center">
                    <p class="text-sm font-semibold text-purple-800">{{ $product->name }}</p>
                    <p class="text-xs text-purple-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-5 text-center py-8">
                <p class="text-white text-lg">No phone strap products available yet.</p>
            </div>
            @endforelse
        </div>

        <!-- Section Title -->
        <div class="text-center">
            <h2 class="text-6xl font-bold text-white" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.2); letter-spacing: 0.05em;">
                STRAP PHONE THEME
            </h2>
        </div>
    </div>
</section>
@endsection