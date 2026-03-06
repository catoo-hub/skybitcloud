<?php

namespace App\Http\Controllers;

use App\Models\ServerPurchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServerMachineController extends Controller
{
    public function show(Request $request, ServerPurchase $purchase)
    {
        $this->authorizePurchase($request, $purchase);

        $purchase->load('product');

        return view('orders.manage', compact('purchase'));
    }

    public function powerOn(Request $request, ServerPurchase $purchase): RedirectResponse
    {
        $this->authorizePurchase($request, $purchase);

        $purchase->update([
            'power_state' => 'running',
            'status' => 'active',
        ]);

        return back()->with('success', 'Сервер включен');
    }

    public function powerOff(Request $request, ServerPurchase $purchase): RedirectResponse
    {
        $this->authorizePurchase($request, $purchase);

        $purchase->update([
            'power_state' => 'stopped',
            'status' => 'inactive',
        ]);

        return back()->with('success', 'Сервер выключен');
    }

    public function changePassword(Request $request, ServerPurchase $purchase): RedirectResponse
    {
        $this->authorizePurchase($request, $purchase);

        $data = $request->validate([
            'password_mode' => ['required', 'in:auto,manual'],
            'new_password' => ['nullable', 'string', 'min:6', 'max:64'],
        ]);

        $password = $data['password_mode'] === 'manual'
            ? $data['new_password']
            : Str::password(12, true, true, false, false);

        if ($data['password_mode'] === 'manual' && blank($password)) {
            return back()->with('error', 'Введите новый пароль');
        }

        $purchase->update([
            'password' => $password,
        ]);

        return back()->with('success', 'Пароль сервера обновлён');
    }

    public function reinstall(Request $request, ServerPurchase $purchase): RedirectResponse
    {
        $this->authorizePurchase($request, $purchase);

        $data = $request->validate([
            'os' => ['required', 'in:ubuntu-22.04,ubuntu-24.04,debian-12,centos-9,almalinux-9'],
            'preset_software' => ['nullable', 'in:none,docker,nginx-php,nodejs,mysql'],
            'password_mode' => ['required', 'in:auto,manual'],
            'new_password' => ['nullable', 'string', 'min:6', 'max:64'],
        ]);

        $password = $data['password_mode'] === 'manual'
            ? $data['new_password']
            : Str::password(12, true, true, false, false);

        if ($data['password_mode'] === 'manual' && blank($password)) {
            return back()->with('error', 'Введите новый пароль для переустановки');
        }

        $purchase->update([
            'os' => $data['os'],
            'preset_software' => $data['preset_software'] ?? 'none',
            'password' => $password,
            'status' => 'active',
            'power_state' => 'running',
            'last_reinstalled_at' => now(),
        ]);

        return back()->with('success', 'Переустановка завершена');
    }

    public function destroy(Request $request, ServerPurchase $purchase): RedirectResponse
    {
        $this->authorizePurchase($request, $purchase);

        $purchase->delete();

        return redirect()->route('orders.index')->with('success', 'Машина удалена');
    }

    private function authorizePurchase(Request $request, ServerPurchase $purchase): void
    {
        if ($purchase->user_id !== $request->user()->id && ! $request->user()->is_admin) {
            abort(403);
        }
    }
}
