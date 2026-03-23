<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $products = [];
        $total    = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product && $product->isInStock()) {
                $subtotal   = $product->price * $item['quantity'];
                $total     += $subtotal;
                $products[] = [
                    'product'  => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('orders.checkout', compact('products', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        DB::transaction(function () use ($request, $cart) {
            $total = 0;
            $items = [];

            foreach ($cart as $productId => $item) {
                $product = Product::lockForUpdate()->findOrFail($productId);

                if ($item['quantity'] > $product->stock) {
                    throw new \Exception("Estoque insuficiente para {$product->name}.");
                }

                $subtotal = $product->price * $item['quantity'];
                $total   += $subtotal;

                $items[]  = [
                    'product'    => $product,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal'   => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id'          => auth()->id(),
                'total'            => $total,
                'status'           => 'pendente',
                'shipping_address' => $request->shipping_address,
                'notes'            => $request->notes,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal'   => $item['subtotal'],
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            session()->forget('cart');
        });

        return redirect()->route('orders.index')->with('success', 'Pedido realizado com sucesso!');
    }

    public function index()
    {
        $orders = auth()->user()->orders()
                        ->with('items.product')
                        ->orderByDesc('created_at')
                        ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
