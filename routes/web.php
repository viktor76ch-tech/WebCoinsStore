<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

// Админские контроллеры
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CoinController as AdminCoinController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', function () {
    $coins = \App\Models\Coin::query()
        ->where('status', 'available')
        ->orderByDesc('created_at')
        ->limit(4)
        ->get();

    return view('home', compact('coins'));
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== Публичный каталог =====
Route::get('/coins', [CoinController::class, 'index'])->name('coins.index');
Route::get('/coins/{coin}', [CoinController::class, 'show'])->name('coins.show');

// ===== Корзина =====
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{coin}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/item/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// ===== Checkout, Payment, Orders пользователя =====
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::post('/payment/{order}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// ===== Админка =====
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Пользователи
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');

        // Категории
        Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        // Монеты
        Route::get('/coins', [AdminCoinController::class, 'index'])->name('coins.index');
        Route::get('/coins/create', [AdminCoinController::class, 'create'])->name('coins.create');
        Route::post('/coins', [AdminCoinController::class, 'store'])->name('coins.store');
        Route::get('/coins/{coin}/edit', [AdminCoinController::class, 'edit'])->name('coins.edit');
        Route::put('/coins/{coin}', [AdminCoinController::class, 'update'])->name('coins.update');
        Route::delete('/coins/{coin}', [AdminCoinController::class, 'destroy'])->name('coins.destroy');
        Route::post('/coins/{id}/restore', [AdminCoinController::class, 'restore'])->name('coins.restore');

        // Заказы
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    });

require __DIR__.'/auth.php';
