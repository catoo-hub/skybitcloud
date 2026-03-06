@extends('layouts.app')

@section('content')
    <main class="max-w-3xl w-full mx-auto flex flex-col gap-6">
        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-[30px] font-semibold">Управление сервером</h1>
                    <p class="text-white/70 text-[14px] mt-1">{{ $purchase->server_name }} • {{ $purchase->product->name }}</p>
                </div>
                <span class="text-[12px] border border-white/20 rounded-full px-3 py-1 inline-flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full {{ $purchase->power_state === 'running' ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                    {{ $purchase->power_state === 'running' ? 'Включен' : 'Выключен' }}
                </span>
            </div>
        </section>

        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6 flex flex-col gap-3 text-[14px]">
            <p>IP: {{ $purchase->ip_address }}:{{ $purchase->port }}</p>
            <p>ОС: {{ $purchase->os }}</p>
            <p>ПО: {{ $purchase->preset_software ?? 'none' }}</p>
            <p>Логин: {{ $purchase->username }}</p>
            <p>Пароль: {{ $purchase->password }}</p>
        </section>

        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6 flex flex-col gap-3">
            <h2 class="text-[20px] font-semibold">Питание</h2>
            <div class="flex gap-2 flex-wrap">
                <x-button action="{{ route('purchases.power-on', $purchase) }}" method="PATCH" variant="primary">Включить</x-button>
                <x-button action="{{ route('purchases.power-off', $purchase) }}" method="PATCH" variant="secondary">Выключить</x-button>
            </div>
        </section>

        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6 flex flex-col gap-3">
            <h2 class="text-[20px] font-semibold">Смена пароля</h2>

            <form action="{{ route('purchases.password', $purchase) }}" method="POST" class="grid md:grid-cols-3 gap-2 items-end">
                @csrf
                @method('PATCH')
                <label class="text-[13px] text-white/75 flex flex-col gap-1">
                    Режим
                    <select name="password_mode" class="bg-black/20 border border-white/15 rounded-[10px] p-2">
                        <option value="auto">Сгенерировать</option>
                        <option value="manual">Свой пароль</option>
                    </select>
                </label>
                <label class="text-[13px] text-white/75 flex flex-col gap-1 md:col-span-2">
                    Новый пароль
                    <input name="new_password" type="text" class="bg-black/20 border border-white/15 rounded-[10px] p-2" placeholder="Заполнить при manual">
                </label>
                <x-button type="submit" variant="secondary">Обновить пароль</x-button>
            </form>
        </section>

        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6 flex flex-col gap-3">
            <h2 class="text-[20px] font-semibold">Переустановка</h2>
            <form action="{{ route('purchases.reinstall', $purchase) }}" method="POST" class="grid md:grid-cols-2 gap-2">
                @csrf
                @method('PATCH')

                <label class="text-[13px] text-white/75 flex flex-col gap-1">
                    ОС
                    <select name="os" class="bg-black/20 border border-white/15 rounded-[10px] p-2" required>
                        <option value="ubuntu-22.04">Ubuntu 22.04</option>
                        <option value="ubuntu-24.04">Ubuntu 24.04</option>
                        <option value="debian-12">Debian 12</option>
                        <option value="centos-9">CentOS 9</option>
                        <option value="almalinux-9">AlmaLinux 9</option>
                    </select>
                </label>

                <label class="text-[13px] text-white/75 flex flex-col gap-1">
                    ПО
                    <select name="preset_software" class="bg-black/20 border border-white/15 rounded-[10px] p-2">
                        <option value="none">Без ПО</option>
                        <option value="docker">Docker</option>
                        <option value="nginx-php">Nginx + PHP</option>
                        <option value="nodejs">Node.js</option>
                        <option value="mysql">MySQL</option>
                    </select>
                </label>

                <label class="text-[13px] text-white/75 flex flex-col gap-1">
                    Пароль
                    <select name="password_mode" class="bg-black/20 border border-white/15 rounded-[10px] p-2">
                        <option value="auto">Сгенерировать</option>
                        <option value="manual">Свой пароль</option>
                    </select>
                </label>

                <label class="text-[13px] text-white/75 flex flex-col gap-1">
                    Новый пароль
                    <input name="new_password" type="text" class="bg-black/20 border border-white/15 rounded-[10px] p-2" placeholder="Заполнить при manual">
                </label>

                <div class="md:col-span-2 flex items-center gap-2">
                    <x-button type="submit" variant="primary">Переустановить</x-button>
                    <x-button action="{{ route('purchases.destroy', $purchase) }}" method="DELETE" variant="danger">Удалить машину</x-button>
                </div>
            </form>
        </section>
    </main>
@endsection
