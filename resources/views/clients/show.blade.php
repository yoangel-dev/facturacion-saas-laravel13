@extends('layouts.panel')

@section('title', 'Detalle Cliente ' . $client->nombre_razon_social)

@section('content')
<div class="space-y-6">

    <!-- CABECERA -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('clients.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Clientes
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs font-medium text-slate-400">{{ $client->nombre_razon_social }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 mt-1">{{ $client->nombre_razon_social }}</h1>
            <p class="text-xs text-slate-500">Ficha fiscal y resumen de facturas vinculadas.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Emitir Factura
            </a>

            <a href="{{ route('clients.edit', $client->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 text-xs font-semibold shadow-xs transition-colors">
                Editar Ficha
            </a>
        </div>
    </div>

    <!-- TARJETAS DE DATOS FISCALES -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Identificación Legal</span>
            <div class="text-base font-bold text-slate-900">{{ $client->nombre_razon_social }}</div>
            <div class="text-xs text-slate-600">
                <span class="font-semibold">NIF / CIF:</span> <span class="font-mono">{{ $client->cif_nif ?: 'No especificado' }}</span>
            </div>
            <div class="pt-2">
                @if($client->aplica_recargo_equivalencia)
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                        Régimen Recargo Equivalencia
                    </span>
                @else
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                        Régimen General de IVA
                    </span>
                @endif
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Contacto</span>
            <div class="text-xs text-slate-600 space-y-1.5 pt-1">
                <div><span class="font-semibold">Email:</span> {{ $client->email ?: 'N/A' }}</div>
                <div><span class="font-semibold">Teléfono:</span> <span class="font-mono">{{ $client->telefono ?: 'N/A' }}</span></div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Dirección Fiscal</span>
            <div class="text-xs text-slate-600 space-y-1 pt-1">
                <div>{{ $client->direccion ?: 'Sin dirección' }}</div>
                <div>{{ $client->codigo_postal }} {{ $client->ciudad }} {{ $client->provincia ? '(' . $client->provincia . ')' : '' }}</div>
                <div>País: {{ $client->pais ?? 'ES' }}</div>
            </div>
        </div>

    </div>

    <!-- HISTORIAL DE FACTURAS DE ESTE CLIENTE -->
    <div class="rounded-2xl border border-slate-200/80 bg-white shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">Historial de Facturas Emitidas</h2>
                <p class="text-xs text-slate-400">Total facturas emitidas a este cliente: {{ $client->invoices->count() }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Nº Factura</th>
                        <th class="py-3.5 px-6">Fecha</th>
                        <th class="py-3.5 px-6 text-right">Base Imp.</th>
                        <th class="py-3.5 px-6 text-right">IVA</th>
                        <th class="py-3.5 px-6 text-right">Total</th>
                        <th class="py-3.5 px-6 text-center">Estado</th>
                        <th class="py-3.5 px-6 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($client->invoices as $inv)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 font-semibold text-slate-900">
                                <a href="{{ route('invoices.show', $inv->id) }}" class="hover:text-emerald-600">
                                    {{ $inv->numero_completo }}
                                </a>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                {{ \Carbon\Carbon::parse($inv->fecha_emision)->format('d/m/Y') }}
                            </td>
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-600">
                                {{ number_format($inv->base_imponible, 2) }} €
                            </td>
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-600">
                                {{ number_format($inv->importe_iva, 2) }} €
                            </td>
                            <td class="py-4 px-6 text-right font-mono font-bold text-slate-900">
                                {{ number_format($inv->total, 2) }} €
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($inv->estado === 'cobrada')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">
                                        Cobrada
                                    </span>
                                @elseif($inv->estado === 'emitida')
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-indigo-700">
                                        Emitida
                                    </span>
                                @elseif($inv->estado === 'borrador')
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                        Borrador
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('invoices.show', $inv->id) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                    Ver Factura
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">
                                No se han emitido facturas para este cliente todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
