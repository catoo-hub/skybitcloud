<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $purchases = $user->serverPurchases()
            ->with('product')
            ->latest()
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('dashboard.index', compact('user', 'purchases', 'products'));
    }

    public function orders(Request $request)
    {
        $user = $request->user();

        $purchases = $user->serverPurchases()
            ->with('product')
            ->latest()
            ->get();

        return view('orders.index', compact('user', 'purchases'));
    }
}
