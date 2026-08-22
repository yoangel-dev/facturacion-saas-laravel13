<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación SaaS - Software FinTech para Autónomos en España</title>

    <!-- Assets compilados localmente con Vite (Cero CDNs) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased text-slate-100 bg-slate-950 flex flex-col selection:bg-emerald-500 selection:text-white">

    <!-- NAVBAR HERO -->
    <header class="sticky top-0 z-50 bg-slate-950/80 backdrop-blur-md border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-bold tracking-tight text-white block leading-none">Facturación<span class="text-emerald-400">SaaS</span></span>
                    <span class="text-[10px] font-medium text-slate-400 uppercase tracking-widest block mt-0.5">FinTech España</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('panel.dashboard') }}" 
                           class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs shadow-md shadow-emerald-600/20 transition-all">
                            Ir al Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white transition-colors">
                            Iniciar Sesión
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-semibold text-xs shadow-md shadow-emerald-500/20 transition-all hover:scale-105">
                                Empezar Gratis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- HERO SECTION FINTECH -->
    <main class="flex-1 flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-20 text-center relative overflow-hidden">
        
        <!-- GLOW DECORATIVO -->
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-gradient-to-tr from-emerald-600/20 to-indigo-600/20 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-4xl mx-auto space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs text-slate-300">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Motor Fiscal Español & Multi-Tenancy Aislado</span>
            </div>

            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-tight">
                La plataforma de facturación más rápida para <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">autónomos en España</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Emite facturas con cálculo en vivo de <strong>IRPF (15%/7%)</strong>, <strong>IVA</strong> y <strong>Recargo de Equivalencia</strong>. Cumplimiento estricto con la Ley Antifraude y facturación rectificativa.
            </p>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ route('panel.dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-bold text-sm shadow-xl shadow-emerald-500/25 transition-all">
                        Acceder a mi Panel de Facturación
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-bold text-sm shadow-xl shadow-emerald-500/25 transition-all">
                        Crear Cuenta y Empezar
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-200 font-semibold text-sm transition-colors">
                        Acceso Clientes
                    </a>
                @endauth
            </div>
        </div>

        <!-- GRID DE CARACTERÍSTICAS TÉCNICAS -->
        <div class="max-w-6xl mx-auto mt-20 grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
            
            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 hover:border-slate-700 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-white">Inmutabilidad Fiscal</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Las facturas emitidas quedan protegidas contra modificaciones o borrados arbitrarios. Correcciones legales mediante Facturas Rectificativas.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 hover:border-slate-700 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-white">Aislamiento Multi-Tenant</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Aislamiento estricto de clientes, facturas y series por cada empresa o autónomo con Global Scopes automáticos en Laravel.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 hover:border-slate-700 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-white">Latencia Ultra-Baja</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Consultas agregadas directas de SQL, carga ansiosa (Eager Loading) sin problemas N+1 y assets empaquetados con Vite.
                </p>
            </div>

        </div>
    </main>

    <!-- FOOTER FINTECH -->
    <footer class="border-t border-slate-800/80 py-8 text-center text-xs text-slate-500 space-y-3 bg-slate-950">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
            <span>© 2024–2026 <strong>Facturación SaaS</strong> · Desarrollado con dedicación por <strong>Yoangel Alayon Peguero</strong></span>
            <a href="https://github.com/yoangel-dev" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-900 text-slate-200 font-semibold border border-slate-800 hover:border-emerald-500 hover:text-emerald-400 transition-all text-xs">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                </svg>
                @yoangel-dev
            </a>
        </div>
        <div class="text-[11px] text-slate-400">
            Cumplimiento normativo Ley Antifraude, RD 1619/2012 y Facturación Inmutable
        </div>
    </footer>

</body>
</html>
