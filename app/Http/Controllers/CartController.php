<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart     = $this->getCart();
        $products = [];
        $total    = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal   = $product->price * $item['quantity'];
                $total     += $subtotal;
                $products[] = [
                    'product'  => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = (int) $request->quantity;

        if ($quantity > $product->stock) {
            return back()->with('error', 'Quantidade solicitada excede o estoque disponível.');
        }

        $cart = $this->getCart();

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;

            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Quantidade total excede o estoque disponível.');
            }

            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = ['quantity' => $quantity];
        }

        $this->saveCart($cart);

        return back()->with('success', "{$product->name} adicionado ao carrinho!");
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = (int) $request->quantity;

        if ($quantity > $product->stock) {
            return back()->with('error', 'Quantidade solicitada excede o estoque disponível.');
        }

        $cart = $this->getCart();

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            $this->saveCart($cart);
        }

        return back()->with('success', 'Carrinho atualizado!');
    }

    public function remove(Product $product)
    {
        $cart = $this->getCart();
        unset($cart[$product->id]);
        $this->saveCart($cart);

        return back()->with('success', 'Item removido do carrinho.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Carrinho esvaziado.');
    }

    public function count(): int
    {
        return array_sum(array_column($this->getCart(), 'quantity'));
    }
}
