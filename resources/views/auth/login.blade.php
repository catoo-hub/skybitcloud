@extends('layouts.auth')

@section('content')
    <main class="w-full flex flex-col gap-5">
        <div>
            <h1 class="text-[28px] font-semibold">Вход в панель</h1>
            <p class="text-[14px] text-white/70 mt-1">Управляйте серверами и заказами из личного кабинета.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-3">
            @csrf
            <label class="flex flex-col gap-1 text-[14px]">
                Email
                <input name="email" type="email" value="{{ old('email') }}" class="bg-black/30 border border-white/20 rounded-[12px] p-2.5" required>
            </label>

            <label class="flex flex-col gap-1 text-[14px]">
                Пароль
                <input name="password" type="password" class="bg-black/30 border border-white/20 rounded-[12px] p-2.5" required>
            </label>

            <label class="flex items-center gap-2 text-[13px] text-white/80">
                <input type="checkbox" name="remember" value="1">
                Запомнить меня
            </label>

            <x-button type="submit" variant="primary" class="justify-center mt-1">Войти</x-button>
        </form>

        <p class="text-[14px] text-white/75">
            Нет аккаунта?
            <a href="{{ route('register') }}" class="text-white underline">Зарегистрироваться</a>
        </p>
    </main>
@endsection
