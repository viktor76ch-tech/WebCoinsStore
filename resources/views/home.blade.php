<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Нумизматика — магазин монет</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold">Нумизматика</a>

        <nav class="flex items-center gap-4">
            <a href="{{ route('coins.index') }}" class="text-gray-700 hover:text-gray-900">
                Каталог
            </a>

            @auth
                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-gray-900">
                    Кабинет
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">
                    Вход
                </a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                        Регистрация
                    </a>
                @endif
            @endauth
        </nav>
    </div>
</header>

<section class="max-w-7xl mx-auto px-4 py-16 text-center">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">
        Магазин нумизматики
    </h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
        Редкие монеты Российской империи, Европы и США. Проверенное состояние,
        честные описания, быстрая доставка.
    </p>
    <a href="{{ route('coins.index') }}"
       class="inline-block px-6 py-3 bg-gray-900 text-white rounded hover:bg-gray-700">
        Перейти в каталог
    </a>
</section>

@if($coins->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 pb-16">
        <h2 class="text-2xl font-semibold mb-6">Новые поступления</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($coins as $coin)
                <a href="{{ route('coins.show', $coin) }}"
                   class="bg-white rounded shadow overflow-hidden hover:shadow-lg transition">
                    <div class="h-40 bg-gray-100 flex items-center justify-center">
                        @if($coin->image_url)
                            <img src="{{ $coin->image_url }}" alt="{{ $coin->title }}"
                                 class="h-40 w-full object-cover">
                        @else
                            <span class="text-gray-400 text-sm">Нет фото</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 leading-tight">
                            {{ $coin->title }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $coin->country }}, {{ $coin->year }}
                        </p>
                        <p class="mt-2 font-bold text-gray-900">
                            {{ number_format($coin->price, 0, '.', ' ') }} ₽
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif

<footer class="bg-white border-t">
    <div class="max-w-7xl mx-auto px-4 py-6 text-sm text-gray-500 text-center">
        © {{ date('Y') }} Нумизматика. Курсовой проект.
    </div>
</footer>

</body>
</html>
