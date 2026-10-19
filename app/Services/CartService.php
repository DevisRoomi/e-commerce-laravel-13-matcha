<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $instance = 'cart';
    protected ?string $lastRowId = null;

    public function instance(string $name = 'cart'): self
    {
        $this->instance = $name;
        return $this;
    }

    public function getCart(): Collection
    {
        $cart = Session::get('cart_' . $this->instance);

        if ($cart instanceof Collection) {
            return $cart;
        }

        return collect($cart ?? []);
    }

    public function add($id, string $name, $quantity, $price, array $options = [], $tax = 0): self
    {
        $cart = $this->getCart();
        $rowId = md5($id . serialize($options));

        $quantity = (int) $quantity;
        $price = (float) $price;

        if ($cart->has($rowId)) {
            $existing = $cart->get($rowId);
            $newQty = $existing['qty'] + $quantity;
            $cart->put($rowId, [
                'rowId' => $rowId,
                'id' => $id,
                'name' => $name,
                'qty' => $newQty,
                'price' => $price,
                'options' => $options,
                'subtotal' => $price * $newQty,
            ]);
        } else {
            $cart->put($rowId, [
                'rowId' => $rowId,
                'id' => $id,
                'name' => $name,
                'qty' => $quantity,
                'price' => $price,
                'options' => $options,
                'subtotal' => $price * $quantity,
            ]);
        }

        $this->lastRowId = $rowId;
        Session::put('cart_' . $this->instance, $cart);

        return $this;
    }

    public function content(): Collection
    {
        return $this->getCart();
    }

    public function count(): int
    {
        return (int) $this->getCart()->sum('qty');
    }

    public function subtotal(): float
    {
        return (float) $this->getCart()->sum('subtotal');
    }

    public function total(): float
    {
        return (float) $this->getCart()->sum('subtotal');
    }

    public function update(string $rowId, $qty): bool
    {
        $cart = $this->getCart();

        if (!$cart->has($rowId)) {
            return false;
        }

        $qty = (int) $qty;
        if ($qty <= 0) {
            $this->remove($rowId);
            return true;
        }

        $item = $cart->get($rowId);
        $item['qty'] = $qty;
        $item['subtotal'] = $item['price'] * $qty;

        $cart->put($rowId, $item);
        Session::put('cart_' . $this->instance, $cart);

        return true;
    }

    public function remove(string $rowId): void
    {
        $cart = $this->getCart();
        $cart->forget($rowId);
        Session::put('cart_' . $this->instance, $cart);
    }

    public function destroy(): void
    {
        Session::forget('cart_' . $this->instance);
    }
}
