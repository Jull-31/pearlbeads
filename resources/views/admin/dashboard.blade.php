@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="relative bg-gradient-to-r from-purple-500 to-pink-500 rounded-3xl shadow-xl p-8 mb-10 overflow-hidden text-white">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full translate-x-20 -translate-y-20"></div>
    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -translate-x-10 translate-y-10"></div>

    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl md:text-4xl font-black mb-2 drop-shadow-md">Welcome Back, Admin! 👋</h2>
            <p class="text-purple-100 text-lg font-medium">Here's what's happening in your store today.</p>
        </div>
        <div class="bg-white/20 backdrop-blur-md border border-white/30 px-6 py-3 rounded-2xl shadow-sm">
            <span class="font-bold tracking-wide">{{ date('l, d F Y') }}</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
    <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
        <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl w-fit mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Products</p>
        <h3 class="text-3xl font-black text-gray-800">{{ $totalProducts ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
        <div class="p-3 bg-green-50 text-green-600 rounded-2xl w-fit mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
        </div>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Categories</p>
        <h3 class="text-3xl font-black text-gray-800">{{ $totalCategories ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
        <div class="p-3 bg-purple-50 text-purple-600 rounded-2xl w-fit mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Active</p>
        <h3 class="text-3xl font-black text-gray-800">{{ $activeProducts ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
        <div class="p-3 bg-red-50 text-red-600 rounded-2xl w-fit mb-4 group-hover:bg-red-600 group-hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Low Stock</p>
        <h3 class="text-3xl font-black text-gray-800">{{ $lowStock ?? 0 }}</h3>
    </div>
</div>

<div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100 mb-10">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="font-bold text-gray-800 text-xl">Sales Overview 📈</h3>
            <p class="text-gray-500 text-sm">Grafik penjualan barang bulan ini.</p>
        </div>
        <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
            <option>This Month</option>
            <option>Last Month</option>
        </select>
    </div>
    
    <div class="relative h-72 w-full">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 text-lg">Recent Products</h3>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-bold text-purple-600 hover:text-purple-800 transition">View All -></a>
        </div>
        
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Product</th>
                        <th class="px-6 py-4 font-semibold">Price</th>
                        <th class="px-6 py-4 font-semibold">Stock</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentProducts as $product)
                    <tr class="hover:bg-purple-50/50 transition-colors group">
                        <td class="px-6 py-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden shadow-sm">
                                <img src="{{ asset('images/products/' . $product->image) }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/40'">
                            </div>
                            <span class="font-bold text-gray-800">{{ $product->name }}</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-purple-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ $product->stock < 5 ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            No products found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 h-fit">
        <h3 class="font-bold text-gray-800 text-lg mb-6">Quick Actions</h3>
        <div class="space-y-4">
            <a href="{{ route('admin.products.create') }}" class="flex items-center justify-center w-full bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 text-white px-6 py-4 rounded-2xl font-bold transition-all shadow-lg shadow-purple-200 hover:shadow-purple-300 hover:-translate-y-1">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Product
            </a>
            <a href="{{ route('admin.banners.create') }}" class="flex items-center justify-center w-full bg-white text-gray-700 hover:text-purple-600 hover:bg-purple-50 px-6 py-4 rounded-2xl font-bold transition-all border-2 border-gray-100 hover:border-purple-200">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Upload Banner
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Data Dummy (Nanti bisa diganti data real dari database)
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(147, 51, 234, 0.5)'); // Ungu transparan
        gradient.addColorStop(1, 'rgba(236, 72, 153, 0.0)'); // Pink transparan

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                label: 'Total Penjualan (Rp)',
                // Pakai data asli dari Controller (Encode ke JSON biar dibaca JS)
                data: {{ json_encode($weeklySales) }}, 
                borderColor: '#9333ea',
                    borderColor: '#9333ea', // Warna Garis (Ungu)
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#9333ea',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4 // Garis melengkung halus
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f3f4f6' },
                        ticks: { font: { family: 'Poppins' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Poppins' } }
                    }
                }
            }
        });
    });
</script>

@endsection