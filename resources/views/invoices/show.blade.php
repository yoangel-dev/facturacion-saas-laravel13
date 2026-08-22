@extends('layouts.panel')

@section('title', 'Factura ' . $invoice->numero_completo)

@section('content')
<div class="space-y-6">

    <!-- CABECERA DE ACCIONES -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Facturas
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs font-medium text-slate-400">{{ $invoice->numero_completo }}</span>
            </div>
            <div class="flex items-center gap-3 mt-1">
                <h1 class="text-2xl font-black tracking-tight text-slate-900">{{ $invoice->numero_completo }}</h1>
                
                @if($invoice->is_rectificativa)
                    <span class="inline-flex items-center rounded-md bg-rose-50 px-2 py-1 text-xs font-bold text-rose-700 ring-1 ring-rose-600/20">
                        Factura Rectificativa
                    </span>
                @endif

                @if($invoice->estado === 'cobrada')
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Cobrada
                    </span>
                @elseif($invoice->estado === 'emitida')
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5"></span> Emitida
                    </span>
                @elseif($invoice->estado === 'borrador')
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span> Borrador
                    </span>
                @elseif($invoice->estado === 'anulada')
                    <span class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Anulada
                    </span>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- DESCARGAR PDF -->
            <a href="{{ route('invoices.pdf', $invoice->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 text-xs font-bold shadow-xs transition-colors">
                <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Descargar PDF
            </a>

            <!-- ENVIAR EMAIL -->
            <a href="{{ route('invoices.email', $invoice->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                Enviar por Email
            </a>
        </div>
    </div>

    <!-- ALERTA DE FACTURA RECTIFICATIVA -->
    @if($invoice->is_rectificativa)
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
            <div class="text-xs">
                <p class="font-bold">Factura Rectificativa vinculada</p>
                <p class="mt-0.5">Esta factura rectifica a la factura previa con ID <strong>#{{ $invoice->factura_rectificada_id }}</strong>. Motivo de rectificación: <em>"{{ $invoice->motivo_rectificacion ?: 'Abono / Modificación fiscal' }}"</em>.</p>
            </div>
        </div>
    @endif

    <!-- TARJETA PRINCIPAL: DATOS FISCALES DEL EMISOR Y RECEPTOR -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- EMISOR (TENANT) -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Emisor / Autónomo</span>
            <div class="text-base font-bold text-slate-900">{{ $invoice->tenant->razon_social ?? $invoice->tenant->nombre_comercial }}</div>
            <div class="text-xs text-slate-600 space-y-1">
                <div><span class="font-semibold">NIF / CIF:</span> <span class="font-mono">{{ $invoice->tenant->cif_nif }}</span></div>
                <div><span class="font-semibold">Dirección:</span> {{ $invoice->tenant->direccion }}, {{ $invoice->tenant->codigo_postal }} {{ $invoice->tenant->ciudad }} ({{ $invoice->tenant->provincia }})</div>
                <div><span class="font-semibold">Email:</span> {{ $invoice->tenant->email }}</div>
            </div>
        </div>

        <!-- RECEPTOR (CLIENT SNAPSHOT INMUTABLE) -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Receptor / Destinatario (Snapshot Legal)</span>
            <div class="text-base font-bold text-slate-900">{{ $invoice->client_snapshot['nombre_razon_social'] ?? $invoice->client?->nombre_razon_social ?? 'Cliente' }}</div>
            <div class="text-xs text-slate-600 space-y-1">
                <div><span class="font-semibold">NIF / CIF:</span> <span class="font-mono">{{ $invoice->client_snapshot['cif_nif'] ?? $invoice->client?->cif_nif ?? 'N/A' }}</span></div>
                <div><span class="font-semibold">Dirección:</span> {{ $invoice->client_snapshot['direccion'] ?? 'N/A' }}, {{ $invoice->client_snapshot['codigo_postal'] ?? '' }} {{ $invoice->client_snapshot['ciudad'] ?? '' }}</div>
                <div><span class="font-semibold">Email:</span> {{ $invoice->client_snapshot['email'] ?? 'N/A' }}</div>
            </div>
        </div>

    </div>

    <!-- TABLA DE LÍNEAS DE CONCEPTOS -->
    <div class="rounded-2xl border border-slate-200/80 bg-white shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">Líneas y Conceptos Facturados</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-6">Concepto</th>
                        <th class="py-3 px-6 text-right">Cantidad</th>
                        <th class="py-3 px-6 text-right">Precio Unitario</th>
                        <th class="py-3 px-6 text-right">IVA %</th>
                        @if($invoice->importe_recargo_equivalencia > 0)
                            <th class="py-3 px-6 text-right">R.E. %</th>
                        @endif
                        <th class="py-3 px-6 text-right">Base</th>
                        <th class="py-3 px-6 text-right">Importe Línea</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($invoice->items as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-4 px-6 font-medium text-slate-800">{{ $item->concepto }}</td>
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-600">{{ number_format($item->cantidad, 2) }}</td>
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-600">{{ number_format($item->precio_unitario, 2) }} €</td>
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-600">{{ number_format($item->iva_porcentaje, 0) }}%</td>
                            @if($invoice->importe_recargo_equivalencia > 0)
                                <td class="py-4 px-6 text-right font-mono text-xs text-indigo-600">{{ number_format($item->recargo_porcentaje, 1) }}%</td>
                            @endif
                            <td class="py-4 px-6 text-right font-mono text-xs text-slate-700">{{ number_format($item->importe_base, 2) }} €</td>
                            <td class="py-4 px-6 text-right font-mono font-bold text-slate-900">{{ number_format($item->importe_total, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- TOTALES Y DESGLOSE EN PIE DE TABLA -->
        <div class="p-6 bg-slate-50/50 border-t border-slate-200/80 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="text-xs text-slate-500 max-w-md">
                @if($invoice->notas)
                    <strong class="text-slate-700 block mb-1">Observaciones / Notas de pago:</strong>
                    {{ $invoice->notas }}
                @endif
            </div>

            <div class="w-full md:w-80 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Base Imponible:</span>
                    <span class="font-mono font-semibold text-slate-900">{{ number_format($invoice->base_imponible, 2) }} €</span>
                </div>

                <div class="flex justify-between text-slate-600">
                    <span>Total IVA:</span>
                    <span class="font-mono font-semibold text-slate-900">+{{ number_format($invoice->importe_iva, 2) }} €</span>
                </div>

                @if($invoice->importe_recargo_equivalencia > 0)
                    <div class="flex justify-between text-indigo-700">
                        <span>Recargo de Equivalencia:</span>
                        <span class="font-mono font-semibold">+{{ number_format($invoice->importe_recargo_equivalencia, 2) }} €</span>
                    </div>
                @endif

                @if($invoice->importe_irpf > 0)
                    <div class="flex justify-between text-rose-600 font-semibold">
                        <span>Retención IRPF:</span>
                        <span class="font-mono">-{{ number_format($invoice->importe_irpf, 2) }} €</span>
                    </div>
                @endif

                <div class="pt-3 border-t border-slate-300 flex justify-between items-baseline">
                    <span class="text-sm font-bold text-slate-900">Total Factura:</span>
                    <span class="text-xl font-extrabold font-mono text-emerald-600">{{ number_format($invoice->total, 2) }} €</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
