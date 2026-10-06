@extends('layouts.admin')

@section('title', 'Редактирование: ' . $category->name)

@section('content')
    <form method="POST" action="{{ route('admin.categories.update', $category) }}"
          class="card p-4" style="max-width:700px;">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $category])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">← Назад</a>
            <button class="btn btn-shop">Сохранить</button>
        </div>
    </form>
@endsection
