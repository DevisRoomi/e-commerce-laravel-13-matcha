<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $page_size = $request->query('page_size', 12);
        $order = $request->query('order', -1);
        $search = $request->query('search', '');
        $f_brands = $request->query('brands', '');
        $f_categories = $request->query('categories', '');
        $min_price = $request->query('min_price', 0);
        $max_price = $request->query('max_price', 10000000);

        $query = Product::where('status', 1);

        // Search (Video 32)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('SKU', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Brands (Video 29)
        if (!empty($f_brands)) {
            $brands_arr = is_array($f_brands) ? $f_brands : explode(',', $f_brands);
            $query->whereIn('brand_id', $brands_arr);
        }

        // Filter by Categories (Video 30)
        if (!empty($f_categories)) {
            $categories_arr = is_array($f_categories) ? $f_categories : explode(',', $f_categories);
            $sub_ids = Category::whereIn('parent_id', $categories_arr)->pluck('id')->toArray();
            $all_target_cat_ids = array_unique(array_merge($categories_arr, $sub_ids));
            $query->whereIn('category_id', $all_target_cat_ids);
        }

        // Filter by Price (Video 31)
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->whereBetween('regular_price', [$min_price, $max_price]);
        }

        // Sorting (Video 28)
        switch ($order) {
            case 1:
                $query->orderBy('created_at', 'desc');
                break;
            case 2:
                $query->orderBy('created_at', 'asc');
                break;
            case 3:
                $query->orderBy('regular_price', 'asc');
                break;
            case 4:
                $query->orderBy('regular_price', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate($page_size)->withQueryString();

        $categories = Category::whereNull('parent_id')
            ->with(['subcategories' => fn($q) => $q->withCount('products')->where('status', 1)])
            ->withCount('products')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $brands = Brand::withCount('products')->where('status', 1)->orderBy('name', 'asc')->get();

        return view('shop.index', compact(
            'products',
            'categories',
            'brands',
            'page_size',
            'order',
            'search',
            'f_brands',
            'f_categories',
            'min_price',
            'max_price'
        ));
    }

    public function product_details($slug)
    {
        $product = Product::with(['category', 'brand'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $related_products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('shop.details', compact('product', 'related_products'));
    }
}
