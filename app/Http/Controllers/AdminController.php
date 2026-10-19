<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands(Request $request)
    {
        $brands = Brand::when($request->query('name'), function ($query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.brands', compact('brands'));
    }

    public function brand_add()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:brands,slug|max:255',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug ?: $request->name);
        $brand->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_ext = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_ext;

            $destinationPath = public_path('uploads/brands');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $file_name);

            // Thumbnail
            $this->generateThumbnailImage($destinationPath . '/' . $file_name, $file_name, 'brands', 124, 124);
            $brand->image = $file_name;
        }

        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Merek baru berhasil ditambahkan!');
    }

    public function brand_edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:brands,slug,' . $id,
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug ?: $request->name);
        $brand->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old files
            if ($brand->image) {
                if (File::exists(public_path('uploads/brands/' . $brand->image))) {
                    File::delete(public_path('uploads/brands/' . $brand->image));
                }
                if (File::exists(public_path('uploads/brands/thumbnails/' . $brand->image))) {
                    File::delete(public_path('uploads/brands/thumbnails/' . $brand->image));
                }
            }

            $image = $request->file('image');
            $file_ext = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_ext;

            $destinationPath = public_path('uploads/brands');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $file_name);

            // Thumbnail
            $this->generateThumbnailImage($destinationPath . '/' . $file_name, $file_name, 'brands', 124, 124);
            $brand->image = $file_name;
        }

        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Merek berhasil diperbarui!');
    }

    public function brand_delete($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->image) {
            if (File::exists(public_path('uploads/brands/' . $brand->image))) {
                File::delete(public_path('uploads/brands/' . $brand->image));
            }
            if (File::exists(public_path('uploads/brands/thumbnails/' . $brand->image))) {
                File::delete(public_path('uploads/brands/thumbnails/' . $brand->image));
            }
        }

        $brand->delete();

        return redirect()->route('admin.brands')->with('status', 'Merek berhasil dihapus!');
    }

    public function categories(Request $request)
    {
        $categories = Category::with('parent')
            ->when($request->query('name'), function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        $parent_categories = Category::whereNull('parent_id')->orderBy('name', 'asc')->get();
        return view('admin.category-add', compact('parent_categories'));
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories,slug|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug ?: $request->name);
        $category->parent_id = $request->parent_id ?: null;
        $category->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_ext = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_ext;

            $destinationPath = public_path('uploads/categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $file_name);

            // Thumbnail
            $this->generateThumbnailImage($destinationPath . '/' . $file_name, $file_name, 'categories', 124, 124);
            $category->image = $file_name;
        }

        $category->save();

        return redirect()->route('admin.categories')->with('status', 'Kategori baru berhasil ditambahkan!');
    }

    public function category_edit($id)
    {
        $category = Category::findOrFail($id);
        $parent_categories = Category::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.category-edit', compact('category', 'parent_categories'));
    }

    public function category_update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->slug ?: $request->name);
        $category->parent_id = $request->parent_id ?: null;
        $category->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old files
            if ($category->image) {
                if (File::exists(public_path('uploads/categories/' . $category->image))) {
                    File::delete(public_path('uploads/categories/' . $category->image));
                }
                if (File::exists(public_path('uploads/categories/thumbnails/' . $category->image))) {
                    File::delete(public_path('uploads/categories/thumbnails/' . $category->image));
                }
            }

            $image = $request->file('image');
            $file_ext = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_ext;

            $destinationPath = public_path('uploads/categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $file_name);

            // Thumbnail
            $this->generateThumbnailImage($destinationPath . '/' . $file_name, $file_name, 'categories', 124, 124);
            $category->image = $file_name;
        }

        $category->save();

        return redirect()->route('admin.categories')->with('status', 'Kategori berhasil diperbarui!');
    }

    public function category_delete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            if (File::exists(public_path('uploads/categories/' . $category->image))) {
                File::delete(public_path('uploads/categories/' . $category->image));
            }
            if (File::exists(public_path('uploads/categories/thumbnails/' . $category->image))) {
                File::delete(public_path('uploads/categories/thumbnails/' . $category->image));
            }
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('status', 'Kategori berhasil dihapus!');
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
