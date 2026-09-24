<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мои заказы
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if($orders->isEmpty())
                <div class="bg-white p-6 rounded shadow text-gray-600">
                    У вас пока нет заказов.
                </div>
            @else
                <div class="bg-white rounded shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Номер</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Позиций</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сумма</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $order->number }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $order->items_count }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ number_format($order->total_price, 0, '.', ' ') }} ₽</td>
                                <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                            {{ $order->statusLabel() }}
                                        </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="text-gray-700 hover:text-gray-900 text-sm">
                                        Открыть
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-4">{{ $orders->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>
