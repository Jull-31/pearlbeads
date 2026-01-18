<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order; // Tambahkan ini biar bisa baca pesanan
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Data Statistik Utama
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStock = Product::where('stock', '<', 5)->count();
        
        // Ambil 5 produk terbaru untuk tabel
        $recentProducts = Product::latest()->take(5)->get();

        // 2. LOGIKA GRAFIK REAL-TIME (Penjualan Bulan Ini)
        // Siapkan wadah kosong untuk 4 minggu: [Minggu1, Minggu2, Minggu3, Minggu4]
        $weeklySales = [0, 0, 0, 0]; 

        // Ambil semua order yang SUDAH DI-ACC (approved) bulan ini
        $orders = Order::where('status', 'approved')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->get();

        // Masukkan uangnya ke minggu yang sesuai
        foreach ($orders as $order) {
            // Cek tanggal berapa order dibuat (1-31)
            $day = $order->created_at->day;
            
            // Tentukan masuk minggu ke berapa (Array index mulai dari 0)
            if ($day <= 7) {
                $weeklySales[0] += $order->total_price; // Minggu 1 (Tgl 1-7)
            } elseif ($day <= 14) {
                $weeklySales[1] += $order->total_price; // Minggu 2 (Tgl 8-14)
            } elseif ($day <= 21) {
                $weeklySales[2] += $order->total_price; // Minggu 3 (Tgl 15-21)
            } else {
                $weeklySales[3] += $order->total_price; // Minggu 4 (Sisanya)
            }
        }

        // Kirim semua data ke View dashboard
        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'activeProducts', 
            'lowStock', 
            'recentProducts',
            'weeklySales' // <-- Data grafik dikirim ke sini
        ));
    }
}