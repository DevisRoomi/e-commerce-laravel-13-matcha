<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        $subtotal = Cart::instance('cart')->subtotal();

        // Coupon calculation
        $discount = 0;
        $coupon = Session::get('coupon');
        if ($coupon) {
            if ($coupon['type'] === 'percent') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discount = $coupon['value'];
            }
        }

        $subtotal_after_discount = max(0, $subtotal - $discount);
        $tax = $subtotal_after_discount * 0.11; // PPN 11%
        $shipping = ($subtotal_after_discount > 300000 || $items->isEmpty()) ? 0 : 20000;
        $total = $subtotal_after_discount + $tax + $shipping;

        return view('cart', compact(
            'items',
            'subtotal',
            'discount',
            'coupon',
            'tax',
            'shipping',
            'total'
        ));
    }

    public function add_to_cart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::whereKey($request->id)
            ->where('status', 1)
            ->where('stock_status', 'instock')
            ->firstOrFail();
        $price = (float) ($product->sale_price ?: $product->regular_price);
        $existing = Cart::instance('cart')->content()->firstWhere('id', $product->id);
        $requestedQuantity = (int) $request->quantity + (int) ($existing['qty'] ?? 0);

        if ($requestedQuantity > $product->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Jumlah produk melebihi stok tersedia.']);
        }

        Cart::instance('cart')->add(
            $product->id,
            $product->name,
            $request->quantity,
            $price,
            [
                'image' => $product->image,
                'slug' => $product->slug,
            ]
        );

        return redirect()->back()->with('status', 'Produk "' . $product->name . '" berhasil ditambahkan ke keranjang!');
    }

    public function increase_cart_quantity($rowId)
    {
        $cart = Cart::instance('cart')->getCart();
        if ($cart->has($rowId)) {
            $item = $cart->get($rowId);
            $product = Product::whereKey($item['id'])
                ->where('status', 1)
                ->where('stock_status', 'instock')
                ->first();

            if (! $product || $item['qty'] >= $product->quantity) {
                return redirect()->back()->withErrors(['quantity' => 'Jumlah produk melebihi stok tersedia.']);
            }

            Cart::instance('cart')->update($rowId, $item['qty'] + 1);
        }

        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $cart = Cart::instance('cart')->getCart();
        if ($cart->has($rowId)) {
            $item = $cart->get($rowId);
            Cart::instance('cart')->update($rowId, $item['qty'] - 1);
        }

        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('status', 'Item berhasil dihapus dari keranjang!');
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        Session::forget('coupon');
        return redirect()->back()->with('status', 'Keranjang belanja telah dikosongkan!');
    }

    public function apply_coupon_code(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = trim($request->coupon_code);
        $coupon = Coupon::where('code', $code)->where('status', 1)->first();

        if (!$coupon) {
            return redirect()->back()->withErrors(['coupon_code' => 'Kode kupon promo tidak valid!']);
        }

        if (Carbon::now()->gt(Carbon::parse($coupon->expiry_date)->endOfDay())) {
            return redirect()->back()->withErrors(['coupon_code' => 'Kupon ini sudah kadaluarsa!']);
        }

        $subtotal = Cart::instance('cart')->subtotal();
        if ($subtotal < $coupon->cart_value) {
            return redirect()->back()->withErrors([
                'coupon_code' => 'Minimal total belanja untuk kupon ini adalah Rp ' . number_format($coupon->cart_value, 0, ',', '.')
            ]);
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ]);

        return redirect()->back()->with('status', 'Kupon "' . $coupon->code . '" berhasil digunakan!');
    }

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        return redirect()->back()->with('status', 'Kupon berhasil dihapus!');
    }
}
