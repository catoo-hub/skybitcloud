@extends('layouts.app')

@section('content')
    <main class="max-w-3xl w-full mx-auto flex flex-col gap-6">
        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <h1 class="text-[30px] font-semibold">Покупка сервера</h1>
            <p class="text-white/70 text-[14px] mt-1">Настройте параметры и подтвердите заказ.</p>
        </section>

        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6 flex flex-col gap-4">
            <div>
                <p class="text-[20px] font-medium">{{ $product->name }}</p>
                <p class="text-[13px] text-white/70">{{ $product->description }}</p>
                <p class="text-[28px] font-semibold mt-2">₽{{ number_format($product->price, 0, ',', ' ') }}<span class="text-[13px] text-white/70">/мес</span></p>
                <p class="text-[13px] text-white/80 mt-1">{{ $product->cpu }} vCPU • {{ $product->ram_gb }} GB RAM • {{ $product->disk_gb }} GB NVMe</p>
            </div>

            <form action="{{ route('products.buy', $product) }}" method="POST" class="flex flex-col gap-3">
                @csrf

                <label class="text-[13px] text-white/75 flex flex-col gap-1">
                    Название сервера
                    <input
                        name="server_name"
                        type="text"
                        value="{{ old('server_name', $product->slug . '-' . substr(md5(auth()->id() . $product->id), 0, 4)) }}"
                        class="bg-black/20 border border-white/15 rounded-[10px] p-2"
                        required
                    >
                </label>

                <div class="grid md:grid-cols-2 gap-3">
                    <label class="text-[13px] text-white/75 flex flex-col gap-1">
                        Операционная система
                        <select name="os" class="bg-black/20 border border-white/15 rounded-[10px] p-2" required>
                            <option value="ubuntu-22.04">Ubuntu 22.04</option>
                            <option value="ubuntu-24.04">Ubuntu 24.04</option>
                            <option value="debian-12">Debian 12</option>
                            <option value="centos-9">CentOS 9</option>
                            <option value="almalinux-9">AlmaLinux 9</option>
                        </select>
                    </label>

                    <label class="text-[13px] text-white/75 flex flex-col gap-1">
                        Предустановленное ПО
                        <select name="preset_software" class="bg-black/20 border border-white/15 rounded-[10px] p-2">
                            <option value="none">Без ПО</option>
                            <option value="docker">Docker</option>
                            <option value="nginx-php">Nginx + PHP</option>
                            <option value="nodejs">Node.js</option>
                            <option value="mysql">MySQL</option>
                        </select>
                    </label>
                </div>

                <div class="grid md:grid-cols-2 gap-3">
                    <label class="text-[13px] text-white/75 flex flex-col gap-1">
                        Пароль
                        <select name="password_mode" class="bg-black/20 border border-white/15 rounded-[10px] p-2">
                            <option value="auto">Сгенерировать</option>
                            <option value="manual">Указать вручную</option>
                        </select>
                    </label>

                    <label class="text-[13px] text-white/75 flex flex-col gap-1">
                        Свой пароль
                        <input name="custom_password" type="text" class="bg-black/20 border border-white/15 rounded-[10px] p-2" placeholder="Если выбран manual">
                    </label>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <x-button type="submit" variant="primary">Подтвердить покупку</x-button>
                    <x-button href="{{ route('dashboard') }}" variant="secondary">Назад</x-button>
                </div>
            </form>
        </section>
    </main>
@endsection
