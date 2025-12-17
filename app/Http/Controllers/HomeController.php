<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua produk aktif
        $products = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->get();
        
        $categories = Category::with('products')->get();
        
        // Ambil banner aktif, diurutkan berdasarkan order
        $banners = Banner::active()->ordered()->get();
        
        // Pisahkan produk berdasarkan kategori untuk tampilan
        $bracelets = $products->where('category.slug', 'bracelet')->take(4);
        $straps = $products->where('category.slug', 'phone-strap')->take(5);
        
        return view('home', compact('products', 'categories', 'bracelets', 'straps', 'banners'));
    }
}