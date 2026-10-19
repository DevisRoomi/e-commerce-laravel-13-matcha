<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->withCount('products')->where('status', 1)->take(8)->get();
        $featured_products = Product::with(['category', 'brand'])->where('featured', 1)->where('status', 1)->take(8)->get();
        $sale_products = Product::with(['category', 'brand'])->whereNotNull('sale_price')->where('status', 1)->take(8)->get();

        return view('index', compact('categories', 'featured_products', 'sale_products'));
    }
}
