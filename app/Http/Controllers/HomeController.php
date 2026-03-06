<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $products = collect();

        if (Schema::hasTable('products')) {
            $products = Product::query()
                ->where('is_active', true)
                ->orderBy('price')
                ->take(3)
                ->get();
        }

        return view('welcome', compact('products'));
    }
}
