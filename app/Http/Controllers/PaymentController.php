<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payments\PaymentGatewayInterface;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentGatewayInterface $gateway
    ) {
        //
    }

    public function show(Order $order)
    {
        $this->authorizeOrder($order);

        return view('payment.show', compact('order'));
    }

    public function pay(Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order)
                ->with('success', 'Заказ уже оплачен.');
        }

        $this->gateway->confirm($order);

        foreach ($order->items as $item) {
            $item->coin->update(['status' => 'sold']);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Оплата прошла успешно. Спасибо!');
    }

    public function cancel(Order $order)
    {
        $this->authorizeOrder($order);

        $this->gateway->cancel($order);

        foreach ($order->items as $item) {
            $item->coin->update(['status' => 'available']);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Заказ отменён.');
    }

    protected function authorizeOrder(Order $order): void
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
    }
}
