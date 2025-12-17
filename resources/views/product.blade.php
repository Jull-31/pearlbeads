@extends('layouts.app')

@section('title', 'Products - Pearlbeads')

@section('content')

<!-- Header Section -->
<section class="bg-gradient-to-r from-purple-500 to-pink-500 py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">Our Products</h1>
        <p class="text-xl text-white/90">Handmade accessories with love ❤️</p>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="bg-white shadow-md sticky top-0 z-40">
    <div class="container mx-auto px-6 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            <!-- Category Filter -->
            <div class="flex items-center space-x-2 overflow-x-auto w-full md:w-auto">
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

            <!-- Search Box -->
            <form action="{{ route('product.index') }}" method="GET" class="flex items-center w-full md:w-auto">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                
                <div class="relative w-full md:w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search products..." 
                           class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:ring-2 focus:ring-purple-500 focus:border-transparent">
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

<!-- Products Grid Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        
        <!-- Active Filters -->
        @if(request('category') || request('search'))
        <div class="mb-6 flex items-center space-x-2">
            <span class="text-gray-600">Active filters:</span>
            
            @if(request('category'))
            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm flex items-center space-x-2">
                <span>{{ $categories->find(request('category'))->name }}</span>
                <a href="{{ route('product.index', ['search' => request('search')]) }}" class="hover:text-purple-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </span>
            @endif
            
            @if(request('search'))
            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm flex items-center space-x-2">
                <span>Search: "{{ request('search') }}"</span>
                <a href="{{ route('product.index', ['category' => request('category')]) }}" class="hover:text-purple-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </span>
            @endif
            
            <a href="{{ route('product.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">
                Clear all
            </a>
        </div>
        @endif

        <!-- Products Count -->
        <div class="mb-6">
            <p class="text-gray-600">
                Showing <span class="font-semibold text-gray-800">{{ $products->count() }}</span> of 
                <span class="font-semibold text-gray-800">{{ $products->total() }}</span> products
            </p>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 duration-300">
                <!-- Product Image -->
                <div class="relative aspect-square bg-gray-100">
                    @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Category Badge -->
                    <div class="absolute top-2 left-2">
                        <span class="bg-purple-600 text-white text-xs px-3 py-1 rounded-full font-semibold">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    <!-- Stock Badge -->
                    @if($product->stock < 5)
                    <div class="absolute top-2 right-2">
                        <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                            Low Stock!
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                    
                    @if($product->description)
                    <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $product->description }}</p>
                    @endif

                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <p class="text-2xl font-bold text-purple-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500">Stock: {{ $product->stock }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <button class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg font-semibold transition">
                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Add to Cart
                        </button>
                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-3 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>

        @else
        <!-- No Products Found -->
        <div class="text-center py-20">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">No products found</h3>
            <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
            <a href="{{ route('product.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-full font-semibold transition">
                View All Products
            </a>
        </div>
        @endif
    </div>
</section>

@endsection