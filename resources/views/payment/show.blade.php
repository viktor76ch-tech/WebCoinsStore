@extends('layouts.shop')

@section('title', 'Оплата заказа ' . $order->number)

@section('content')
    <div class="card card-body text-center mx-auto" style="max-width: 500px;">
        <h4>Оплата заказа {{ $order->number }}</h4>

        <p class="text-muted mb-0 mt-3">К оплате:</p>
        <div class="display-5 fw-bold my-2">
            {{ number_format($order->total_price, 0, '.', ' ') }} ₽
        </div>

        <p class="small text-muted">
            Это демонстрационная оплата. Реальный платёжный шлюз не подключён.
        </p>

        <div class="d-flex justify-content-center gap-2 mt-3">
            <form method="POST" action="{{ route('payment.pay', $order) }}">
                @csrf
                <button class="btn btn-shop btn-lg">Оплатить</button>
            </form>
            <form method="POST" action="{{ route('payment.cancel', $order) }}"
                  onsubmit="return confirm('Отменить заказ?')">
                @csrf
                <button class="btn btn-outline-secondary btn-lg">Отменить</button>
            </form>
        </div>
    </div>
@endsection
