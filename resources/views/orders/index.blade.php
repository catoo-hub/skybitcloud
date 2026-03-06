@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-6">
        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <h1 class="text-[30px] font-semibold">Мои заказы</h1>
            <p class="text-white/70 text-[14px] mt-1">История покупок серверов и выданные доступы.</p>
        </section>

        <section class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($purchases as $purchase)
                <article class="border border-white/10 bg-white/5 rounded-[18px] p-5 flex flex-col gap-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-[18px] font-medium">{{ $purchase->product->name }}</p>
                            <p class="text-[12px] text-white/65">{{ $purchase->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <span class="text-[12px] border border-white/20 rounded-full px-3 py-1 inline-flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full {{ $purchase->power_state === 'running' ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                            {{ $purchase->power_state === 'running' ? 'Включен' : 'Выключен' }}
                        </span>
                    </div>

                    <div class="text-[14px] text-white/85 space-y-1">
                        <p>Сервер: {{ $purchase->server_name }}</p>
                        <p>ОС: {{ $purchase->os }}</p>
                        <p>ПО: {{ $purchase->preset_software ?? 'none' }}</p>
                        <p>IP: {{ $purchase->ip_address }}:{{ $purchase->port }}</p>
                        <p>Статус: {{ $purchase->status }}</p>
                    </div>

                    <p class="text-[12px] text-white/70 mt-1">Доступ до: {{ optional($purchase->expires_at)->format('d.m.Y H:i') ?? '—' }}</p>

                    <x-button href="{{ route('orders.manage', $purchase) }}" variant="secondary" class="justify-center text-[13px]">Управление сервером</x-button>
                </article>
            @empty
                <div class="border border-white/10 bg-white/5 rounded-[18px] p-5 text-white/70 text-[14px] md:col-span-2 xl:col-span-3">
                    Заказов пока нет. Перейдите в панель и купите первый сервер.
                </div>
            @endforelse
        </section>
    </main>
@endsection
