<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'coins' => Coin::count(),
            'coins_in_stock' => Coin::where('quantity', '>', 0)->count(),
            'coins_out_of_stock' => Coin::where('quantity', '=', 0)->count(),
            'orders' => Order::count(),
            'orders_paid' => Order::where('payment_status', 'paid')->count(),
            'orders_pending' => Order::where('status', 'pending_payment')->count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total_price'),
        ];

        $recentOrders = Order::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
