@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-4 md:p-6 mb-6 md:mb-8 border-l-4 border-purple-600 flex flex-col md:flex-row items-center justify-between">
    <div class="mb-4 md:mb-0 text-center md:text-left">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800">Welcome Back, Admin! 👋</h2>
        <p class="text-gray-500 text-xs md:text-sm mt-1">Here is what's happening with your store today.</p>
    </div>
    <div class="bg-purple-50 text-purple-700 px-3 py-1 md:px-4 md:py-2 rounded-lg font-semibold text-xs md:text-sm">
        {{ date('l, d F Y') }}
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-8">
    
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-2 md:mb-4">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs md:text-sm font-medium truncate">Total Products</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">{{ $totalProducts ?? 0 }}</h3>
    </div>

    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-2 md:mb-4">
            <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs md:text-sm font-medium truncate">Categories</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">{{ $totalCategories ?? 0 }}</h3>
    </div>

    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-2 md:mb-4">
            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs md:text-sm font-medium truncate">Active Items</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">{{ $activeProducts ?? 0 }}</h3>
    </div>

    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-2 md:mb-4">
            <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
        <p class="text-gray-500 text-xs md:text-sm font-medium truncate">Low Stock</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">{{ $lowStock ?? 0 }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
    
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-4 md:px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 text-sm md:text-base">Recent Products</h3>
            <a href="{{ route('admin.products.index') }}" class="text-xs md:text-sm text-purple-600 hover:text-purple-800 font-semibold">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs md:text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 md:px-6">Product</th>
                        <th class="px-4 py-3 md:px-6">Price</th>
                        <th class="px-4 py-3 md:px-6">Stock</th>
                        <th class="px-4 py-3 md:px-6">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProducts as $product)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3 md:px-6 font-medium text-gray-900 whitespace-nowrap flex items-center gap-2 md:gap-3">
                            <img src="{{ asset('images/products/' . $product->image) }}" class="w-8 h-8 md:w-10 md:h-10 rounded-lg object-cover bg-gray-100" onerror="this.src='https://via.placeholder.com/40'">
                            <span class="truncate max-w-[100px] md:max-w-none">{{ $product->name }}</span>
                        </td>
                        <td class="px-4 py-3 md:px-6 text-purple-600 font-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 md:px-6">
                            <span class="{{ $product->stock < 5 ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-4 py-3 md:px-6">
                            <span class="px-2 py-1 text-[10px] md:text-xs font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">No recent products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 h-fit">
        <h3 class="font-bold text-gray-800 mb-4 text-sm md:text-base">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.products.create') }}" class="flex items-center justify-center w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-xl font-semibold transition shadow-lg shadow-purple-200 text-sm md:text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Product
            </a>
            <a href="{{ route('admin.banners.create') }}" class="flex items-center justify-center w-full bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-3 rounded-xl font-semibold transition border border-blue-200 text-sm md:text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Upload Banner
            </a>
        </div>
    </div>

</div>

@endsection