<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. FUNGSI UNTUK MENERIMA PESANAN DARI CART.JS (API)
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'customer_name' => $request->name,
                'customer_phone' => '6283836295352', // Bisa diganti inputan user kalau mau
                'pickup_date' => $request->pickup_time,
                'total_price' => $request->total,
                'status' => 'pending'
            ]);

            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // 2. HALAMAN DAFTAR PESANAN MASUK (MENU "ACC BARANG")
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('admin.orders.index', compact('orders'));
    }

    // 3. HALAMAN RIWAYAT (MENU "HISTORY")
    public function history()
    {
        $orders = Order::with('items.product')
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();
            
        return view('admin.orders.history', compact('orders'));
    }

    // 4. FUNGSI ACC / TOLAK PESANAN
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        // Kalau di-ACC, kurangi stok produk
        if ($request->status == 'approved') {
            foreach ($order->items as $item) {
                $item->product->decrement('stock', $item->quantity);
            }
        }

        return redirect()->back()->with('success', 'Order status updated!');
    }
}