<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Numismatics') }}</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">

{{-- Хедер для гостей --}}
<header class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <a href="{{ route('coins.index') }}" class="text-lg font-bold text-gray-900">
            Нумизматика
        </a>
        <nav class="flex items-center gap-4 text-sm">
            <a href="{{ route('coins.index') }}" class="text-gray-700 hover:text-gray-900">
                Каталог
            </a>
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">
                    Вход
                </a>
            @endif
            @if(Route::has('register'))
                <a href="{{ route('register') }}"
                   class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700">
                    Регистрация
                </a>
            @endif
        </nav>
    </div>
</header>

{{-- Контент страницы (форма логина / регистрации) --}}
<div class="min-h-[calc(100vh-4rem)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
        <a href="{{ route('coins.index') }}">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>

</body>
</html>
