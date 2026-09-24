@extends('layouts.admin')

@section('title', 'Заказ ' . $order->number)

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Состав заказа</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('coins.show', $item->coin) }}" target="_blank">
                                        {{ $item->coin->title }}
                                    </a>
                                    <div class="small text-muted">
                                        {{ $item->coin->country }}, {{ $item->coin->year }}
                                        · остаток: {{ $item->coin->quantity }} шт.
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
                <div class="card-footer d-flex justify-content-between fw-bold">
                    <span>Итого</span>
                    <span>{{ number_format($order->total_price, 0, '.', ' ') }} ₽</span>
                </div>
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
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">Статус заказа</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select mb-3">
                            @foreach(\App\Models\Order::statuses() as $key => $label)
                                <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary w-100">Обновить статус</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Оплата</div>
                <div class="card-body small">
                    <p class="mb-1">Метод: {{ $order->payment_method ?? '—' }}</p>
                    <p class="mb-1">Статус: {{ $order->payment_status }}</p>
                    <p class="mb-1">Ref: {{ $order->payment_ref ?? '—' }}</p>
                    <p class="mb-0">Оплачено: {{ $order->paid_at?->format('d.m.Y H:i') ?? '—' }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Пользователь</div>
                <div class="card-body small">
                    <p class="mb-1">{{ $order->user->name }}</p>
                    <p class="text-muted mb-2">{{ $order->user->email }}</p>
                    <a href="{{ route('admin.users.show', $order->user) }}">Открыть профиль →</a>
                </div>
            </div>
        </div>
    </div>
@endsection
