<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $coin->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('coins.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Назад к каталогу
            </a>

            <div class="bg-white rounded shadow mt-4 grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

                {{-- Изображение --}}
                <div class="bg-gray-100 rounded flex items-center justify-center h-80">
                    @if($coin->image_url)
                        <img src="{{ $coin->image_url }}" alt="{{ $coin->title }}"
                             class="max-h-80 object-contain">
                    @else
                        <span class="text-gray-400">Нет фото</span>
                    @endif
                </div>

                {{-- Информация --}}
                <div class="flex flex-col">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $coin->title }}</h1>

                    <p class="text-gray-600 mt-2">{{ $coin->description }}</p>

                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex">
                            <dt class="w-32 text-gray-500">Страна</dt>
                            <dd class="text-gray-900">{{ $coin->country }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-gray-500">Год</dt>
                            <dd class="text-gray-900">{{ $coin->year }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-gray-500">Состояние</dt>
                            <dd class="text-gray-900">{{ $coin->condition }}</dd>
                        </div>
                        <div class="flex">
                            <dt class="w-32 text-gray-500">Статус</dt>
                            <dd class="text-gray-900">
                                @if($coin->status === 'available')
                                    <span class="text-green-700">В наличии</span>
                                @elseif($coin->status === 'reserved')
                                    <span class="text-yellow-700">Забронирована</span>
                                @else
                                    <span class="text-red-700">Продана</span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-auto pt-6">
                        <div class="text-3xl font-bold text-gray-900">
                            {{ number_format($coin->price, 0, '.', ' ') }} ₽
                        </div>

                        @if($coin->status === 'available')
                            @auth
                                <form method="POST" action="{{ route('cart.add', $coin) }}" class="mt-4">
                                    @csrf
                                    <button type="submit"
                                            class="px-6 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                                        В корзину
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="inline-block mt-4 px-6 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                                    Войти, чтобы купить
                                </a>
                            @endauth
                        @else
                            <p class="mt-4 text-sm text-gray-500">
                                Монета недоступна для заказа.
                            </p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
