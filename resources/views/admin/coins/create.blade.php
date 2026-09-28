@extends('layouts.admin')

@section('title', 'Новая монета')

@section('content')
    <form method="POST" action="{{ route('admin.coins.store') }}" class="card p-4">
        @csrf
        @include('admin.coins._form', ['coin' => null])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.coins.index') }}" class="btn btn-outline-secondary">← Назад</a>
            <button class="btn btn-shop">Сохранить</button>
        </div>
    </form>
@endsection
