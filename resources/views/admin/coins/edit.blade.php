@extends('layouts.admin')

@section('title', 'Редактирование: ' . $coin->title)

@section('content')
    <form method="POST" action="{{ route('admin.coins.update', $coin) }}" class="card p-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.coins._form', ['coin' => $coin])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.coins.index') }}" class="btn btn-outline-secondary">← Назад</a>
            <button class="btn btn-shop">Сохранить</button>
        </div>
    </form>
@endsection
