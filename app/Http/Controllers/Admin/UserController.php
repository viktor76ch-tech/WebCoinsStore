<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount('orders');
        $orders = $user->orders()->orderByDesc('created_at')->limit(20)->get();

        return view('admin.users.show', compact('user', 'orders'));
    }
}
