@extends('layouts.admin')

@section('title', 'Категории')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted small">
            Категории верхнего уровня и их подкатегории.
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-shop btn-sm">
            <i class="bi bi-plus-lg"></i> Добавить категорию
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Slug</th>
                    <th>Родитель</th>
                    <th>Порядок</th>
                    <th>Монет</th>
                    <th class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tree as $parent)
                    <tr class="table-light">
                        <td class="fw-semibold">
                            <i class="bi bi-folder2"></i> {{ $parent->name }}
                        </td>
                        <td class="text-muted small">{{ $parent->slug }}</td>
                        <td class="text-muted small">—</td>
                        <td>{{ $parent->sort_order }}</td>
                        <td>{{ $parent->coins()->count() }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $parent) }}"
                               class="btn btn-sm btn-outline-shop">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $parent) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Удалить категорию?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @foreach($parent->children as $child)
                        <tr>
                            <td>
                                <span class="text-muted ms-3">↳</span>
                                {{ $child->name }}
                            </td>
                            <td class="text-muted small">{{ $child->slug }}</td>
                            <td class="text-muted small">{{ $parent->name }}</td>
                            <td>{{ $child->sort_order }}</td>
                            <td>{{ $child->coins()->count() }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $child) }}"
                                   class="btn btn-sm btn-outline-shop">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $child) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Удалить подкатегорию?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Категорий нет.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
