<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Coin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function index()
    {
        $cart = Auth::user()->getOrCreateCart();
        $cart->load('items.coin');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Coin $coin)
    {
        if (!$coin->isAvailable()) {
            return back()->with('error', 'Эта монета недоступна для заказа.');
        }

        $cart = Auth::user()->getOrCreateCart();

        $item = $cart->items()->where('coin_id', $coin->id)->first();

        if ($item) {
            // У нас монеты штучные — увеличивать количество нельзя
            return back()->with('error', 'Эта монета уже в корзине.');
        }

        $cart->items()->create([
            'coin_id' => $coin->id,
            'quantity' => 1,
            'price_at_add' => $coin->price,
        ]);

        return back()->with('success', 'Монета добавлена в корзину.');
    }

    public function remove(CartItem $item)
    {
        $this->authorizeItem($item);
        $item->delete();

        return back()->with('success', 'Позиция удалена из корзины.');
    }

    public function clear()
    {
        $cart = Auth::user()->getOrCreateCart();
        $cart->items()->delete();

        return back()->with('success', 'Корзина очищена.');
    }

    protected function authorizeItem(CartItem $item): void
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
