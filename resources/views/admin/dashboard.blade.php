@extends('layouts.admin')

@section('title', 'Dashboard Superadmin Global')

@section('content')
<div class="space-y-8">

    <!-- CABECERA -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-white">Consola Global de Administración</h1>
            <p class="text-xs text-slate-400 mt-1">Métricas globales y control centralizado de Tenants y Usuarios.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tenants.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Registrar Nuevo Tenant
            </a>
        </div>
    </div>

    <!-- TARJETAS DE MÉTRICAS GLOBALES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- TOTAL TENANTS -->
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tenants Registrados</span>
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6h1.5m-1.5 3h1.5m-1.5 3h1.5M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                </div>
            </div>
            <div class="mt-4 text-3xl font-extrabold text-white">{{ $totalTenants }}</div>
            <div class="mt-2 text-xs text-slate-400">
                <span class="text-emerald-400 font-bold">{{ $activeTenants }} activos</span> · {{ $suspendedTenants }} inactivos
            </div>
        </div>

        <!-- TOTAL FACTURADO EN PLATAFORMA -->
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Volumen Total Facturado</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </div>
            </div>
            <div class="mt-4 text-3xl font-extrabold text-emerald-400 font-mono">{{ number_format($totalFacturadoGlobal ?? 0, 2) }} €</div>
            <div class="mt-2 text-xs text-slate-400">Suma global de todos los tenants</div>
        </div>

        <!-- VOLUMEN DE FACTURAS -->
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Facturas Emitidas</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                </div>
            </div>
            <div class="mt-4 text-3xl font-extrabold text-white">{{ $totalInvoicesGlobal }}</div>
            <div class="mt-2 text-xs text-slate-400">Comprobantes correlativos en la BD</div>
        </div>

        <!-- USUARIOS REGISTRADOS -->
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Usuarios Totales</span>
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                </div>
            </div>
            <div class="mt-4 text-3xl font-extrabold text-white">{{ $totalUsers }}</div>
            <div class="mt-2 text-xs text-slate-400">Admins y usuarios de tenant</div>
        </div>

    </div>

    <!-- ÚLTIMOS TENANTS REGISTRADOS -->
    <div class="rounded-2xl border border-slate-800 bg-slate-950 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Últimos Tenants Registrados</h2>
            <a href="{{ route('admin.tenants.index') }}" class="text-xs font-semibold text-amber-400 hover:underline">Ver todos los Tenants</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900 border-b border-slate-800 text-xs uppercase font-semibold text-slate-400">
                    <tr>
                        <th class="py-3.5 px-6">Empresa / Autónomo</th>
                        <th class="py-3.5 px-6">CIF / NIF</th>
                        <th class="py-3.5 px-6 text-center">Usuarios</th>
                        <th class="py-3.5 px-6 text-center">Facturas</th>
                        <th class="py-3.5 px-6 text-center">Estado</th>
                        <th class="py-3.5 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($latestTenants as $t)
                        <tr class="hover:bg-slate-900/50">
                            <td class="py-4 px-6 font-bold text-white">
                                {{ $t->nombre_comercial ?? $t->razon_social }}
                            </td>
                            <td class="py-4 px-6 font-mono text-xs text-slate-400">{{ $t->cif_nif }}</td>
                            <td class="py-4 px-6 text-center font-mono text-xs">{{ $t->users_count }}</td>
                            <td class="py-4 px-6 text-center font-mono text-xs">{{ $t->invoices_count }}</td>
                            <td class="py-4 px-6 text-center">
                                @if($t->estado === 'activo')
                                    <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-xs font-semibold text-emerald-400 border border-emerald-500/20">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-rose-500/10 px-2.5 py-0.5 text-xs font-semibold text-rose-400 border border-rose-500/20">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.tenants.edit', $t->id) }}" class="text-xs font-bold text-amber-400 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 text-xs">No hay tenants registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection