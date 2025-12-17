<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStock = Product::where('stock', '<', 5)->count();
        
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'activeProducts',
            'lowStock',
            'recentProducts'
        ));
    }
}