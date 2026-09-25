<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Нумизматика') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('coins.index') }}">Нумизматика</a>
        <div class="d-flex gap-2">
            <a href="{{ route('coins.index') }}" class="btn btn-sm btn-outline-light">Каталог</a>
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Вход</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-light">Регистрация</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height:calc(100vh - 56px);">
    <div class="card card-body shadow-sm" style="width:100%; max-width:440px;">
        {{ $slot }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
