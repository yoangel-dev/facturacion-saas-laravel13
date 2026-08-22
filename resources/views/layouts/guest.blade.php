<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Iniciar Sesión') - Facturación SaaS FinTech</title>

    <!-- Assets compilados localmente con Vite (Cero CDNs) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-slate-100 bg-slate-950 relative overflow-x-hidden flex flex-col justify-between min-h-screen">

    <!-- DECORACIÓN DE FONDO CON RESPLANDOR DUAL -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- CABECERA BRANDING -->
    <header class="relative z-10 pt-8 pb-4 text-center">
        <a href="/" class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-indigo-600 flex items-center justify-center text-white shadow-xl shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="text-left">
                <span class="text-xl font-extrabold tracking-tight text-white block leading-none">Facturación<span class="text-emerald-400">SaaS</span></span>
                <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-semibold tracking-wide uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> FinTech Edition · AEAT Ready
                </span>
            </div>
        </a>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="relative z-10 flex-1 flex items-center justify-center p-4">
        @yield('content')
    </main>

    <!-- FOOTER INTEGRADO -->
    <footer class="relative z-10 border-t border-slate-800/80 py-6 bg-slate-950/80 backdrop-blur-xs text-center text-xs text-slate-400 space-y-2">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
            <span>© 2024–2026 <strong>Facturación SaaS</strong> · Desarrollado con dedicación por <strong>Yoangel Alayon Peguero</strong></span>
            <a href="https://github.com/yoangel-dev" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-900 text-slate-200 font-semibold border border-slate-800 hover:border-emerald-500 hover:text-emerald-400 transition-all text-xs">
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
