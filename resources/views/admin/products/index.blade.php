@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-6">
        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <h1 class="text-[26px] font-semibold">Админка: товары</h1>
            <p class="text-white/75 text-[14px] mt-1">Добавление тарифов для продажи серверов.</p>
        </section>

        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <form action="{{ route('admin.products.store') }}" method="POST" class="grid md:grid-cols-2 gap-3">
                @csrf
                <label class="flex flex-col gap-1 text-[14px]">
                    Название
                    <input name="name" type="text" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    Цена
                    <input name="price" type="number" min="1" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px] md:col-span-2">
                    Описание
                    <input name="description" type="text" class="bg-transparent border border-white/20 rounded-[10px] p-2">
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    CPU
                    <input name="cpu" type="number" min="1" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    RAM (GB)
                    <input name="ram_gb" type="number" min="1" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    Disk (GB)
                    <input name="disk_gb" type="number" min="1" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex items-center gap-2 text-[14px] mt-6">
                    <input type="checkbox" name="is_active" value="1" checked>
                    Активный товар
                </label>

                <div class="md:col-span-2">
                    <x-button type="submit" variant="primary">Добавить товар</x-button>
                </div>
            </form>
        </section>

        <section class="overflow-x-auto border border-white/10 bg-white/5 rounded-[20px]">
            <table class="w-full text-left text-[14px]">
                <thead class="border-b border-white/10 text-white/70">
                    <tr>
                        <th class="p-3">Название</th>
                        <th class="p-3">Цена</th>
                        <th class="p-3">Ресурсы</th>
                        <th class="p-3">Slug</th>
                        <th class="p-3">Статус</th>
                        <th class="p-3">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b border-white/5">
                            <td class="p-3">{{ $product->name }}</td>
                            <td class="p-3">₽{{ number_format($product->price, 0, ',', ' ') }}</td>
                            <td class="p-3">{{ $product->cpu }} / {{ $product->ram_gb }}GB / {{ $product->disk_gb }}GB</td>
                            <td class="p-3">{{ $product->slug }}</td>
                            <td class="p-3">{{ $product->is_active ? 'active' : 'disabled' }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <x-button href="{{ route('admin.products.edit', $product) }}" variant="secondary" class="text-[12px]">Редактировать</x-button>
                                    <x-button action="{{ route('admin.products.destroy', $product) }}" method="DELETE" variant="danger" class="text-[12px]">Удалить</x-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-3 text-white/70" colspan="6">Товары не добавлены.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
@endsection
