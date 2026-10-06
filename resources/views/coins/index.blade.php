@extends('layouts.shop')

@section('title', $currentCategory ? $currentCategory->name : 'Каталог монет')

@section('content')
    <div class="row g-4">

        {{-- ЛЕВОЕ МЕНЮ --}}
        <aside class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="bi bi-list-ul"></i> Категории
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('coins.index', request()->except('category')) }}"
                       class="list-group-item list-group-item-action
              {{ !request('category') ? 'active' : '' }}">
                        Все монеты
                    </a>

                    @foreach($categories as $category)
                        @php
                            $isActive = request('category') === $category->slug;
                            $childActive = $category->children->contains('slug', request('category'));
                            $expanded = $isActive || $childActive;
                        @endphp

                        <a href="{{ route('coins.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}"
                           class="list-group-item list-group-item-action
                  {{ $isActive ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>

                        @if($category->children->isNotEmpty() && $expanded)
                            @foreach($category->children as $child)
                                <a href="{{ route('coins.index', array_merge(request()->except('category'), ['category' => $child->slug])) }}"
                                   class="list-group-item list-group-item-action ps-4
                          {{ request('category') === $child->slug ? 'active' : '' }}">
                                    <span class="text-muted me-1">↳</span> {{ $child->name }}
                                </a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- ПРАВАЯ ЧАСТЬ --}}
        <div class="col-12 col-lg-9">

            <h1 class="h3 mb-3">
                @if($currentCategory)
                    @if($currentCategory->parent)
                        <a href="{{ route('coins.index', ['category' => $currentCategory->parent->slug]) }}"
                           class="text-decoration-none text-muted">
                            {{ $currentCategory->parent->name }}
                        </a>
                        <span class="text-muted">→</span>
                    @endif
                    {{ $currentCategory->name }}
                @else
                    Каталог монет
                @endif
            </h1>

            {{-- ФИЛЬТРЫ --}}
            <form method="GET" action="{{ route('coins.index') }}"
                  class="card card-body mb-4">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="row g-2">
                    <div class="col-12 col-md-3">
                        <input type="text" name="search" placeholder="Поиск"
                               value="{{ request('search') }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-2">
                        <select name="country" class="form-select">
                            <option value="">Все страны</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" @selected(request('country') === $country)>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <select name="condition" class="form-select">
                            <option value="">Состояние</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" @selected(request('condition') === $condition)>
                                    {{ $condition }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <select name="metal" class="form-select">
                            <option value="">Металл</option>
                            @foreach($metals as $metal)
                                <option value="{{ $metal }}" @selected(request('metal') === $metal)>
                                    {{ $metal }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-1">
                        <input type="number" name="year_from" placeholder="Год от"
                               value="{{ request('year_from') }}" class="form-control">
                    </div>
                    <div class="col-6 col-md-1">
                        <input type="number" name="year_to" placeholder="Год до"
                               value="{{ request('year_to') }}" class="form-control">
                    </div>
                    <div class="col-12 col-md-1 d-grid">
                        <button class="btn btn-shop">→</button>
                    </div>
                </div>

                @if(request()->anyFilled(['search', 'country', 'condition', 'metal', 'year_from', 'year_to']))
                    <div class="mt-2">
                        <a href="{{ route('coins.index', request()->only('category')) }}" class="small">
                            Сбросить фильтры
                        </a>
                    </div>
                @endif
            </form>

            {{-- СЕТКА МОНЕТ --}}
            @if($coins->isEmpty())
                <div class="alert alert-secondary">Монеты не найдены.</div>
            @else
                <div class="coin-grid">
                    @foreach($coins as $coin)
                        <div class="card h-100">
                            <div class="ratio ratio-4x3 bg-light">
                                @if($coin->image_url)
                                    <img src="{{ $coin->image_url }}" alt="{{ $coin->title }}"
                                         class="object-fit-contain">
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
                                        @if($coin->metal)
                                            · {{ $coin->metal }}
                                        @endif
                                    </p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">{{ number_format($coin->price, 0, '.', ' ') }} ₽</span>
                                    <a href="{{ route('coins.show', $coin) }}" class="btn btn-sm btn-shop">
                                        Подробнее
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">{{ $coins->links() }}</div>
            @endif
        </div>
    </div>
@endsection
