@extends('layouts.shop')

@section('title', 'Оформление заказа')

@section('content')
    <h1 class="mb-4">Оформление заказа</h1>

    <div class="row g-4">
        <div class="col-md-7">
            <form method="POST" action="{{ route('checkout.store') }}" class="card card-body">
                @csrf

                <div class="mb-3">
                    <label class="form-label">ФИО</label>
                    <input type="text" name="customer_name"
                           value="{{ old('customer_name', auth()->user()->name) }}"
                           class="form-control @error('customer_name') is-invalid @enderror">
                    @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="+7 900 000-00-00"
                           class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Адрес доставки</label>
                    <textarea name="delivery_address" rows="3"
                              class="form-control @error('delivery_address') is-invalid @enderror">{{ old('delivery_address') }}</textarea>
                    @error('delivery_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Комментарий</label>
                    <textarea name="comment" rows="2" class="form-control">{{ old('comment') }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">← В корзину</a>
                    <button class="btn btn-dark">Перейти к оплате</button>
                </div>
            </form>
        </div>

        <div class="col-md-5">
            <div class="card card-body">
                <h5 class="mb-3">Ваш заказ</h5>
                <ul class="list-unstyled mb-3">
                    @foreach($cart->items as $item)
                        <li class="d-flex justify-content-between border-bottom py-2">
                            <span>{{ $item->coin->title }}</span>
                            <span>{{ number_format($item->price_at_add, 0, '.', ' ') }} ₽</span>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Итого</span>
                    <span>{{ number_format($cart->total(), 0, '.', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </div>
@endsection
