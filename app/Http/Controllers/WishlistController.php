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
        ]);

        $product = Product::whereKey($request->id)
            ->where('status', 1)
            ->where('stock_status', 'instock')
            ->firstOrFail();
        $price = (float) ($product->sale_price ?: $product->regular_price);

        Cart::instance('wishlist')->add(
            $product->id,
            $product->name,
            1,
            $price,
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
            $product = Product::whereKey($item['id'])
                ->where('status', 1)
                ->where('stock_status', 'instock')
                ->first();

            if (! $product || $product->quantity < 1) {
                return redirect()->back()->withErrors(['product' => 'Produk sudah tidak tersedia.']);
            }

            $price = (float) ($product->sale_price ?: $product->regular_price);
            Cart::instance('cart')->add(
                $product->id,
                $product->name,
                1,
                $price,
                [
                    'image' => $product->image,
                    'slug' => $product->slug,
                ]
            );

            Cart::instance('wishlist')->remove($rowId);

            return redirect()->back()->with('status', 'Produk "' . $product->name . '" dipindahkan ke Keranjang!');
        }

        return redirect()->back();
    }
}
