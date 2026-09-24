<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Заказ {{ $order->number }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded shadow p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Статус</p>
                        <p class="text-lg font-semibold">{{ $order->statusLabel() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Сумма</p>
                        <p class="text-lg font-semibold">
                            {{ number_format($order->total_price, 0, '.', ' ') }} ₽
                        </p>
                    </div>
                </div>

                @if($order->status === 'pending_payment')
                    <div class="mt-4 p-3 bg-yellow-50 text-yellow-800 rounded text-sm">
                        Заказ ожидает оплаты.
                        <a href="{{ route('payment.show', $order) }}"
                           class="underline font-medium">
                            Перейти к оплате
                        </a>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded shadow p-6">
                <h3 class="font-semibold mb-3">Состав заказа</h3>
                <ul class="divide-y">
                    @foreach($order->items as $item)
                        <li class="py-3 flex justify-between">
                            <div>
                                <a href="{{ route('coins.show', $item->coin) }}"
                                   class="font-medium text-gray-900 hover:text-gray-700">
                                    {{ $item->coin->title }}
                                </a>
                                <p class="text-sm text-gray-500">
                                    {{ $item->coin->country }}, {{ $item->coin->year }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div>{{ number_format($item->price, 0, '.', ' ') }} ₽</div>
                                <div class="text-sm text-gray-500">× {{ $item->quantity }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white rounded shadow p-6">
                <h3 class="font-semibold mb-3">Доставка</h3>
                <p class="text-gray-700">{{ $order->customer_name }}</p>
                <p class="text-gray-700">{{ $order->phone }}</p>
                <p class="text-gray-700">{{ $order->delivery_address }}</p>
                @if($order->comment)
                    <p class="text-gray-500 mt-2">{{ $order->comment }}</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
