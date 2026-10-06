@extends('layouts.admin')

@section('title', 'Новая категория')

@section('content')
    <form method="POST" action="{{ route('admin.categories.store') }}" class="card p-4" style="max-width:700px;">
        @csrf
        @include('admin.categories._form', ['category' => null])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">← Назад</a>
            <button class="btn btn-shop">Сохранить</button>
        </div>
    </form>
@endsection
