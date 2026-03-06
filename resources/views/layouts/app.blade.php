<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Skybit Cloud') }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-[#0a0a0a] text-white min-h-screen">
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_15%_20%,rgba(255,255,255,0.09),transparent_30%),radial-gradient(circle_at_80%_0%,rgba(255,255,255,0.06),transparent_25%)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 py-6 flex flex-col gap-6">
        <header class="sticky top-4 z-20 flex flex-wrap items-center justify-between gap-3 border border-white/10 bg-black/35 backdrop-blur-md rounded-[18px] p-4">
            <div class="flex items-center gap-2 text-[12px] text-white/55 mr-4">SKYBIT</div>
            <div class="flex items-center gap-4 text-[14px] flex-wrap">
                <a href="{{ route('home') }}" class="text-white/80 hover:text-white">Главная</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white/80 hover:text-white">Панель</a>
                    <a href="{{ route('orders.index') }}" class="text-white/80 hover:text-white">Мои заказы</a>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.products.index') }}" class="text-white/80 hover:text-white">Админка</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-2">
                @guest
                    <x-button variant="secondary" href="{{ route('login') }}">Вход</x-button>
                    <x-button variant="primary" href="{{ route('register') }}">Регистрация</x-button>
                @endguest

                @auth
                    <span class="hidden md:inline text-[13px] text-white/65">{{ auth()->user()->name }}</span>
                    <x-button variant="secondary" action="{{ route('logout') }}" method="POST">Выйти</x-button>
                @endauth
            </div>
        </header>

        @if(session('success'))
            <div class="border border-emerald-400/30 bg-emerald-400/10 rounded-[12px] p-3 text-[14px]">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="border border-red-400/30 bg-red-400/10 rounded-[12px] p-3 text-[14px]">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="border border-red-400/30 bg-red-400/10 rounded-[12px] p-3 text-[14px]">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
