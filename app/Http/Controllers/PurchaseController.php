<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ServerPurchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function create(Product $product)
    {
        if (! $product->is_active) {
            return redirect()->route('dashboard')->with('error', 'Товар недоступен для покупки');
        }

        return view('products.checkout', compact('product'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        if (! $product->is_active) {
            return back()->with('error', 'Товар недоступен для покупки');
        }

        $data = $request->validate([
            'server_name' => ['required', 'string', 'max:80'],
            'os' => ['required', 'in:ubuntu-22.04,ubuntu-24.04,debian-12,centos-9,almalinux-9'],
            'preset_software' => ['nullable', 'in:none,docker,nginx-php,nodejs,mysql'],
            'password_mode' => ['required', 'in:auto,manual'],
            'custom_password' => ['nullable', 'string', 'min:6', 'max:64'],
        ]);

        $username = 'srv_'.Str::lower(Str::random(6));
        $password = $data['password_mode'] === 'manual'
            ? $data['custom_password']
            : Str::password(12, true, true, false, false);

        if ($data['password_mode'] === 'manual' && blank($password)) {
            return back()->with('error', 'Введите пароль или выберите генерацию.')->withInput();
        }

        $serverName = trim($data['server_name']);

        ServerPurchase::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'status' => 'active',
            'power_state' => 'running',
            'server_name' => $serverName,
            'os' => $data['os'],
            'preset_software' => $data['preset_software'] ?? 'none',
            'ip_address' => '10.'.random_int(10, 250).'.'.random_int(10, 250).'.'.random_int(10, 250),
            'port' => 22,
            'username' => $username,
            'password' => $password,
            'expires_at' => now()->addMonth(),
            'last_reinstalled_at' => null,
        ]);

        return back()->with('success', 'Сервер куплен. Доступ выдан в панели.');
    }
}
