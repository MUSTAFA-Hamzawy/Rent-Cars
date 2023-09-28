<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __invoke()
    {
        $stats = [];
        $stats['orders_count'] = Order::where('order_status', '<>', '-1')->count();
        $stats['brands_count'] = Brand::all('id')->count();
        $stats['users_count']  = User::all('id')->count();
        $stats['cars_count']   = Car::all('id')->count();
        $stats['last_orders']  = Order::orderBy('created_at')->get()->take(10);

        return view('backend.dashboard', ['stats' => $stats]);
    }
}
