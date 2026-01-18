@extends('layouts.app')

@section('title', 'Products - Pearlbeads')

@section('content')

<div class="container mx-auto px-4 md:px-6 pt-6 pb-4">
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-[2.5rem] shadow-xl py-14 md:py-20 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -translate-x-10 -translate-y-10"></div>
        <div class="absolute bottom-0 right-0 w-48 h-48 bg-white opacity-10 rounded-full translate-x-10 translate-y-10"></div>
        
        <div class="relative z-10">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-3 md:mb-4 drop-shadow-md tracking-tight">
                Our Products
            </h1>
            <p class="text-lg md:text-xl text-white/90 font-medium tracking-wide">
                Handmade accessories with love ❤️
            </p>
        </div>
    </div>
</div>

<section class="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 z-40 border-b border-gray-100">
    <div class="container mx-auto px-4 md:px-6 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            <div class="flex items-center space-x-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-hide">
                <a href="{{ route('product.index') }}" 
                   class="px-5 py-2 rounded-full font-bold text-sm whitespace-nowrap transition-all shadow-sm
                   {{ !request('category') ? 'bg-purple-600 text-white shadow-purple-200 ring-2 ring-purple-600 ring-offset-2' : 'bg-gray-100 text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                   All Products <span class="ml-1 opacity-80 text-xs">({{ $categories->sum('products_count') }})</span>
                </a>
                
                @foreach($categories as $category)
                <a href="{{ route('product.index', ['category' => $category->id]) }}" 
                   class="px-5 py-2 rounded-full font-bold text-sm whitespace-nowrap transition-all shadow-sm
                   {{ request('category') == $category->id ? 'bg-purple-600 text-white shadow-purple-200 ring-2 ring-purple-600 ring-offset-2' : 'bg-gray-100 text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                   {{ $category->name }} <span class="ml-1 opacity-80 text-xs">({{ $category->products_count }})</span>
                </a>
                @endforeach
            </div>

            <form action="{{ route('product.index') }}" method="GET" class="flex items-center w-full md:w-auto">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                
                <div class="relative w-full md:w-72">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search accessories..." 
                           class="w-full pl-5 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-full focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-sm transition-all hover:bg-white">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 p-1.5 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 md:px-6">
        
        @if(request('category') || request('search'))
        <div class="mb-8 flex items-center flex-wrap gap-2">
            <span class="text-gray-500 text-sm font-medium mr-2">Filters applied:</span>
            
            @if(request('category'))
            <span class="bg-white text-purple-700 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm flex items-center space-x-2 border border-purple-100">
                <span>📂 {{ $categories->find(request('category'))->name }}</span>
                <a href="{{ route('product.index', ['search' => request('search')]) }}" class="hover:text-red-500 transition ml-2 p-0.5 hover:bg-red-50 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </span>
            @endif
            
            @if(request('search'))
            <span class="bg-white text-purple-700 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm flex items-center space-x-2 border border-purple-100">
                <span>🔍 "{{ request('search') }}"</span>
                <a href="{{ route('product.index', ['category' => request('category')]) }}" class="hover:text-red-500 transition ml-2 p-0.5 hover:bg-red-50 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </span>
            @endif
            
            <a href="{{ route('product.index') }}" class="text-gray-400 hover:text-red-500 text-sm font-semibold ml-2 underline decoration-dashed hover:decoration-solid">
                Reset all
            </a>
        </div>
        @endif

        <div class="mb-6 flex justify-between items-end">
            <div>
                <h2 class="text-gray-800 font-bold text-xl">Catalog</h2>
                <p class="text-gray-500 text-sm mt-1">
                    Showing <span class="font-bold text-purple-600">{{ $products->count() }}</span> of 
                    <span class="font-bold text-gray-800">{{ $products->total() }}</span> items
                </p>
            </div>
        </div>

        @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
            @foreach($products as $product)
            <div class="group bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 overflow-hidden flex flex-col h-full">
                
                <div class="relative aspect-square bg-gray-50 overflow-hidden">
                    @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                    
                    <div class="absolute top-3 left-3">
                        <span class="bg-white/90 backdrop-blur-md text-purple-800 text-[10px] md:text-xs px-3 py-1 rounded-full font-bold shadow-sm border border-purple-100">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    @if($product->stock < 5 && $product->stock > 0)
                    <div class="absolute top-3 right-3">
                        <span class="bg-red-500/90 text-white text-[10px] px-2 py-1 rounded-md font-bold shadow-sm animate-pulse">
                            Hurry!
                        </span>
                    </div>
                    @endif

                    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:flex items-center justify-center">
                         <button onclick="cart.addItem({
                            id: {{ $product->id }},
                            name: '{{ addslashes($product->name) }}',
                            price: {{ $product->price }},
                            image: '{{ $product->image }}'
                        })" class="bg-white text-purple-600 px-6 py-2 rounded-full font-bold shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all hover:bg-purple-600 hover:text-white">
                            + Add to Cart
                        </button>
                    </div>
                </div>

                <div class="p-4 flex flex-col flex-1">
                    <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-1 line-clamp-2 leading-tight group-hover:text-purple-600 transition-colors">
                        {{ $product->name }}
                    </h3>
                    
                    <div class="mt-auto pt-3">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-lg md:text-xl font-black text-purple-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-[10px] md:text-xs font-medium text-gray-400">
                                Stock: {{ $product->stock }}
                            </span>
                        </div>

                        <button onclick="cart.addItem({
                            id: {{ $product->id }},
                            name: '{{ addslashes($product->name) }}',
                            price: {{ $product->price }},
                            image: '{{ $product->image }}'
                        })" class="md:hidden w-full bg-purple-100 hover:bg-purple-600 text-purple-700 hover:text-white py-2 rounded-xl font-bold text-sm transition-all active:scale-95 flex items-center justify-center gap-2">
                            <span>Add +</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-16 flex justify-center">
            {{ $products->links() }}
        </div>

        @else
        <div class="text-center py-24 bg-white rounded-[2rem] shadow-sm border border-gray-100 mx-auto max-w-2xl">
            <div class="bg-gray-50 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-4xl">🧐</span>
            </div>
            <h3 class="text-2xl font-black text-gray-800 mb-2">No products found</h3>
            <p class="text-gray-500 mb-8 px-6">
                We couldn't find matches for your current filters. Try changing keywords or category.
            </p>
            <a href="{{ route('product.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-full font-bold transition shadow-lg shadow-purple-200 inline-flex items-center gap-2">
                <span>Clear Filters</span>
            </a>
        </div>
        @endif
    </div>
</section>

@endsection