<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Корзина
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
             @if($cart->items->isEmpty())
                <div class="bg-white p-8 rounded shadow text-center">
                    <p class="text-gray-600 mb-4">Ваша корзина пуста.</p>
                    <a href="{{ route('coins.index') }}"
                       class="inline-block px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                        Перейти в каталог
                    </a>
                </div>
            @else
                <div class="bg-white rounded shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Монета</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Цена</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($cart->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <a href="{{ route('coins.show', $item->coin) }}"
                                       class="font-medium text-gray-900 hover:text-gray-700">
                                        {{ $item->coin->title }}
                                    </a>
                                    <div class="text-sm text-gray-500">
                                        {{ $item->coin->country }}, {{ $item->coin->year }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-900">
                                    {{ number_format($item->price_at_add, 0, '.', ' ') }} ₽
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <form method="POST"
                                          action="{{ route('cart.remove', $item) }}"
                                          onsubmit="return confirm('Удалить позицию?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded shadow p-6 flex justify-between items-center">
                    <div class="text-lg">
                        Итого: <b>{{ number_format($cart->total(), 0, '.', ' ') }} ₽</b>
                    </div>

                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('cart.clear') }}"
                              onsubmit="return confirm('Очистить корзину?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                Очистить
                            </button>
                        </form>

                        <a href="#"
                           class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                            Оформить заказ (скоро)
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
