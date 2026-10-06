<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Нумизматика — магазин монет</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark navbar-shop">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-coin"></i> Нумизматика
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('coins.index') }}" class="nav-link text-white">Каталог</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-link text-white">Кабинет</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Вход</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-shop-accent btn-sm">Регистрация</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

<section class="container text-center py-5">
    <h1 class="display-5 fw-bold mb-3">Магазин нумизматики</h1>
    <p class="lead text-muted mx-auto mb-4" style="max-width:640px;">
        Редкие монеты Российской империи, Европы и США. Проверенное состояние,
        честные описания, быстрая доставка.
    </p>
    <a href="{{ route('coins.index') }}" class="btn btn-shop btn-lg">
        Перейти в каталог
    </a>
</section>

@if($coins->isNotEmpty())
    <section class="container pb-5 flex-grow-1">
        <h2 class="h4 mb-4">Новые поступления</h2>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            @foreach($coins as $coin)
                <div style="width: 260px; max-width: 100%;">
                    <a href="{{ route('coins.show', $coin) }}"
                       class="card h-100 text-decoration-none text-dark">
                        <div class="ratio ratio-4x3 bg-light">
                            @if($coin->image_url)
                                <img src="{{ $coin->image_url }}" alt="{{ $coin->title }}"
                                     class="object-fit-contain">
                            @else
                                <div class="d-flex align-items-center justify-content-center text-muted">Нет фото</div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h3 class="h6">{{ $coin->title }}</h3>
                            <p class="small text-muted mb-2">{{ $coin->country }}, {{ $coin->year }}</p>
                            <p class="fw-bold mb-0">{{ number_format($coin->price, 0, '.', ' ') }} ₽</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endif

<footer class="shop-footer py-3 mt-auto">
    <div class="container text-center text-muted small">
        © {{ date('Y') }} Нумизматика
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
