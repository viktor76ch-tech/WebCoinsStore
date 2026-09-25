@extends('layouts.shop')

@section('title', 'Заказ ' . $order->number)

@section('content')
    <h1 class="mb-4">Заказ {{ $order->number }}</h1>

    <div class="card card-body mb-3 d-flex flex-row justify-content-between">
        <div>
            <div class="text-muted small">Статус</div>
            <div class="h5 mb-0">{{ $order->statusLabel() }}</div>
        </div>
        <div class="text-end">
            <div class="text-muted small">Сумма</div>
            <div class="h5 mb-0">{{ number_format($order->total_price, 0, '.', ' ') }} ₽</div>
        </div>
    </div>

    @if($order->status === 'pending_payment')
        <div class="alert alert-warning">
            Заказ ожидает оплаты.
            <a href="{{ route('payment.show', $order) }}" class="alert-link">Перейти к оплате</a>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-header">Состав заказа</div>
        <ul class="list-group list-group-flush">
            @foreach($order->items as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <a href="{{ route('coins.show', $item->coin) }}" class="text-decoration-none">
                            {{ $item->coin->title }}
                        </a>
                        <div class="small text-muted">
                            {{ $item->coin->country }}, {{ $item->coin->year }}
                        </div>
                    </div>
                    <div class="text-end">
                        <div>{{ number_format($item->price, 0, '.', ' ') }} ₽</div>
                        <div class="small text-muted">× {{ $item->quantity }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card">
        <div class="card-header">Доставка</div>
        <div class="card-body">
            <p class="mb-1">{{ $order->customer_name }}</p>
            <p class="mb-1">{{ $order->phone }}</p>
            <p class="mb-1">{{ $order->delivery_address }}</p>
            @if($order->comment)
                <p class="text-muted mb-0">{{ $order->comment }}</p>
            @endif
        </div>
    </div>
@endsection
