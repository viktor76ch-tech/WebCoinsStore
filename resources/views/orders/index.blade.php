@extends('layouts.shop')

@section('title', 'Мои заказы')

@section('content')
    <h1 class="mb-4">Мои заказы</h1>

    @if($orders->isEmpty())
        <div class="alert alert-secondary">У вас пока нет заказов.</div>
    @else
        <div class="card">
            <table class="table mb-0 align-middle">
                <thead>
                <tr>
                    <th>Номер</th>
                    <th>Дата</th>
                    <th>Позиций</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->number }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->items_count }}</td>
                        <td>{{ number_format($order->total_price, 0, '.', ' ') }} ₽</td>
                        <td><span class="badge bg-secondary">{{ $order->statusLabel() }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('orders.show', $order) }}"
                               class="btn btn-sm btn-outline-secondary">Открыть</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    @endif
@endsection
