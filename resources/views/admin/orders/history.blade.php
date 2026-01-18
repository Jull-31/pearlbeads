@extends('admin.layouts.app')
@section('title', 'Order History')
@section('content')

<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-black text-gray-800 tracking-tight">Riwayat Pesanan 📜</h2>
        <p class="text-gray-500 text-sm mt-1">Daftar semua pesanan yang sudah selesai atau ditolak.</p>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold">Order ID</th>
                    <th class="px-6 py-4 font-semibold">Customer Detail</th>
                    <th class="px-6 py-4 font-semibold">Items</th>
                    <th class="px-6 py-4 font-semibold">Total</th>
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-purple-50/30 transition-colors group">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800">#{{ $order->id }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y, H:i') }}
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="max-h-20 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-200">
                            <ul class="space-y-1">
                                @foreach($order->items as $item)
                                <li class="text-xs flex items-center text-gray-600">
                                    <span class="w-1.5 h-1.5 bg-purple-400 rounded-full mr-2"></span>
                                    {{ $item->product->name }} <span class="font-bold ml-1 text-purple-600">x{{ $item->quantity }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-black text-gray-700">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">
                        {{ $order->updated_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($order->status == 'approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Completed
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Rejected
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 bg-gray-50/50">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <p>Belum ada riwayat pesanan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        </div>
</div>

@endsection