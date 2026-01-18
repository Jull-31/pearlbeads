@extends('admin.layouts.app')
@section('title', 'Incoming Orders')
@section('content')

<h2 class="text-2xl font-bold text-gray-800 mb-6">Pesanan Masuk (Pending)</h2>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Items</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold">#{{ $order->id }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800">{{ $order->customer_name }}</p>
                        <p class="text-xs">{{ $order->pickup_date }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <ul class="list-disc list-inside text-xs">
                            @foreach($order->items as $item)
                            <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-6 py-4 font-bold text-purple-600">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-xs">{{ $order->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-xs font-bold shadow transition">
                                ACC ✅
                            </button>
                        </form>
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-bold shadow transition">
                                Tolak ❌
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-8">Belum ada pesanan baru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection