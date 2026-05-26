<?php

namespace App\Http\Controllers;

use App\Models\Order;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(5);

        return view('frontend.orders.index', compact('orders'));
    }
}
