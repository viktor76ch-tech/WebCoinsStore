<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->getOrCreateCart()->load('items.coin');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'delivery_address' => 'required|string|max:500',
            'comment' => 'nullable|string|max:1000',
        ]);

        $cart = Auth::user()->getOrCreateCart()->load('items.coin');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
        }

        $order = DB::transaction(function () use ($cart, $data) {
            $total = $cart->items->sum(fn ($i) => $i->quantity * $i->price_at_add);

            $order = Order::create([
                'user_id' => Auth::id(),
                'number' => Order::generateNumber(),
                'total_price' => $total,
                'status' => 'pending_payment',
                'payment_status' => 'unpaid',
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'delivery_address' => $data['delivery_address'],
                'comment' => $data['comment'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'coin_id' => $item->coin_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price_at_add,
                ]);

                // Резервируем монету
                $item->coin->update(['status' => 'reserved']);
            }

            // Очищаем корзину
            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('payment.show', $order);
    }
}
