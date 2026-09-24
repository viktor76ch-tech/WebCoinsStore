@extends('layouts.admin')

@section('title', 'Пользователь: ' . $user->name)

@section('content')
    <div class="card mb-4" style="max-width:600px">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Имя:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Роль:</strong> {{ $user->role }}</p>
            <p><strong>Зарегистрирован:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
            <p><strong>Заказов:</strong> {{ $user->orders_count }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Последние заказы</div>
        <div class="card-body p-0">
            @if($orders->isEmpty())
                <div class="p-3 text-muted">Заказов нет.</div>
            @else
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->number }}</a></td>
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
