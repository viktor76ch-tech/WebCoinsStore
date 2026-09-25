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
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('payment.show', compact('order'));
    }

    public function pay(Order $order)
    {
        $this->authorize('pay', $order);

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order)
                ->with('success', 'Заказ уже оплачен.');
        }

        $this->gateway->confirm($order);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Оплата прошла успешно. Спасибо!');
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        $this->gateway->cancel($order);

        foreach ($order->items as $item) {
            $item->coin->incrementStock($item->quantity);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Заказ отменён.');
    }
}
