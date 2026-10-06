@php
    $isEdit = !is_null($category);
    $val = fn($field, $default = '') => old($field, $isEdit ? $category->$field : $default);
@endphp

<div class="row g-3">

    <div class="col-md-8">
        <label class="form-label">Название</label>
        <input type="text" name="name" value="{{ $val('name') }}" class="form-control">
        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Порядок сортировки</label>
        <input type="number" name="sort_order" value="{{ $val('sort_order', 0) }}" class="form-control">
        @error('sort_order')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Родительская категория</label>
        <select name="parent_id" class="form-select">
            <option value="">— Верхний уровень —</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}"
                    @selected((int) $val('parent_id') === $parent->id)>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
        @error('parent_id')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Slug <span class="text-muted small">(необязательно)</span></label>
        <input type="text" name="slug" value="{{ $val('slug') }}"
               placeholder="генерируется автоматически" class="form-control">
        @error('slug')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

</div>
