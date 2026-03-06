@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-6">
        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <h1 class="text-[28px] font-semibold">Редактирование товара</h1>
            <p class="text-white/70 text-[14px] mt-1">Обновите параметры тарифа и сохраните изменения.</p>
        </section>

        <section class="border border-white/10 bg-white/5 rounded-[20px] p-6">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" class="grid md:grid-cols-2 gap-4">
                @csrf
                @method('PATCH')

                <label class="flex flex-col gap-1 text-[14px]">
                    Название
                    <input name="name" type="text" value="{{ old('name', $product->name) }}" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    Цена
                    <input name="price" type="number" min="1" value="{{ old('price', $product->price) }}" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px] md:col-span-2">
                    Описание
                    <input name="description" type="text" value="{{ old('description', $product->description) }}" class="bg-transparent border border-white/20 rounded-[10px] p-2">
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    CPU
                    <input name="cpu" type="number" min="1" value="{{ old('cpu', $product->cpu) }}" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    RAM (GB)
                    <input name="ram_gb" type="number" min="1" value="{{ old('ram_gb', $product->ram_gb) }}" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex flex-col gap-1 text-[14px]">
                    Disk (GB)
                    <input name="disk_gb" type="number" min="1" value="{{ old('disk_gb', $product->disk_gb) }}" class="bg-transparent border border-white/20 rounded-[10px] p-2" required>
                </label>

                <label class="flex items-center gap-2 text-[14px] mt-6">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    Активный товар
                </label>

                <div class="md:col-span-2 flex items-center gap-2">
                    <x-button type="submit" variant="primary">Сохранить</x-button>
                    <x-button href="{{ route('admin.products.index') }}" variant="secondary">Назад</x-button>
                </div>
            </form>
        </section>
    </main>
@endsection
