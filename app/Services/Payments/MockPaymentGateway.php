<?php

namespace App\Services\Payments;

use App\Models\Order;
use Illuminate\Support\Str;

class MockPaymentGateway implements PaymentGatewayInterface
{
    public function initiate(Order $order): ?string
    {
        // Мок не редиректит наружу — оплата подтверждается в нашем приложении.
        return null;
    }

    public function confirm(Order $order): bool
    {
        $order->update([
            'status' => 'paid',
            'payment_status' => 'paid',
            'payment_method' => 'mock',
            'payment_ref' => 'MOCK-' . strtoupper(Str::random(10)),
            'paid_at' => now(),
        ]);

        return true;
    }

    public function cancel(Order $order): bool
    {
        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'unpaid',
        ]);

        return true;
    }
}
