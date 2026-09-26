<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CheckoutRequest;

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

    public function store(CheckoutRequest $request)
    {
        $data = $request->validated();

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

                if ($item->coin) {
                    $item->coin->decrementStock($item->quantity);
                }
            }

            $cart->items()->delete();

            return $order;
        });

        if (!$order) {
            return back()->with('error', 'Не удалось создать заказ.');
        }

        return redirect()->route('payment.show', $order);
    }
}
