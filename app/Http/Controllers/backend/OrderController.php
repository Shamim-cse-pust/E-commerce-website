<?php

namespace App\Http\Controllers\backend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders=Order::with(['billing', 'orderdetails'])->latest('id')->paginate(15);
        return view('backend.pages.Order.index',compact('orders'));
    }
}
