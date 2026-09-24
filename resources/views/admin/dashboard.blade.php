@extends('layouts.admin')

@section('title', 'Дашборд')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Пользователи</div>
                    <div class="h3 mb-0">{{ $stats['users'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Монеты</div>
                    <div class="h3 mb-0">{{ $stats['coins'] }}</div>
                    <div class="small text-muted">
                        В наличии: {{ $stats['coins_in_stock'] }} ·
                        Нет: {{ $stats['coins_out_of_stock'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Заказы</div>
                    <div class="h3 mb-0">{{ $stats['orders'] }}</div>
                    <div class="small text-muted">
                        Оплачено: {{ $stats['orders_paid'] }} ·
                        Ждут: {{ $stats['orders_pending'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Выручка</div>
                    <div class="h3 mb-0">{{ number_format($stats['revenue'], 0, '.', ' ') }} ₽</div>
                    <div class="small text-muted">по оплаченным</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Последние заказы</div>
        <div class="card-body p-0">
            @if($recentOrders->isEmpty())
                <div class="p-3 text-muted">Заказов пока нет.</div>
            @else
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Пользователь</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}">
                                    {{ $order->number }}
                                </a>
                            </td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ number_format($order->total_price, 0, '.', ' ') }} ₽</td>
                            <td>{{ $order->statusLabel() }}</td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
