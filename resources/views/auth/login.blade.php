<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión · BeTrack</title>
    <link rel="icon" href="{{ asset('images/logo-icon.png') }}">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen font-sans antialiased">

    {{-- Panel izquierdo de marca --}}
    <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden p-12 text-white lg:flex"
         style="background-image: linear-gradient(135deg, #2F295B 0%, #5F3AD7 55%, #1573F7 100%)">
        <div class="flex items-center gap-3">
            <div class="rounded-2xl bg-white p-2.5 shadow-lg">
                <img src="{{ asset('images/logo-icon.png') }}" alt="BeTrack" class="h-10 w-auto object-contain">
            </div>
            <span class="text-2xl font-bold tracking-tight">BeTrack</span>
        </div>
        <div>
            <h2 class="text-4xl font-bold leading-tight">Gestión y seguimiento<br>de proyectos en un solo lugar.</h2>
            <p class="mt-4 max-w-md text-white/80">Centraliza actividades, acuerdos y fechas de compromiso, y consulta el avance de tus proyectos en tiempo real.</p>
        </div>
        <p class="text-sm text-white/60">Planifica · Avanza · Logra</p>
        <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-brand-accent/30 blur-3xl"></div>
    </div>

    {{-- Formulario --}}
    <div class="flex w-full items-center justify-center bg-surface px-6 lg:w-1/2">
        <div class="w-full max-w-md">
            <div class="card !p-8">
                <img src="{{ asset('images/logo-full.png') }}" alt="BeTrack" class="mx-auto h-28 w-auto object-contain">
                <h1 class="mt-6 text-center text-xl font-bold text-brand-dark">Bienvenido</h1>
                <p class="mt-1 text-center text-sm text-slate-500">Inicia sesión para continuar</p>

                <form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="correo@empresa.com" required autofocus>
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Contraseña</label>
                        <input type="password" name="password" class="input" placeholder="••••••••" required>
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand focus:ring-brand">
                        Mantener sesión iniciada
                    </label>

                    <button type="submit" class="btn-primary w-full">Iniciar sesión</button>
                </form>
            </div>
            <p class="mt-6 text-center text-xs text-slate-400">© {{ date('Y') }} BeTrack · Fulgaris Technologies</p>
        </div>
    </div>
</body>
</html>