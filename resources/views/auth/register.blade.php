@extends('layouts.auth')

@section('content')
    <main class="w-full flex flex-col gap-5">
        <div>
            <h1 class="text-[28px] font-semibold">Создание аккаунта</h1>
            <p class="text-[14px] text-white/70 mt-1">После регистрации можно сразу купить сервер и получить доступ.</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-3">
            @csrf
            <label class="flex flex-col gap-1 text-[14px]">
                Имя
                <input name="name" type="text" value="{{ old('name') }}" class="bg-black/30 border border-white/20 rounded-[12px] p-2.5" required>
            </label>

            <label class="flex flex-col gap-1 text-[14px]">
                Email
                <input name="email" type="email" value="{{ old('email') }}" class="bg-black/30 border border-white/20 rounded-[12px] p-2.5" required>
            </label>

            <label class="flex flex-col gap-1 text-[14px]">
                Пароль
                <input name="password" type="password" class="bg-black/30 border border-white/20 rounded-[12px] p-2.5" required>
            </label>

            <label class="flex flex-col gap-1 text-[14px]">
                Подтвердите пароль
                <input name="password_confirmation" type="password" class="bg-black/30 border border-white/20 rounded-[12px] p-2.5" required>
            </label>

            <x-button type="submit" variant="primary" class="justify-center">Создать аккаунт</x-button>
        </form>

        <p class="text-[14px] text-white/75">
            Уже есть аккаунт?
            <a href="{{ route('login') }}" class="text-white underline">Войти</a>
        </p>
    </main>
@endsection
