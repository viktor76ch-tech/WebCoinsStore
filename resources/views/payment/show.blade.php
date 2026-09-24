<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Оплата заказа {{ $order->number }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded shadow p-8 text-center">

                <p class="text-gray-600">К оплате:</p>
                <p class="text-4xl font-bold text-gray-900 my-4">
                    {{ number_format($order->total_price, 0, '.', ' ') }} ₽
                </p>

                <p class="text-sm text-gray-500 mb-6">
                    Это демонстрационная оплата. Реальный платёжный шлюз не подключён.
                </p>

                <div class="flex justify-center gap-3">
                    <form method="POST" action="{{ route('payment.pay', $order) }}">
                        @csrf
                        <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                            Оплатить
                        </button>
                    </form>

                    <form method="POST" action="{{ route('payment.cancel', $order) }}"
                          onsubmit="return confirm('Отменить заказ?')">
                        @csrf
                        <button type="submit"
                                class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                            Отменить
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
