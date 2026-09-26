<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Нумизматика') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>
<body>

<nav class="navbar navbar-dark navbar-shop">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('coins.index') }}">
            <i class="bi bi-coin"></i> Нумизматика
        </a>
        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('coins.index') }}" class="nav-link text-white">Каталог</a>
            <a href="{{ route('login') }}" class="btn btn-shop-accent btn-sm">Вход</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-shop-accent btn-sm">Регистрация</a>
            @endif
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center"
     style="min-height:calc(100vh - 60px);">
    <div class="card card-body shadow-sm" style="width:100%; max-width:440px;">
        {{ $slot }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
