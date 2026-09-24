@extends('layouts.admin')

@section('title', 'Монеты')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex gap-2 align-items-center">
            <select name="status" class="form-select form-select-sm" style="width:auto">
                <option value="">Все статусы</option>
                <option value="available" @selected(request('status') === 'available')>В наличии</option>
                <option value="reserved" @selected(request('status') === 'reserved')>Забронированы</option>
                <option value="sold" @selected(request('status') === 'sold')>Проданы</option>
            </select>
            <div class="form-check">
                <input type="checkbox" name="with_trashed" value="1"
                       class="form-check-input" id="with_trashed"
                    @checked(request('with_trashed'))>
                <label for="with_trashed" class="form-check-label small">Показать удалённые</label>
            </div>
            <button class="btn btn-sm btn-dark">Фильтр</button>
        </form>

        <a href="{{ route('admin.coins.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Добавить монету
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Страна / Год</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th>Статус</th>
                    <th class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($coins as $coin)
                    <tr class="{{ $coin->trashed() ? 'table-danger' : '' }}">
                        <td class="text-muted">{{ $coin->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $coin->title }}</div>
                            <div class="small text-muted">{{ $coin->condition }}</div>
                        </td>
                        <td>{{ $coin->country }}, {{ $coin->year }}</td>
                        <td>{{ number_format($coin->price, 0, '.', ' ') }} ₽</td>
                        <td>
                            @if($coin->quantity > 0)
                                <span class="badge bg-success">{{ $coin->quantity }} шт.</span>
                            @else
                                <span class="badge bg-danger">0 шт.</span>
                            @endif
                        </td>
                        <td>
                            @if($coin->trashed())
                                <span class="badge bg-danger">Удалена</span>
                            @elseif($coin->status === 'reserved')
                                <span class="badge bg-warning text-dark">Забронирована</span>
                            @elseif($coin->status === 'available')
                                <span class="badge bg-success">В наличии</span>
                            @else
                                <span class="badge bg-secondary">Продана</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($coin->trashed())
                                <form method="POST"
                                      action="{{ route('admin.coins.restore', $coin->id) }}"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success">Восстановить</button>
                                </form>
                            @else
                                <a href="{{ route('coins.show', $coin) }}" target="_blank"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.coins.edit', $coin) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.coins.destroy', $coin) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Удалить монету?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Монет нет.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $coins->links() }}</div>
@endsection
