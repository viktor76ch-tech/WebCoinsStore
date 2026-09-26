@extends('layouts.shop')

@section('title', 'Корзина')

@section('content')
    <h1 class="mb-4">Корзина</h1>

    @if($cart->items->isEmpty())
        <div class="card card-body text-center">
            <p class="text-muted mb-3">Ваша корзина пуста.</p>
            <div>
                <a href="{{ route('coins.index') }}" class="btn btn-shop">Перейти в каталог</a>
            </div>
        </div>
    @else
        <div class="card">
            <table class="table mb-0 align-middle">
                <thead>
                <tr>
                    <th>Монета</th>
                    <th>Цена</th>
                    <th class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>
                            <a href="{{ route('coins.show', $item->coin) }}"
                               class="fw-semibold text-decoration-none">
                                {{ $item->coin->title }}
                            </a>
                            <div class="small text-muted">
                                {{ $item->coin->country }}, {{ $item->coin->year }}
                            </div>
                        </td>
                        <td>{{ number_format($item->price_at_add, 0, '.', ' ') }} ₽</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('cart.remove', $item) }}"
                                  onsubmit="return confirm('Удалить позицию?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card card-body mt-3 d-flex flex-row justify-content-between align-items-center">
            <div class="h5 mb-0">
                Итого: {{ number_format($cart->total(), 0, '.', ' ') }} ₽
            </div>
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('cart.clear') }}"
                      onsubmit="return confirm('Очистить корзину?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-secondary">Очистить</button>
                </form>
                <a href="{{ route('checkout.index') }}" class="btn btn-dark">
                    Оформить заказ
                </a>
            </div>
        </div>
    @endif
@endsection
