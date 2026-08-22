@extends('layouts.panel')

@section('title', 'Listado de Facturas')

@section('content')
<div class="space-y-6">

    <!-- CABECERA Y ACCIONES -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Facturación Emitida</h1>
            <p class="text-xs text-slate-500 mt-0.5">Control de facturas emitidas, rectificativas y estados de cobro.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('invoices.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-sm font-semibold shadow-md shadow-emerald-600/20 transition-all hover:shadow-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nueva Factura
            </a>
        </div>
    </div>

    <!-- BARRA DE FILTROS MODERNOS -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-xs">
        <form method="GET" action="{{ route('invoices.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- CLIENTE -->
            <div>
                <label for="filter_cliente" class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Cliente</label>
                <select id="filter_cliente" name="cliente" class="w-full rounded-xl border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500/20">
                    <option value="">Todos los clientes</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('cliente') == $client->id ? 'selected' : '' }}>
                            {{ $client->nombre_razon_social }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- ESTADO -->
            <div>
                <label for="filter_estado" class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Estado</label>
                <select id="filter_estado" name="estado" class="w-full rounded-xl border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500/20">
                    <option value="">Todos los estados</option>
                    <option value="emitida" {{ request('estado') == 'emitida' ? 'selected' : '' }}>Emitida</option>
                    <option value="cobrada" {{ request('estado') == 'cobrada' ? 'selected' : '' }}>Cobrada</option>
                    <option value="borrador" {{ request('estado') == 'borrador' ? 'selected' : '' }}>Borrador</option>
                    <option value="anulada" {{ request('estado') == 'anulada' ? 'selected' : '' }}>Anulada</option>
                </select>
            </div>

            <!-- FECHA -->
            <div>
                <label for="filter_fecha" class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Fecha Emisión</label>
                <input type="date" id="filter_fecha" name="fecha" value="{{ request('fecha') }}" 
                       class="w-full rounded-xl border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500/20">
            </div>

            <!-- BOTONES FILTRO -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold shadow-xs transition-colors">
                    Filtrar
                </button>
                <a href="{{ route('invoices.index') }}" class="py-2 px-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 text-xs font-medium transition-colors">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- TABLA DE FACTURAS -->
    <div class="rounded-2xl border border-slate-200/80 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-200/80 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Nº Factura</th>
                        <th class="py-3.5 px-6">Cliente Receptor</th>
                        <th class="py-3.5 px-6">Fecha</th>
                        <th class="py-3.5 px-6 text-right">Base Imp.</th>
                        <th class="py-3.5 px-6 text-right">IVA</th>
                        <th class="py-3.5 px-6 text-right">IRPF</th>
                        <th class="py-3.5 px-6 text-right">Total</th>
                        <th class="py-3.5 px-6 text-center">Estado</th>
                        <th class="py-3.5 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $inv)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- NÚMERO FACTURA Y BADGES -->
                            <td class="py-4 px-6 font-semibold text-slate-900 whitespace-nowrap">
                                <a href="{{ route('invoices.show', $inv->id) }}" class="text-slate-900 hover:text-emerald-600 flex items-center gap-1.5">
                                    {{ $inv->numero_completo }}
                                    @if($inv->is_rectificativa)
                                        <span class="inline-flex items-center rounded-md bg-rose-50 px-1.5 py-0.5 text-[9px] font-bold text-rose-700 ring-1 ring-rose-600/20">
                                            R
                                        </span>
                                    @endif
                                </a>
                            </td>

                            <!-- CLIENTE RECEPTOR CON SNAPSHOT -->
                            <td class="py-4 px-6">
                                <div class="font-medium text-slate-800">
                                    {{ $inv->client_snapshot['nombre_razon_social'] ?? $inv->client?->nombre_razon_social ?? 'Cliente' }}
                                </div>
                                <div class="text-[11px] text-slate-400 font-mono">
                                    {{ $inv->client_snapshot['cif_nif'] ?? $inv->client?->cif_nif ?? 'Sin CIF' }}
                                </div>
                            </td>

                            <!-- FECHA -->
                            <td class="py-4 px-6 text-slate-600 whitespace-nowrap text-xs">
                                {{ \Carbon\Carbon::parse($inv->fecha_emision)->format('d/m/Y') }}
                            </td>

                            <!-- BASE IMPONIBLE -->
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-600 whitespace-nowrap">
                                {{ number_format($inv->base_imponible, 2) }} €
                            </td>

                            <!-- IVA -->
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-600 whitespace-nowrap">
                                {{ number_format($inv->importe_iva + $inv->importe_recargo_equivalencia, 2) }} €
                            </td>

                            <!-- IRPF -->
                            <td class="py-4 px-6 text-right font-mono text-xs text-rose-600 whitespace-nowrap">
                                {{ $inv->importe_irpf > 0 ? '-' . number_format($inv->importe_irpf, 2) . ' €' : '0,00 €' }}
                            </td>

                            <!-- TOTAL -->
                            <td class="py-4 px-6 text-right font-mono font-bold text-slate-900 whitespace-nowrap">
                                {{ number_format($inv->total, 2) }} €
                            </td>

                            <!-- ESTADO PILL -->
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($inv->estado === 'cobrada')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Cobrada
                                    </span>
                                @elseif($inv->estado === 'emitida')
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5"></span> Emitida
                                    </span>
                                @elseif($inv->estado === 'borrador')
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span> Borrador
                                    </span>
                                @elseif($inv->estado === 'anulada')
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Anulada
                                    </span>
                                @endif
                            </td>

                            <!-- ACCIONES AGRUPADAS -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <!-- VER (SIEMPRE DISPONIBLE) -->
                                    <a href="{{ route('invoices.show', $inv->id) }}" 
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors" 
                                       title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>

                                    @if($inv->estado === 'borrador')
                                        <!-- EDITAR (SOLO BORRADORES) -->
                                        <a href="{{ route('invoices.edit', $inv->id) }}" 
                                           class="p-1.5 rounded-lg text-amber-600 hover:text-amber-700 hover:bg-amber-50 transition-colors" 
                                           title="Editar borrador">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>

                                        <!-- ELIMINAR (SOLO BORRADORES) -->
                                        <form action="{{ route('invoices.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este borrador de factura?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition-colors" title="Eliminar borrador">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <!-- PDF (EMITIDAS O COBRADAS) -->
                                        <a href="{{ route('invoices.pdf', $inv->id) }}" 
                                           class="p-1.5 rounded-lg text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors" 
                                           title="Descargar PDF">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </a>

                                        <!-- CAMBIAR A COBRADA/PENDIENTE -->
                                        <a href="{{ route('invoices.toggle', $inv->id) }}" 
                                           class="p-1.5 rounded-lg text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 transition-colors" 
                                           title="Alternar Cobrada / Emitida">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto space-y-3">
                                    <svg class="w-10 h-10 mx-auto text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                    <p class="text-sm font-medium text-slate-600">No se encontraron facturas con los filtros seleccionados.</p>
                                    <a href="{{ route('invoices.create') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                        + Emitir primera factura
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINACIÓN -->
        @if($invoices->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

</div>
@endsection