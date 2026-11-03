<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel') · BeTrack</title>
    <link rel="icon" href="{{ asset('images/logo-icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-ink antialiased" x-data="{ open: false }">

    {{-- Barra lateral --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-200/70 bg-white transition-transform lg:translate-x-0"
           :class="{ 'translate-x-0': open }">
        <div class="flex items-center gap-3 px-6 py-6">
            <img src="{{ asset('images/logo-icon.png') }}" alt="BeTrack" class="h-11 w-auto object-contain">
            <div class="leading-tight">
                <p class="text-xl font-bold tracking-tight text-brand-dark">Be<span class="text-brand">Track</span></p>
                <p class="text-[11px] font-medium text-slate-500">Planifica · Avanza · Logra</p>
            </div>
        </div>

        {{-- Menú de navegación --}}
        <nav class="mt-2 space-y-1 px-4 text-sm font-medium">
            @php
                $link = fn($pattern, $route, $label) => '<a href="'.route($route).'" class="flex items-center rounded-xl px-4 py-2.5 transition '
                    .(request()->routeIs($pattern) ? 'bg-brand/10 text-brand' : 'text-slate-600 hover:bg-slate-50 hover:text-brand-dark').'">'.$label.'</a>';
            @endphp
            {!! $link('dashboard', 'dashboard', 'Dashboard') !!}
            {!! $link('projects.*', 'projects.index', 'Proyectos') !!}
            {{-- Próximos: Actividades, Acuerdos, Reportes, Historial, Usuarios --}}
        </nav>

        <div class="absolute inset-x-0 bottom-0 border-t border-slate-100 p-4">
            <div class="mb-3 px-2">
                <p class="text-sm font-semibold text-brand-dark">{{ auth()->user()->name }}</p>
                <p class="text-xs capitalize text-slate-500">{{ auth()->user()->role }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- Contenido --}}
    <div class="lg:pl-64">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200/70 bg-white/80 px-6 py-4 backdrop-blur">
            <div class="flex items-center gap-3">
                <button class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" @click="open = !open" aria-label="Menú">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-xl font-bold text-brand-dark">@yield('heading')</h1>
            </div>
            <span class="text-sm text-slate-500">{{ now()->translatedFormat('l d \d\e F, Y') }}</span>
        </header>

        <main class="p-6 lg:p-8">
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>