<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // return view('backend.pages.Dashboard');
        $total_earning = Order::sum('total');
        $total_order_count = Order::count();
        $total_categories = Category::count();
        $total_products = Product::count();
        $total_customers = User::where('role_id', 2)->count();
        $orders = Order::with(['billing', 'orderdetails'])->latest('id')->paginate(15);

        $order_on_2020 = Order::whereBetween('created_at', ['2022-01-01', '2022-12-31'])->count();
        $order_on_2021 = Order::whereBetween('created_at', ['2023-01-01', '2023-12-31'])->count();
        $order_on_2022 = Order::whereBetween('created_at', ['2024-01-01', '2024-12-31'])->count();

        $order_yearwise = array($order_on_2020, $order_on_2021, $order_on_2022);

        return view('backend.pages.Dashboard', compact(
            'total_earning',
            'total_order_count',
            'total_categories',
            'total_products',
            'total_customers',
            'orders',
            'order_yearwise',
        ));
    }
}
