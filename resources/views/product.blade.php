@extends('layouts.app')

@section('title', 'Products - Pearlbeads')

@section('content')

<section class="bg-gradient-to-r from-purple-500 to-pink-500 py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">Our Products</h1>
        <p class="text-xl text-white/90">Handmade accessories with love ❤️</p>
    </div>
</section>

<section class="bg-white shadow-md sticky top-0 z-40">
    <div class="container mx-auto px-6 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            <div class="flex items-center space-x-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                <a href="{{ route('product.index') }}" 
                   class="px-6 py-2 rounded-full font-semibold whitespace-nowrap transition {{ !request('category') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All Products ({{ $categories->sum('products_count') }})
                </a>
                
                @foreach($categories as $category)
                <a href="{{ route('product.index', ['category' => $category->id]) }}" 
                   class="px-6 py-2 rounded-full font-semibold whitespace-nowrap transition {{ request('category') == $category->id ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $category->name }} ({{ $category->products_count }})
                </a>
                @endforeach
            </div>

            <form action="{{ route('product.index') }}" method="GET" class="flex items-center w-full md:w-auto">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                
                <div class="relative w-full md:w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search products..." 
                           class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        
        @if(request('category') || request('search'))
        <div class="mb-6 flex items-center space-x-2 flex-wrap gap-y-2">
            <span class="text-gray-600 font-medium">Active filters:</span>
            
            @if(request('category'))
            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm flex items-center space-x-2 border border-purple-200">
                <span>{{ $categories->find(request('category'))->name }}</span>
                <a href="{{ route('product.index', ['search' => request('search')]) }}" class="hover:text-red-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </span>
            @endif
            
            @if(request('search'))
            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm flex items-center space-x-2 border border-purple-200">
                <span>Search: "{{ request('search') }}"</span>
                <a href="{{ route('product.index', ['category' => request('category')]) }}" class="hover:text-red-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </span>
            @endif
            
            <a href="{{ route('product.index') }}" class="text-red-500 hover:underline text-sm font-semibold ml-2">
                Clear all
            </a>
        </div>
        @endif

        <div class="mb-6">
            <p class="text-gray-600">
                Showing <span class="font-bold text-purple-600">{{ $products->count() }}</span> of 
                <span class="font-bold text-gray-800">{{ $products->total() }}</span> products
            </p>
        </div>

        @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach($products as $product)
            <div class="group bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-3 hover:scale-[1.03] hover:shadow-2xl border border-transparent hover:border-purple-200">
                
                <div class="relative aspect-square bg-gray-100 overflow-hidden">
                    @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif
                    
                    <div class="absolute top-3 left-3">
                        <span class="bg-purple-600/90 backdrop-blur-sm text-white text-[10px] md:text-xs px-3 py-1 rounded-full font-bold shadow-sm uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    @if($product->stock < 5 && $product->stock > 0)
                    <div class="absolute top-3 right-3">
                        <span class="bg-orange-500/90 backdrop-blur-sm text-white text-[10px] px-2 py-1 rounded-md font-bold animate-pulse">
                            Limited!
                        </span>
                    </div>
                    @endif
                </div>

                <div class="p-5">
                    <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1 line-clamp-1 group-hover:text-purple-600 transition-colors">
                        {{ $product->name }}
                    </h3>
                    
                    <p class="text-xs text-gray-500 mb-3 font-medium tracking-tight">
                        Stock: <span class="{{ $product->stock < 5 ? 'text-red-500' : 'text-green-600' }} font-bold">{{ $product->stock }} items</span>
                    </p>

                    <div class="flex items-center justify-between gap-2 mb-4">
                        <p class="text-xl font-black text-purple-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <button onclick="cart.addItem({
                        id: {{ $product->id }},
                        name: '{{ addslashes($product->name) }}',
                        price: {{ $product->price }},
                        image: '{{ $product->image }}'
                    })" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-black transition-all flex items-center justify-center space-x-2 shadow-md hover:shadow-purple-200 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="text-sm">Add to Cart</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-16 flex justify-center">
            {{ $products->links() }}
        </div>

        @else
        <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="bg-gray-50 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-gray-800 mb-2">Oops! No products found</h3>
            <p class="text-gray-500 mb-8 max-w-xs mx-auto text-sm">We couldn't find any products matching your current filters or search query.</p>
            <a href="{{ route('product.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-10 py-4 rounded-full font-bold transition shadow-lg inline-flex items-center space-x-2">
                <span>View All Products</span>
            </a>
        </div>
        @endif
    </div>
</section>

@endsection