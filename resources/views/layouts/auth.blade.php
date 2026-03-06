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
    <div class="min-h-screen grid lg:grid-cols-2">
        <aside class="hidden lg:flex relative overflow-hidden border-r border-white/10">
            <img src="/bg_nav.png" alt="Auth Background" class="absolute inset-0 w-full h-full object-cover opacity-40">
            <div class="relative z-10 p-12 flex flex-col justify-between w-full bg-gradient-to-br from-black/50 to-transparent">
                <div class="space-y-4">
                    <p class="text-[14px] text-white/75">Skybit Cloud</p>
                    <h1 class="text-[44px] leading-[1.05] font-semibold max-w-[460px]">Безопасный вход в облачную панель управления</h1>
                    <p class="text-[16px] text-white/80 max-w-[470px]">Управляйте серверами, тарифами и доступами в одном месте. Все сервисы и доступы синхронизируются моментально.</p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-[13px] text-white/80">
                    <div class="border border-white/15 bg-white/5 rounded-[14px] p-3">SLA 99.99%</div>
                    <div class="border border-white/15 bg-white/5 rounded-[14px] p-3">24/7 support</div>
                    <div class="border border-white/15 bg-white/5 rounded-[14px] p-3">Instant deploy</div>
                </div>
            </div>
        </aside>

        <main class="flex items-center justify-center p-4 sm:p-8">
            <div class="w-full max-w-md border border-white/10 bg-white/5 rounded-[20px] p-6 sm:p-7">
                @if($errors->any())
                    <div class="border border-red-400/30 bg-red-400/10 rounded-[12px] p-3 text-[14px] mb-4">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
