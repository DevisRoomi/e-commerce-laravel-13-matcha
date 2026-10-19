<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Cart::instance('wishlist')->content();
        return view('wishlist', compact('items'));
    }

    public function add_to_wishlist(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->id);

        Cart::instance('wishlist')->add(
            $product->id,
            $product->name,
            1,
            $request->price,
            [
                'image' => $product->image,
                'slug' => $product->slug,
            ]
        );

        return redirect()->back()->with('status', 'Produk "' . $product->name . '" berhasil disimpan ke Wishlist!');
    }

    public function remove_item($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back()->with('status', 'Item dihapus dari Wishlist!');
    }

    public function empty_wishlist()
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->back()->with('status', 'Wishlist berhasil dikosongkan!');
    }

    public function move_to_cart($rowId)
    {
        $wishlist = Cart::instance('wishlist')->getCart();
        if ($wishlist->has($rowId)) {
            $item = $wishlist->get($rowId);

            Cart::instance('cart')->add(
                $item['id'],
                $item['name'],
                1,
                $item['price'],
                $item['options']
            );

            Cart::instance('wishlist')->remove($rowId);

            return redirect()->back()->with('status', 'Produk "' . $item['name'] . '" dipindahkan ke Keranjang!');
        }

        return redirect()->back();
    }
}
