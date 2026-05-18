<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#06141B">
    <link rel="manifest" href="/manifest.json">
    <title>{{ config('app.name', 'CemeteryMS') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#06141B] text-[#CCD0CF]">
    <div class="min-h-screen lg:flex">
        <aside class="hidden lg:flex lg:w-72 lg:flex-col border-r border-white/10 bg-[#06141B]/90">
            <div class="px-6 py-6">
                <div class="text-2xl font-bold text-white">CemeteryMS</div>
                <div class="mt-1 text-sm text-[#9BA8AB]">Enterprise cemetery operations</div>
            </div>
            <nav class="flex-1 space-y-1 px-4">
                @php
                    $links = [
                        ['Dashboard', 'dashboard'],
                        ['Clients', 'clients.index'],
                        ['Cemetery Map', 'map.index'],
                        ['Billing', 'billing.index'],
                        ['Payments', 'payments.index'],
                        ['Guard Terminal', 'guard.index'],
                        ['Reports', 'reports.index'],
                        ['Collector PWA', 'collector.app'],
                    ];
                @endphp
                @foreach ($links as [$label, $route])
                    @if (Route::has($route))
                        <a href="{{ route($route) }}" class="block rounded-lg px-4 py-3 text-sm font-medium transition {{ request()->routeIs($route) ? 'bg-white/12 text-white shadow-lg shadow-black/20' : 'text-[#9BA8AB] hover:bg-white/8 hover:text-white' }}">
                            {{ $label }}
                        </a>
                    @endif
                @endforeach
            </nav>
            <div class="px-4 py-6">
                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                    <div class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Guest' }}</div>
                    <div class="mt-1 text-xs text-[#9BA8AB]">{{ auth()->user()?->roles->pluck('name')->join(', ') }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button class="w-full rounded-lg bg-[#253745] px-3 py-2 text-sm text-white transition hover:bg-[#4A5C6A]">Sign out</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex min-h-screen flex-1 flex-col">
            <header class="sticky top-0 z-30 border-b border-white/10 bg-[#06141B]/85 px-4 py-4 backdrop-blur lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs uppercase text-[#9BA8AB]">CemeteryMS</div>
                        <h1 class="mt-1 text-xl font-semibold text-white">{{ $header ?? 'Operations Console' }}</h1>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm text-[#CCD0CF] transition hover:bg-white/10">Profile</a>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">{{ session('status') }}</div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
