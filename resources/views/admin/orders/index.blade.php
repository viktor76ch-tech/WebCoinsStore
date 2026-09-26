@extends('layouts.admin')

@section('title', 'Заказы')

@section('content')
    <form method="GET" class="mb-3 d-flex gap-2">
        <select name="status" class="form-select form-select-sm" style="width:auto">
            <option value="">Все статусы</option>
            @foreach(\App\Models\Order::statuses() as $key => $label)
                <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn btn-sm btn-shop">Фильтр</button>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                <tr>
                    <th>Номер</th>
                    <th>Пользователь</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ number_format($order->total_price, 0, '.', ' ') }} ₽</td>
                        <td>
                            <span class="badge bg-secondary">{{ $order->statusLabel() }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-sm btn-outline-secondary">Открыть</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Заказов нет.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $orders->links() }}</div>
@endsection
