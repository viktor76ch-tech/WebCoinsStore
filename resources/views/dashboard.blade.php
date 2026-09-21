<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Личный кабинет') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p>Здравствуйте, <b>{{ auth()->user()->name }}</b>!</p>
                    <p>Ваш email: <b>{{ auth()->user()->email }}</b></p>
                    <p>Роль:
                        <b>{{ auth()->user()->role === 'admin' ? 'Администратор' : 'Пользователь' }}</b>
                    </p>

                    <div class="flex gap-4 pt-4">
                        <a href="{{ url('/profile') }}"
                           class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                            Редактировать профиль
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">
                                Админ-панель
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
