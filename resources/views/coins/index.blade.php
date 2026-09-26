@extends('layouts.shop')

@section('title', 'Каталог монет')

@section('content')
    <h1 class="mb-4">Каталог монет</h1>

    <form method="GET" action="{{ route('coins.index') }}" class="card card-body mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" placeholder="Поиск"
                       value="{{ request('search') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <select name="country" class="form-select">
                    <option value="">Все страны</option>
                    @foreach($countries as $country)
                        <option value="{{ $country }}" @selected(request('country') === $country)>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="condition" class="form-select">
                    <option value="">Состояние</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition }}" @selected(request('condition') === $condition)>
                            {{ $condition }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="year_from" placeholder="Год от"
                       value="{{ request('year_from') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="number" name="year_to" placeholder="Год до"
                       value="{{ request('year_to') }}" class="form-control">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-shop">→</button>
            </div>
        </div>
        @if(request()->anyFilled(['search', 'country', 'condition', 'year_from', 'year_to']))
            <div class="mt-2">
                <a href="{{ route('coins.index') }}" class="small">Сбросить фильтры</a>
            </div>
        @endif
    </form>

    @if($coins->isEmpty())
        <div class="alert alert-secondary">Монеты не найдены.</div>
    @else
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            @foreach($coins as $coin)
                <div style="width: 260px; max-width: 100%;">
                    <div class="card h-100">
                        <div class="ratio ratio-4x3 bg-light">
                            @if($coin->image_url)
                                <img src="{{ $coin->image_url }}" alt="{{ $coin->title }}"
                                     class="object-fit-cover">
                            @else
                                <div class="d-flex align-items-center justify-content-center text-muted">
                                    Нет фото
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            @if($coin->status === 'reserved')
                                <span class="badge bg-warning text-dark align-self-start mb-1">Забронирована</span>
                            @elseif($coin->isAvailable())
                                <span class="badge bg-success align-self-start mb-1">
                                    В наличии: {{ $coin->quantity }}
                                </span>
                            @else
                                <span class="badge bg-danger align-self-start mb-1">Нет в наличии</span>
                            @endif

                            <h5 class="card-title h6 mt-1">{{ $coin->title }}</h5>
                            <p class="card-text small text-muted mb-2">
                                {{ $coin->country }}, {{ $coin->year }} · {{ $coin->condition }}
                            </p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold">{{ number_format($coin->price, 0, '.', ' ') }} ₽</span>
                                <a href="{{ route('coins.show', $coin) }}" class="btn btn-sm btn-shop">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $coins->links() }}</div>
    @endif
@endsection
