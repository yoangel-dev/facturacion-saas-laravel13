<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Superadmin') - Facturación SaaS</title>

    <!-- Assets compilados localmente con Vite (Cero CDNs) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-slate-100 bg-slate-900 flex flex-col min-h-screen">

    <header class="bg-slate-950 border-b border-slate-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center font-bold text-sm">
                            SA
                        </div>
                        <span class="font-bold text-sm tracking-tight text-white">Superadmin <span class="text-amber-400">Control</span></span>
                    </a>

                    <nav class="flex items-center gap-1">
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white' }}">Dashboard</a>
                        <a href="{{ route('admin.tenants.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.tenants.*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white' }}">Tenants</a>
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white' }}">Usuarios</a>
                        <a href="{{ route('panel.dashboard') }}" class="ml-4 px-3 py-1.5 rounded-lg text-xs font-medium bg-emerald-600 text-white hover:bg-emerald-500">Ir al Panel de Tenant</a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <footer class="border-t border-slate-800 py-6 text-center text-xs text-slate-500 space-y-2 mt-auto bg-slate-950">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
            <span>© 2024–2026 <strong>Facturación SaaS</strong> · Desarrollado con dedicación por <strong>Yoangel Alayon Peguero</strong></span>
            <a href="https://github.com/yoangel-dev" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-800 text-slate-200 font-semibold hover:bg-amber-500 hover:text-slate-950 transition-all">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                    <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                </svg>
                @yoangel-dev
            </a>
        </div>
        <div class="text-[11px] text-slate-500">
            Cumplimiento normativo Ley Antifraude, RD 1619/2012 y Facturación Inmutable
        </div>
    </footer>

</body>
</html>