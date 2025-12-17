<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories
        $categories = Category::withCount('products')->get();
        
        // Query products
        $query = Product::where('is_active', true)->with('category');
        
        // Filter by category if selected
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Get products with pagination
        $products = $query->latest()->paginate(12);
        
        return view('product', compact('products', 'categories'));
    }
}