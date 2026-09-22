<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
Каталог монет
</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

{{-- Фильтры --}}
<form method="GET" action="{{ route('coins.index') }}"
      class="bg-white p-4 rounded shadow grid grid-cols-1 md:grid-cols-5 gap-3">

    <input type="text" name="search" placeholder="Поиск по названию"
           value="{{ request('search') }}"
           class="border-gray-300 rounded px-3 py-2 border w-full">

    <select name="country" class="border-gray-300 rounded px-3 py-2 border w-full">
        <option value="">Все страны</option>
        @foreach($countries as $country)
            <option value="{{ $country }}" @selected(request('country') === $country)>
                {{ $country }}
            </option>
        @endforeach
    </select>

    <select name="condition" class="border-gray-300 rounded px-3 py-2 border w-full">
        <option value="">Все состояния</option>
        @foreach($conditions as $condition)
            <option value="{{ $condition }}" @selected(request('condition') === $condition)>
                {{ $condition }}
            </option>
        @endforeach
    </select>

    <input type="number" name="year_from" placeholder="Год от"
           value="{{ request('year_from') }}"
           class="border-gray-300 rounded px-3 py-2 border w-full">

    <input type="number" name="year_to" placeholder="Год до"
           value="{{ request('year_to') }}"
           class="border-gray-300 rounded px-3 py-2 border w-full">

    <div class="md:col-span-5 flex gap-2">
        <button type="submit"
                class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
            Применить
        </button>
        <a href="{{ route('coins.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
            Сбросить
        </a>
    </div>
</form>

{{-- Сетка монет --}}
@if($coins->isEmpty())
    <div class="bg-white p-6 rounded shadow text-gray-600">
        Монеты не найдены.
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($coins as $coin)
            <div class="bg-white rounded shadow overflow-hidden flex flex-col">
                <div class="h-40 bg-gray-100 flex items-center justify-center">
                    @if($coin->image_url)
                        <img src="{{ $coin->image_url }}" alt="{{ $coin->title }}"
                             class="h-40 w-full object-cover">
                    @else
                        <span class="text-gray-400 text-sm">Нет фото</span>
                    @endif
                </div>

                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-gray-900 leading-tight">
                        {{ $coin->title }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $coin->country }}, {{ $coin->year }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Состояние: {{ $coin->condition }}
                    </p>

                    <div class="mt-auto pt-3 flex justify-between items-center">
                                    <span class="font-bold text-gray-900">
                                        {{ number_format($coin->price, 0, '.', ' ') }} ₽
                                    </span>
                        <a href="{{ route('coins.show', $coin) }}"
                           class="text-sm px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700">
                            Подробнее
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pt-4">
        {{ $coins->links() }}
    </div>
    @endif

    </div>
    </div>
    </x-app-layout>
