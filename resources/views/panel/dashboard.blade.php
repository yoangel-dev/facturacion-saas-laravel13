@extends('layouts.panel')

@section('title', 'Dashboard Financiero')

@section('content')
    <!-- CABECERA DEL DASHBOARD -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Dashboard Financiero</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Resumen ejecutivo de facturación y cobros para 
                <strong class="text-slate-700 font-semibold">{{ $tenant?->nombre_comercial ?? $tenant?->razon_social ?? 'Panel Global' }}</strong>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('clients.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 text-sm font-semibold shadow-xs transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Nuevo Cliente
            </a>

            <a href="{{ route('invoices.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-sm font-semibold shadow-md shadow-emerald-600/20 transition-all hover:shadow-lg hover:shadow-emerald-600/30">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Emitir Factura
            </a>
        </div>
    </div>

    <!-- TARJETAS KPI FINTECH EN GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <!-- TOTAL FACTURADO -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Facturado</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-slate-900">{{ number_format($stats->total_facturado ?? 0, 2) }} €</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5 text-xs">
                <span class="inline-flex items-center gap-0.5 text-emerald-600 font-semibold bg-emerald-50 px-1.5 py-0.5 rounded-md">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
                    +12.4%
                </span>
                <span class="text-slate-400">vs año anterior</span>
            </div>
        </div>

        <!-- COBRADO / LIQUIDEZ -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Cobrado</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-indigo-900">{{ number_format($stats->total_cobrado ?? 0, 2) }} €</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500">
                <span class="font-medium text-indigo-600">{{ $stats->facturas_cobradas ?? 0 }} facturas</span> totalmente cobradas
            </div>
        </div>

        <!-- PENDIENTE DE COBRO (ALERTA ÁMBAR) -->
        <div class="rounded-2xl border border-amber-200/80 bg-gradient-to-b from-amber-50/40 to-white p-6 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-800 uppercase tracking-wider">Pendiente de Cobro</span>
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-amber-900">{{ number_format($stats->total_pendiente ?? 0, 2) }} €</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5 text-xs">
                <span class="font-semibold text-amber-700 bg-amber-100/80 px-2 py-0.5 rounded-full">
                    {{ $stats->facturas_pendientes ?? 0 }} facturas
                </span>
                <span class="text-amber-800/80">en plazo de vencimiento</span>
            </div>
        </div>

        <!-- CLIENTES ACTIVOS -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Clientes</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $totalClients ?? 0 }}</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500">
                <span class="font-medium text-purple-600">Base fiscal activa</span> y sincronizada
            </div>
        </div>

    </div>

    <!-- TABLA DE ÚLTIMAS FACTURAS EMITIDAS -->
    <div class="rounded-2xl border border-slate-200/80 bg-white shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Últimas Facturas Registradas</h2>
                <p class="text-xs text-slate-500 mt-0.5">Listado correlativo en tiempo real</p>
            </div>
            <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                Ver todas las facturas
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-200/80 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Nº Factura</th>
                        <th class="py-3.5 px-6">Cliente / Receptor</th>
                        <th class="py-3.5 px-6">Fecha Emisión</th>
                        <th class="py-3.5 px-6 text-right">Base Imp.</th>
                        <th class="py-3.5 px-6 text-right">Importe Total</th>
                        <th class="py-3.5 px-6 text-center">Estado</th>
                        <th class="py-3.5 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($ultimasFacturas ?? [] as $inv)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-900 whitespace-nowrap">
                                <a href="{{ route('invoices.show', $inv->id) }}" class="text-slate-900 hover:text-emerald-600 flex items-center gap-2">
                                    {{ $inv->numero_completo }}
                                    @if($inv->is_rectificativa)
                                        <span class="inline-flex items-center rounded-md bg-rose-50 px-2 py-0.5 text-[10px] font-bold text-rose-700 ring-1 ring-rose-600/20">
                                            Rectificativa
                                        </span>
                                    @endif
                                </a>
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-medium text-slate-800">
                                    {{ $inv->client_snapshot['nombre_razon_social'] ?? $inv->client?->nombre_razon_social ?? 'Cliente Eliminado' }}
                                </div>
                                <div class="text-xs text-slate-400 font-mono">
                                    {{ $inv->client_snapshot['cif_nif'] ?? $inv->client?->cif_nif ?? 'Sin CIF' }}
                                </div>
                            </td>

                            <td class="py-4 px-6 text-slate-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($inv->fecha_emision)->format('d/m/Y') }}
                            </td>

                            <td class="py-4 px-6 text-right font-mono text-slate-600 whitespace-nowrap">
                                {{ number_format($inv->base_imponible, 2) }} €
                            </td>

                            <td class="py-4 px-6 text-right font-mono font-bold text-slate-900 whitespace-nowrap">
                                {{ number_format($inv->total, 2) }} €
                            </td>

                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($inv->estado === 'cobrada')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Cobrada
                                    </span>
                                @elseif($inv->estado === 'emitida')
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5"></span> Emitida
                                    </span>
                                @elseif($inv->estado === 'borrador')
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span> Borrador
                                    </span>
                                @elseif($inv->estado === 'anulada')
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Anulada
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('invoices.show', $inv->id) }}" 
                                       class="p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors" 
                                       title="Ver factura">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('invoices.pdf', $inv->id) }}" 
                                       class="p-2 rounded-lg text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors" 
                                       title="Descargar PDF">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                No se encontraron facturas recientes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection