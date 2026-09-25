@extends('layouts.shop')

@section('title', 'Личный кабинет')

@section('content')
    <h1 class="mb-4">Личный кабинет</h1>

    <div class="card card-body">
        <p>Здравствуйте, <strong>{{ auth()->user()->name }}</strong>!</p>
        <p class="text-muted mb-2">Email: {{ auth()->user()->email }}</p>
        <p class="mb-3">
            Роль:
            <strong>{{ auth()->user()->role === 'admin' ? 'Администратор' : 'Пользователь' }}</strong>
        </p>

        <div class="d-flex gap-2">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                Редактировать профиль
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-dark">
                Мои заказы
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">
                    Админ-панель
                </a>
            @endif
        </div>
    </div>
@endsection
