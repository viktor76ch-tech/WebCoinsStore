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
            // ... как было
        });

        return redirect()->route('payment.show', $order);
    }
}
