<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') - Facturación SaaS FinTech</title>

    <!-- Scripts y Estilos Compilados Localmente con Vite (Cero CDNs externas) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-slate-900 bg-slate-50/50 flex flex-col min-h-screen">

    <!-- BARRA SUPERIOR DE NAVEGACIÓN (SLATE 900) -->
    <header class="sticky top-0 z-40 bg-slate-900 border-b border-slate-800 shadow-sm" x-data="{ mobileOpen: false, userDropdown: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- LOGO & BRAND -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('panel.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-base font-bold tracking-tight text-white block leading-tight">Facturación<span class="text-emerald-400">SaaS</span></span>
                            <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider block">FinTech España</span>
                        </div>
                    </a>

                    <!-- MENÚ PRINCIPAL DESKTOP -->
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="{{ route('panel.dashboard') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('panel.dashboard') ? 'bg-slate-800 text-white shadow-inner' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('invoices.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('invoices.*') ? 'bg-slate-800 text-white shadow-inner' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                            Facturas
                        </a>

                        <a href="{{ route('clients.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('clients.*') ? 'bg-slate-800 text-white shadow-inner' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                            Clientes
                        </a>

                        @if(auth()->user()?->isSuperAdmin())
                            <div class="relative ml-2 pl-2 border-l border-slate-700" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" 
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30 hover:bg-amber-500/20 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>
                                    Superadmin
                                    <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100" 
                                     x-transition:enter-start="transform opacity-0 scale-95" 
                                     x-transition:enter-end="transform opacity-100 scale-100" 
                                     x-transition:leave="transition ease-in duration-75" 
                                     x-transition:leave-start="transform opacity-100 scale-100" 
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute left-0 mt-2 w-48 rounded-xl bg-slate-800 py-2 shadow-xl ring-1 ring-white/10 z-50">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-700">Dashboard Global</a>
                                    <a href="{{ route('admin.tenants.index') }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-700">Gestionar Tenants</a>
                                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-xs text-slate-200 hover:bg-slate-700">Gestionar Usuarios</a>
                                </div>
                            </div>
                        @endif
                    </nav>
                </div>

                <!-- INFO DE USUARIO Y TENANT ACTIVO -->
                <div class="hidden md:flex items-center gap-4">
                    @if(auth()->user()?->tenant)
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/80 border border-slate-700 text-xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-slate-300 font-medium">{{ auth()->user()->tenant?->nombre_comercial ?? auth()->user()->tenant?->razon_social ?? 'Panel Global' }}</span>
                            <span class="text-slate-500 font-mono text-[10px]">({{ auth()->user()->tenant?->cif_nif }})</span>
                        </div>
                    @endif

                    <!-- AVATAR Y PERFIL -->
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-xs shadow-inner">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="text-left hidden lg:block">
                            <div class="text-xs font-semibold text-white leading-none">{{ auth()->user()->name }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5 leading-none">{{ auth()->user()->email }}</div>
                        </div>

                        <!-- CERRAR SESIÓN -->
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" 
                                    class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors" 
                                    title="Cerrar sesión">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- BOTÓN MÓVIL TOGGLE -->
                <div class="flex md:hidden">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- MENÚ MÓVIL DESPLEGABLE -->
        <div x-show="mobileOpen" class="md:hidden border-t border-slate-800 bg-slate-900 px-4 pt-2 pb-4 space-y-1">
            <a href="{{ route('panel.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-200 hover:bg-slate-800">Dashboard</a>
            <a href="{{ route('invoices.index') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-200 hover:bg-slate-800">Facturas</a>
            <a href="{{ route('clients.index') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-200 hover:bg-slate-800">Clientes</a>
            @if(auth()->user()?->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-amber-400 hover:bg-slate-800">Panel Superadmin</a>
            @endif
            <div class="pt-3 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-rose-400 font-semibold">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </header>

    <!-- NOTIFICACIONES TOAST GLOBALES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs mb-4 animate-fade-in" x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 p-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs mb-4" x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-600 hover:text-rose-800 p-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        @yield('content')
    </main>

    <!-- PIE DE PÁGINA FINTECH -->
    <footer class="bg-white border-t border-slate-200/80 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex flex-col sm:flex-row items-center gap-2">
                <span>© 2024–2026 <strong>Facturación SaaS</strong> · Desarrollado con dedicación por <strong>Yoangel Alayon Peguero</strong></span>
                <a href="https://github.com/yoangel-dev" target="_blank" rel="noopener noreferrer" 
                   class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-semibold hover:bg-slate-900 hover:text-white transition-all shadow-2xs">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                    </svg>
                    @yoangel-dev
                </a>
            </div>

            <div class="text-slate-400 text-center md:text-right">
                Cumplimiento normativo Ley Antifraude, RD 1619/2012 y Facturación Inmutable
            </div>
        </div>
    </footer>

</body>
</html>