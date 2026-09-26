<nav class="navbar navbar-expand-lg navbar-dark navbar-shop">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('coins.index') }}">
            <i class="bi bi-coin"></i> Нумизматика
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('coins.*') ? 'active' : '' }}"
                       href="{{ route('coins.index') }}">Каталог</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                           href="{{ route('orders.index') }}">Мои заказы</a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">Админка</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav align-items-center">
                @auth
                    @php
                        $cartCount = Auth::user()->getOrCreateCart()->items()->sum('quantity');
                    @endphp
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <span style="position:relative; display:inline-block; line-height:1;">
                                <i class="bi bi-cart3 fs-5"></i>
                                @if($cartCount > 0)
                                    <span style="position:absolute; top:-8px; right:-12px;
                                                 background:#dc3545; color:#fff;
                                                 border-radius:10px; padding:1px 6px;
                                                 font-size:0.7rem; line-height:1.2;">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Кабинет</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профиль</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Выход</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Вход</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-shop-accent btn-sm" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
