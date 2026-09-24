<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Оформление заказа
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Форма --}}
            <div class="md:col-span-2 bg-white rounded shadow p-6">
                <form method="POST" action="{{ route('checkout.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">ФИО</label>
                        <input type="text" name="customer_name"
                               value="{{ old('customer_name', auth()->user()->name) }}"
                               class="mt-1 w-full border-gray-300 rounded px-3 py-2 border">
                        @error('customer_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Телефон</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               placeholder="+7 900 000-00-00"
                               class="mt-1 w-full border-gray-300 rounded px-3 py-2 border">
                        @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Адрес доставки</label>
                        <textarea name="delivery_address" rows="3"
                                  class="mt-1 w-full border-gray-300 rounded px-3 py-2 border">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Комментарий (необязательно)</label>
                        <textarea name="comment" rows="2"
                                  class="mt-1 w-full border-gray-300 rounded px-3 py-2 border">{{ old('comment') }}</textarea>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <a href="{{ route('cart.index') }}"
                           class="text-gray-600 hover:text-gray-900 self-center">
                            ← Назад в корзину
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                            Перейти к оплате
                        </button>
                    </div>
                </form>
            </div>

            {{-- Сводка --}}
            <div class="bg-white rounded shadow p-6">
                <h3 class="font-semibold mb-3">Ваш заказ</h3>

                <ul class="space-y-2 text-sm">
                    @foreach($cart->items as $item)
                        <li class="flex justify-between">
                            <span class="text-gray-700">{{ $item->coin->title }}</span>
                            <span class="text-gray-900">
                                {{ number_format($item->price_at_add, 0, '.', ' ') }} ₽
                            </span>
                        </li>
                    @endforeach
                </ul>

                <div class="border-t mt-4 pt-4 flex justify-between font-bold">
                    <span>Итого</span>
                    <span>{{ number_format($cart->total(), 0, '.', ' ') }} ₽</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
