@extends('layouts.shop')

@section('title', $coin->title)

@section('content')
    <a href="{{ route('coins.index') }}" class="text-decoration-none text-muted small">
        ← Назад к каталогу
    </a>

    <div class="card mt-3">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="ratio ratio-1x1 bg-light">
                    @if($coin->image_url)
                        <img src="{{ $coin->image_url }}" alt="{{ $coin->title }}"
                             class="object-fit-contain">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted">
                            Нет фото
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h1 class="h3">{{ $coin->title }}</h1>
                    <p class="text-muted">{{ $coin->description }}</p>

                    <dl class="row small">
                        <dt class="col-4 text-muted">Категория</dt>
                        <dd class="col-8">
                            @if($coin->category)
                                @if($coin->category->parent)
                                    <a href="{{ route('coins.index', ['category' => $coin->category->parent->slug]) }}"
                                       class="text-decoration-none">
                                        {{ $coin->category->parent->name }}
                                    </a>
                                    <span class="text-muted">→</span>
                                @endif
                                <a href="{{ route('coins.index', ['category' => $coin->category->slug]) }}"
                                   class="text-decoration-none">
                                    {{ $coin->category->name }}
                                </a>
                            @else
                                —
                            @endif
                        </dd>


                        <dt class="col-4 text-muted">Страна</dt>
                        <dd class="col-8">{{ $coin->country }}</dd>

                        <dt class="col-4 text-muted">Год</dt>
                        <dd class="col-8">{{ $coin->year }}</dd>

                        <dt class="col-4 text-muted">Состояние</dt>
                        <dd class="col-8">{{ $coin->condition }}</dd>

                        <dt class="col-4 text-muted">Наличие</dt>
                        <dd class="col-8">
                            @if($coin->status === 'reserved')
                                <span class="badge bg-warning text-dark">Забронирована</span>
                            @elseif($coin->isAvailable())
                                <span class="badge bg-success">В наличии: {{ $coin->quantity }}</span>
                            @else
                                <span class="badge bg-danger">Нет в наличии</span>
                            @endif
                        </dd>
                    </dl>

                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <div class="h3 mb-0">{{ number_format($coin->price, 0, '.', ' ') }} ₽</div>

                        @if($coin->isAvailable())
                            @auth
                                <form method="POST" action="{{ route('cart.add', $coin) }}">
                                    @csrf
                                    <button class="btn btn-dark btn-lg">
                                        <i class="bi bi-cart-plus"></i> В корзину
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-dark btn-lg">
                                    Войти, чтобы купить
                                </a>
                            @endauth
                        @else
                            <span class="text-muted">Недоступна для заказа</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
