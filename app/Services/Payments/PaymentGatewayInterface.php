<?php

namespace App\Services\Payments;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Инициировать оплату. Вернуть URL, куда направить пользователя,
     * или null, если оплата подтверждается сразу на нашей стороне.
     */
    public function initiate(Order $order): ?string;

    /**
     * Подтвердить оплату (используется mock-шлюзом).
     * В реальном шлюзе это делается через webhook.
     */
    public function confirm(Order $order): bool;

    /**
     * Отменить оплату.
     */
    public function cancel(Order $order): bool;
}
