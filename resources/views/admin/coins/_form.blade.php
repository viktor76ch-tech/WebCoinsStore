@php
    $isEdit = !is_null($coin);
    $val = fn($field, $default = '') => old($field, $isEdit ? $coin->$field : $default);
@endphp

<div class="col-md-12">
    <label class="form-label">Категория</label>
    <select name="category_id" class="form-select">
        <option value="">— Без категории —</option>
        @foreach(\App\Models\Category::orderBy('sort_order')->get() as $category)
            <option value="{{ $category->id }}" @selected((int) $val('category_id') === $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Название</label>
        <input type="text" name="title" value="{{ $val('title') }}" class="form-control">
        @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Состояние</label>
        <input type="text" name="condition" value="{{ $val('condition') }}"
               placeholder="VF, XF, AU…" class="form-control">
        @error('condition')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label">Описание</label>
        <textarea name="description" rows="3" class="form-control">{{ $val('description') }}</textarea>
        @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Цена, ₽</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ $val('price') }}" class="form-control">
        @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Количество</label>
        <input type="number" min="0" name="quantity" value="{{ $val('quantity', 1) }}" class="form-control">
        @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Год</label>
        <input type="number" name="year" value="{{ $val('year') }}" class="form-control">
        @error('year')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Страна</label>
        <input type="text" name="country" value="{{ $val('country') }}" class="form-control">
        @error('country')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Статус</label>
        <select name="status" class="form-select">
            <option value="available" @selected($val('status') === 'available')>В наличии</option>
            <option value="reserved" @selected($val('status') === 'reserved')>Забронирована</option>
            <option value="sold" @selected($val('status') === 'sold')>Продана</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">URL картинки</label>
        <input type="url" name="image_url" value="{{ $val('image_url') }}"
               placeholder="https://example.com/coin.jpg" class="form-control">
        @error('image_url')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
</div>
