@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-6">
        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <div class="flex flex-wrap justify-between gap-4 items-end">
                <div>
                    <h1 class="text-[30px] font-semibold">Панель управления</h1>
                    <p class="text-white/75 text-[14px] mt-1">{{ $user->name }} • {{ $user->email }}</p>
                </div>
                <x-button href="{{ route('orders.index') }}" variant="secondary">Открыть мои заказы</x-button>
            </div>
        </section>

        <section class="grid md:grid-cols-3 gap-4">
            <div class="rounded-[18px] border border-white/10 bg-white/5 p-4">
                <p class="text-[12px] text-white/65">Включенные серверы</p>
                <p class="text-[28px] font-semibold mt-1">{{ $purchases->where('power_state', 'running')->count() }}</p>
            </div>
            <div class="rounded-[18px] border border-white/10 bg-white/5 p-4">
                <p class="text-[12px] text-white/65">Всего заказов</p>
                <p class="text-[28px] font-semibold mt-1">{{ $purchases->count() }}</p>
            </div>
            <div class="rounded-[18px] border border-white/10 bg-white/5 p-4">
                <p class="text-[12px] text-white/65">Админ-доступ</p>
                <p class="text-[28px] font-semibold mt-1">{{ $user->is_admin ? 'Да' : 'Нет' }}</p>
            </div>
        </section>

        <section class="flex flex-col gap-3">
            <h2 class="text-[22px] font-semibold">Купить сервер</h2>
            <div class="grid md:grid-cols-3 gap-4">
                @forelse($products as $product)
                    <article class="border border-white/10 bg-white/5 rounded-[16px] p-4 flex flex-col gap-3">
                        <div>
                            <p class="text-[18px] font-medium">{{ $product->name }}</p>
                            <p class="text-[13px] text-white/70">{{ $product->description }}</p>
                        </div>
                        <p class="text-[26px] font-semibold">₽{{ number_format($product->price, 0, ',', ' ') }}<span class="text-[13px] text-white/70">/мес</span></p>
                        <p class="text-[13px] text-white/80">{{ $product->cpu }} vCPU • {{ $product->ram_gb }} GB RAM • {{ $product->disk_gb }} GB NVMe</p>

                        <x-button href="{{ route('products.checkout', $product) }}" variant="primary" class="justify-center">Купить сервер</x-button>
                    </article>
                @empty
                    <p class="text-white/70">Нет доступных тарифов.</p>
                @endforelse
            </div>
        </section>
    </main>
@endsection
