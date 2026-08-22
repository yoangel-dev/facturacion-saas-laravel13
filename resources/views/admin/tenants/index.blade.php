@extends('layouts.admin')

@section('title', 'Gestión Global de Tenants')

@section('content')
<div class="space-y-6">

    <!-- CABECERA -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-white">Directorio de Tenants (Empresas y Autónomos)</h1>
            <p class="text-xs text-slate-400 mt-1">Administra el aislamiento, estado y series predeterminadas de cada cuenta SaaS.</p>
        </div>

        <div>
            <a href="{{ route('admin.tenants.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nuevo Tenant
            </a>
        </div>
    </div>

    <!-- TABLA DE TENANTS -->
    <div class="rounded-2xl border border-slate-800 bg-slate-950 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900 border-b border-slate-800 text-xs uppercase font-semibold text-slate-400">
                    <tr>
                        <th class="py-3.5 px-6">ID / Razón Social</th>
                        <th class="py-3.5 px-6">CIF / NIF</th>
                        <th class="py-3.5 px-6">Contacto</th>
                        <th class="py-3.5 px-6 text-center">Serie Def.</th>
                        <th class="py-3.5 px-6 text-center">IRPF Def.</th>
                        <th class="py-3.5 px-6 text-center">Usuarios</th>
                        <th class="py-3.5 px-6 text-center">Estado</th>
                        <th class="py-3.5 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($tenants as $t)
                        <tr class="hover:bg-slate-900/50">
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $t->nombre_comercial ?? $t->razon_social }}</div>
                                <div class="text-xs text-slate-500">{{ $t->razon_social }}</div>
                            </td>

                            <td class="py-4 px-6 font-mono text-xs text-slate-400">
                                {{ $t->cif_nif }}
                            </td>

                            <td class="py-4 px-6 text-xs text-slate-400">
                                <div>{{ $t->email ?: 'Sin email' }}</div>
                                <div>{{ $t->telefono }}</div>
                            </td>

                            <td class="py-4 px-6 text-center font-mono text-xs text-emerald-400">
                                {{ $t->serie_factura_default }}
                            </td>

                            <td class="py-4 px-6 text-center font-mono text-xs text-amber-400">
                                {{ number_format($t->irpf_por_defecto, 1) }}%
                            </td>

                            <td class="py-4 px-6 text-center font-mono text-xs">
                                {{ $t->users_count }}
                            </td>

                            <td class="py-4 px-6 text-center whitespace-nowrap">
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

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2 text-xs">
                                    @if($t->estado === 'activo')
                                        <a href="{{ route('admin.tenants.suspend', $t->id) }}" class="text-rose-400 hover:underline">Suspender</a>
                                    @else
                                        <a href="{{ route('admin.tenants.activate', $t->id) }}" class="text-emerald-400 hover:underline">Activar</a>
                                    @endif

                                    <a href="{{ route('admin.tenants.edit', $t->id) }}" class="text-amber-400 hover:underline font-bold">Editar</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-500 text-xs">No hay tenants creados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tenants->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
