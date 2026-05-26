<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::count();

        $categories = Category::count();

        $users = User::count();

        $orders = Order::where(
            'payment_status',
            'paid'
        )->count();

        $revenue = Order::where(
            'payment_status',
            'paid'
        )->sum('total');

        $categoryData = Category::withCount('products')->get();

        $labels = $categoryData->pluck('name');

        $data = $categoryData->pluck('products_count');

        $latestProducts = Product::latest()->take(5)->get();

        $topProducts = Product::withCount('orderItems')

            ->orderByDesc('order_items_count')

            ->take(5)

            ->get();

        $monthlySales = Order::where(
            'payment_status',
            'paid'
        )
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->pluck('total', 'month');


        return view('admin.dashboard', compact(
            'products',
            'categories',
            'users',
            'orders',
            'revenue',
            'latestProducts',
            'labels',
            'data',
            'topProducts',
            'monthlySales'
        ));
    }
}
