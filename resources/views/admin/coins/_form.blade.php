@php
    /** @var \App\Models\Coin|null $coin */
    $isEdit = !is_null($coin);
    $val = fn($field, $default = '') => old($field, $isEdit ? $coin->$field : $default);
@endphp

<div class="row g-3">

    {{-- Категория --}}
    <div class="col-md-6">
        <label class="form-label">Категория</label>
        <select name="category_id" class="form-select">
            <option value="">— Без категории —</option>

            @foreach(\App\Models\Category::with('children')->whereNull('parent_id')->orderBy('sort_order')->get() as $parent)
                @if($parent->children->isEmpty())
                    <option value="{{ $parent->id }}"
                        @selected((int) $val('category_id') === $parent->id)>
                        {{ $parent->name }}
                    </option>
                @else
                    <optgroup label="{{ $parent->name }}">
                        <option value="{{ $parent->id }}"
                            @selected((int) $val('category_id') === $parent->id)>
                            {{ $parent->name }} (вся категория)
                        </option>
                        @foreach($parent->children as $child)
                            <option value="{{ $child->id }}"
                                @selected((int) $val('category_id') === $child->id)>
                                {{ $child->name }}
                            </option>
                        @endforeach
                    </optgroup>
                @endif
            @endforeach
        </select>
        @error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Состояние --}}
    <div class="col-md-6">
        <label class="form-label">Состояние</label>
        <input type="text" name="condition" value="{{ $val('condition') }}"
               placeholder="VF, XF, AU…" class="form-control">
        @error('condition')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Название --}}
    <div class="col-md-12">
        <label class="form-label">Название</label>
        <input type="text" name="title" value="{{ $val('title') }}" class="form-control">
        @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Описание --}}
    <div class="col-12">
        <label class="form-label">Описание</label>
        <textarea name="description" rows="3" class="form-control">{{ $val('description') }}</textarea>
        @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Цена --}}
    <div class="col-md-3">
        <label class="form-label">Цена, ₽</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ $val('price') }}" class="form-control">
        @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Количество --}}
    <div class="col-md-3">
        <label class="form-label">Количество</label>
        <input type="number" min="0" name="quantity" value="{{ $val('quantity', 1) }}" class="form-control">
        @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Год --}}
    <div class="col-md-3">
        <label class="form-label">Год</label>
        <input type="number" name="year" value="{{ $val('year') }}" class="form-control">
        @error('year')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Страна --}}
    <div class="col-md-3">
        <label class="form-label">Страна</label>
        <input type="text" name="country" value="{{ $val('country') }}" class="form-control">
        @error('country')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    {{-- Статус --}}
    <div class="col-md-6">
        <label class="form-label">Статус</label>
        <select name="status" class="form-select">
            <option value="available" @selected($val('status') === 'available')>В наличии</option>
            <option value="reserved" @selected($val('status') === 'reserved')>Забронирована</option>
            <option value="sold" @selected($val('status') === 'sold')>Продана</option>
        </select>
    </div>

    {{-- URL картинки --}}
    <div class="col-md-6">
        <label class="form-label">URL картинки</label>
        <input type="url" name="image_url" value="{{ $val('image_url') }}"
               placeholder="https://example.com/coin.jpg" class="form-control">
        @error('image_url')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

</div>
