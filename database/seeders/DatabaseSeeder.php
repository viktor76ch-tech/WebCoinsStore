<?php

namespace Database\Seeders;

use App\Models\Coin;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Администратор
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Обычный пользователь
        $user = User::create([
            'name' => 'Иван',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Монеты
        $coins = [
            [
                'title' => '1 рубль 1898 года',
                'description' => 'Серебряный рубль Николая II. Отличная сохранность.',
                'price' => 12500.00,
                'year' => 1898,
                'country' => 'Российская империя',
                'condition' => 'VF',
                'status' => 'available',
                'image_url' => null,
            ],
            [
                'title' => '5 копеек 1789 года',
                'description' => 'Медная монета Екатерины II.',
                'price' => 3200.00,
                'year' => 1789,
                'country' => 'Российская империя',
                'condition' => 'F',
                'status' => 'available',
                'image_url' => null,
            ],
            [
                'title' => '10 марок 1913 года',
                'description' => 'Золотая монета Германской империи.',
                'price' => 45000.00,
                'year' => 1913,
                'country' => 'Германия',
                'condition' => 'XF',
                'status' => 'available',
                'image_url' => null,
            ],
            [
                'title' => '1 доллар 1922 года (Morgan)',
                'description' => 'Серебряный доллар США, тип Morgan.',
                'price' => 8700.00,
                'year' => 1922,
                'country' => 'США',
                'condition' => 'AU',
                'status' => 'reserved',
                'image_url' => null,
            ],
            [
                'title' => '20 франков 1855 года',
                'description' => 'Золотая монета Франции, Наполеон III.',
                'price' => 52000.00,
                'year' => 1855,
                'country' => 'Франция',
                'condition' => 'XF',
                'status' => 'available',
                'image_url' => null,
            ],
            [
                'title' => '2 копейки 1810 года',
                'description' => 'Медная монета Александра I.',
                'price' => 1800.00,
                'year' => 1810,
                'country' => 'Российская империя',
                'condition' => 'VG',
                'status' => 'available',
                'image_url' => null,
            ],
            [
                'title' => '5 рублей 1900 года',
                'description' => 'Золотая монета Николая II.',
                'price' => 68000.00,
                'year' => 1900,
                'country' => 'Российская империя',
                'condition' => 'XF',
                'status' => 'sold',
                'image_url' => null,
            ],
            [
                'title' => '1 крона 1897 года',
                'description' => 'Серебряная монета Австро-Венгрии.',
                'price' => 2900.00,
                'year' => 1897,
                'country' => 'Австро-Венгрия',
                'condition' => 'VF',
                'status' => 'available',
                'image_url' => null,
            ],
        ];

        foreach ($coins as $coinData) {
            Coin::create($coinData);
        }

        // Заказы
        $order1 = Order::create([
            'user_id' => $user->id,
            'number' => Order::generateNumber(),
            'total_price' => 12500.00,
            'status' => 'paid',
            'payment_method' => 'mock',
            'payment_status' => 'paid',
            'payment_ref' => 'MOCK-' . strtoupper(uniqid()),
            'customer_name' => $user->name,
            'phone' => '+7 900 000-00-00',
            'delivery_address' => 'г. Москва, ул. Пример, д. 1, кв. 1',
            'paid_at' => now(),
        ]);

        $order1->items()->create([
            'coin_id' => 1,
            'quantity' => 1,
            'price' => 12500.00,
        ]);

        $order2 = Order::create([
            'user_id' => $user->id,
            'number' => Order::generateNumber(),
            'total_price' => 3200.00,
            'status' => 'pending_payment',
            'payment_status' => 'unpaid',
            'customer_name' => $user->name,
            'phone' => '+7 900 000-00-00',
            'delivery_address' => 'г. Москва, ул. Пример, д. 1, кв. 1',
        ]);

        $order2->items()->create([
            'coin_id' => 2,
            'quantity' => 1,
            'price' => 3200.00,
        ]);
    }
}
