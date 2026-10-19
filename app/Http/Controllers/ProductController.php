<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();

        $query = Product::with(['category', 'brand']);

        // Search by name or SKU
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('SKU', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by Brand
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Filter by Status (0 for Draft, 1 for Published)
        if ($request->has('status') && $request->status !== '' && $request->status !== null) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.products', compact('products', 'categories', 'brands'));
    }

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:products,slug|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'SKU' => 'required|max:100',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'nullable|boolean',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'images.*' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'nullable|boolean',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug ?: $request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->has('featured') ? 1 : 0;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id ?: null;
        $product->brand_id = $request->brand_id ?: null;
        $product->status = $request->has('status') ? 1 : 0;

        // Main Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_ext = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_ext;

            $destinationPath = public_path('uploads/products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $file_name);

            // Thumbnail
            $this->generateThumbnailImage($destinationPath . '/' . $file_name, $file_name, 'products', 124, 124);
            $product->image = $file_name;
        }

        // Gallery Images
        $gallery_arr = [];
        if ($request->hasFile('images')) {
            $counter = 1;
            $destinationPath = public_path('uploads/products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $g_ext = $file->extension();
                $g_name = Carbon::now()->timestamp . '-' . $counter . '.' . $g_ext;
                $file->move($destinationPath, $g_name);

                $this->generateThumbnailImage($destinationPath . '/' . $g_name, $g_name, 'products', 124, 124);
                $gallery_arr[] = $g_name;
                $counter++;
            }
            $product->images = implode(',', $gallery_arr);
        }

        $product->save();

        return redirect()->route('admin.products')->with('status', 'Produk berhasil ditambahkan!');
    }

    public function product_edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    public function product_update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:products,slug,' . $id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'SKU' => 'required|max:100',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'nullable|boolean',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'images.*' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'nullable|boolean',
        ]);

        $product->name = $request->name;
        $product->slug = Str::slug($request->slug ?: $request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->has('featured') ? 1 : 0;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id ?: null;
        $product->brand_id = $request->brand_id ?: null;
        $product->status = $request->has('status') ? 1 : 0;

        // Main Image Update
        if ($request->hasFile('image')) {
            if ($product->image) {
                if (File::exists(public_path('uploads/products/' . $product->image))) {
                    File::delete(public_path('uploads/products/' . $product->image));
                }
                if (File::exists(public_path('uploads/products/thumbnails/' . $product->image))) {
                    File::delete(public_path('uploads/products/thumbnails/' . $product->image));
                }
            }

            $image = $request->file('image');
            $file_ext = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_ext;

            $destinationPath = public_path('uploads/products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $file_name);

            $this->generateThumbnailImage($destinationPath . '/' . $file_name, $file_name, 'products', 124, 124);
            $product->image = $file_name;
        }

        // Gallery Images Update
        if ($request->hasFile('images')) {
            if ($product->images) {
                $old_images = explode(',', $product->images);
                foreach ($old_images as $old_img) {
                    if (File::exists(public_path('uploads/products/' . $old_img))) {
                        File::delete(public_path('uploads/products/' . $old_img));
                    }
                    if (File::exists(public_path('uploads/products/thumbnails/' . $old_img))) {
                        File::delete(public_path('uploads/products/thumbnails/' . $old_img));
                    }
                }
            }

            $gallery_arr = [];
            $counter = 1;
            $destinationPath = public_path('uploads/products');

            foreach ($request->file('images') as $file) {
                $g_ext = $file->extension();
                $g_name = Carbon::now()->timestamp . '-' . $counter . '.' . $g_ext;
                $file->move($destinationPath, $g_name);

                $this->generateThumbnailImage($destinationPath . '/' . $g_name, $g_name, 'products', 124, 124);
                $gallery_arr[] = $g_name;
                $counter++;
            }
            $product->images = implode(',', $gallery_arr);
        }

        $product->save();

        return redirect()->route('admin.products')->with('status', 'Produk berhasil diperbarui!');
    }

    public function product_delete($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            if (File::exists(public_path('uploads/products/' . $product->image))) {
                File::delete(public_path('uploads/products/' . $product->image));
            }
            if (File::exists(public_path('uploads/products/thumbnails/' . $product->image))) {
                File::delete(public_path('uploads/products/thumbnails/' . $product->image));
            }
        }

        if ($product->images) {
            $images = explode(',', $product->images);
            foreach ($images as $img) {
                if (File::exists(public_path('uploads/products/' . $img))) {
                    File::delete(public_path('uploads/products/' . $img));
                }
                if (File::exists(public_path('uploads/products/thumbnails/' . $img))) {
                    File::delete(public_path('uploads/products/thumbnails/' . $img));
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products')->with('status', 'Produk berhasil dihapus!');
    }

    public function product_bulk_delete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->ids)->get();

        foreach ($products as $product) {
            if ($product->image) {
                if (File::exists(public_path('uploads/products/' . $product->image))) {
                    File::delete(public_path('uploads/products/' . $product->image));
                }
                if (File::exists(public_path('uploads/products/thumbnails/' . $product->image))) {
                    File::delete(public_path('uploads/products/thumbnails/' . $product->image));
                }
            }

            if ($product->images) {
                $images = explode(',', $product->images);
                foreach ($images as $img) {
                    if (File::exists(public_path('uploads/products/' . $img))) {
                        File::delete(public_path('uploads/products/' . $img));
                    }
                    if (File::exists(public_path('uploads/products/thumbnails/' . $img))) {
                        File::delete(public_path('uploads/products/thumbnails/' . $img));
                    }
                }
            }

            $product->delete();
        }

        return redirect()->route('admin.products')->with('status', count($request->ids) . ' produk berhasil dihapus!');
    }

    public function product_export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function generateThumbnailImage($filePath, $image_name, $folder, $width = 124, $height = 124)
    {
        $destinationPath = public_path('uploads/' . $folder . '/thumbnails');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $img = Image::decode($filePath);
        $img->resize($width, $height);
        $img->save($destinationPath . '/' . $image_name);
    }
}
