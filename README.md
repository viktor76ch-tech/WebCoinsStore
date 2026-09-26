# Нумизматика — веб-магазин монет

Курсовой проект: интернет-магазин нумизматики на Laravel.
Каталог монет, корзина, оформление заказа, mock-оплата, личный кабинет и админ-панель.

## Стек

- **PHP** 8.2+
- **Laravel** 11/12/13
- **MySQL** 5.7+ / MariaDB
- **Blade** + **Bootstrap 5** (CDN, без сборки)
- **Composer** — единственная зависимость
- **Node.js / Vite — не используются**

## Возможности

### Гость
- Каталог монет с фильтрами (страна, состояние, год, поиск)
- Просмотр карточки монеты
- Регистрация и вход

### Пользователь
- Личный кабинет: редактирование профиля, смена пароля
- Корзина (сохраняется в БД)
- Оформление заказа: адрес, телефон, комментарий
- Mock-оплата: «Оплатить» / «Отменить»
- Список своих заказов и просмотр деталей

### Администратор
- Дашборд: пользователи, монеты, заказы, выручка
- CRUD монет: создание, редактирование, soft delete, восстановление
- Управление количеством на складе
- Все заказы: смена статусов, отмена с возвратом остатка
- Список и просмотр пользователей

## Требования к окружению

- PHP 8.2 или выше с расширениями: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- Composer 2
- MySQL / MariaDB

## Установка

### 1. Клонировать репозиторий

```bash
git clone https://github.com/viktor76ch-tech/WebCoinsStore
cd numismatics
```

### 2. Установить зависимости

```bash
composer install
```

### 3. Настроить `.env`

```bash
cp .env.example .env
```

Открыть `.env` и указать параметры своей БД:

```env
DB_DATABASE=numismatics
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Создать базу данных

```sql
CREATE DATABASE numismatics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Сгенерировать ключ приложения

```bash
php artisan key:generate
```

### 6. Выполнить миграции и сиды

```bash
php artisan migrate --seed
```

### 7. Запустить локальный сервер

```bash
php artisan serve
```

Открыть `http://127.0.0.1:8000`.

## Тестовые аккаунты

| Роль | Email | Пароль |
|------|-------|--------|
| Администратор | `admin@example.com` | `password` |
| Пользователь | `user@example.com` | `password` |

## Сценарий проверки

1. Открыть каталог `/coins` под гостем.
2. Зарегистрироваться или войти под `user@example.com`.
3. Добавить 2–3 монеты в корзину.
4. Оформить заказ (`/cart` → «Оформить заказ»).
5. Заполнить адрес, перейти к оплате.
6. Нажать «Оплатить» — заказ станет «Оплачен».
7. Открыть «Мои заказы» — заказ в списке.
8. Войти как `admin@example.com`.
9. Открыть `/admin` — дашборд с метриками.
10. Открыть «Монеты» — добавить новую, изменить остаток, удалить, восстановить.
11. Открыть «Заказы» — сменить статус на «Отправлен».
12. Открыть «Пользователи» — просмотреть профиль.

## Архитектура

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          ← админ-панель
│   │   ├── Auth/           ← Breeze
│   │   ├── CartController
│   │   ├── CheckoutController
│   │   ├── CoinController
│   │   ├── OrderController
│   │   └── PaymentController
│   ├── Middleware/
│   │   └── AdminMiddleware
│   └── Requests/           ← FormRequest-валидация
├── Models/
│   ├── Cart, CartItem
│   ├── Coin, Order, OrderItem
│   └── User
├── Policies/               ← OrderPolicy, CartItemPolicy
└── Services/
    └── Payments/           ← PaymentGatewayInterface + MockPaymentGateway

resources/views/
├── admin/                  ← CRUD админки
├── auth/                   ← логин/регистрация (Breeze)
├── cart/                   ← корзина
├── checkout/               ← оформление
├── coins/                  ← каталог и карточка монеты
├── errors/                 ← 403, 404, 419, 500
├── layouts/                ← shop, admin, guest
├── orders/                 ← заказы пользователя
└── payment/                ← страница оплаты
```

## Оплата

Оплата **демонстрационная**. Реализована через интерфейс `PaymentGatewayInterface`
с реализацией `MockPaymentGateway`. Чтобы подключить реальный провайдер (ЮKassa, Stripe):

1. Создать класс `YooKassaGateway implements PaymentGatewayInterface`.
2. Забиндить его в `AppServiceProvider` вместо `MockPaymentGateway`.
3. Контроллер `PaymentController` не меняется — он работает через интерфейс.

## Ограничения MVP

- Без реальной оплаты
- Без доставки и интеграции с курьерами
- Без очередей и микросервисов
- Без сложной аналитики

## Лицензия

Учебный проект.
