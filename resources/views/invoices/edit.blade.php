@extends('layouts.panel')

@section('title', 'Editar Borrador ' . $invoice->numero_completo)

@section('content')
<div x-data="invoiceApp()" x-init="init()" class="space-y-6">

    <!-- CABECERA DE PÁGINA -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Facturas
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs font-medium text-slate-400">Editar {{ $invoice->numero_completo }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 mt-1">Editar Factura Borrador</h1>
            <p class="text-xs text-slate-500">Factura provisional N.º {{ $invoice->numero_completo }}. Modifica conceptos, cliente o impuestos antes de emitirla definitivamente.</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold">
                Estado Actual: <strong>Borrador</strong>
            </span>
        </div>
    </div>

    <!-- FORMULARIO DE EDICIÓN -->
    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" @submit="validateForm($event)" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- COLUMNA IZQUIERDA: DATOS GENERALES Y CONCEPTOS -->
            <div class="lg:col-span-2 space-y-6">

                <!-- TARJETA: CLIENTE Y RÉGIMEN -->
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2">
                        1. Cliente y Régimen Operativo
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- SELECTOR DE CLIENTE -->
                        <div class="sm:col-span-2">
                            <label for="client_id" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">
                                Cliente / Destinatario *
                            </label>
                            <select id="client_id" name="client_id" x-model="selectedClientId" @change="onClientChange()" required
                                    class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">-- Seleccionar Cliente --</option>
                                <template x-for="c in clients" :key="c.id">
                                    <option :value="c.id" x-text="`${c.nombre_razon_social} (${c.cif_nif || 'Sin CIF'})`"></option>
                                </template>
                            </select>
                        </div>

                        <!-- REGIMEN FISCAL -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">
                                Régimen Fiscal / Tipo de Operación *
                            </label>
                            <select x-model="regimenFiscal" @change="onRegimenChange()" 
                                    class="w-full rounded-xl border-slate-300 text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="general">Régimen General Autónomos / PYMEs (IVA Nivel Nacional)</option>
                                <option value="creadores">Creadores de Contenido / Exportación (YouTube, TikTok, AdSense - IVA 0%)</option>
                                <option value="recargo">Régimen Especial Recargo de Equivalencia (Minoristas)</option>
                            </select>
                        </div>

                        <!-- ACCIÓN AL GUARDAR: SEGUIR EN BORRADOR O EMITIR DEFINITIVAMENTE -->
                        <div class="sm:col-span-2">
                            <label for="estado" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Estado al Guardar *</label>
                            <select id="estado" name="estado" class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20 font-semibold text-emerald-800 bg-emerald-50/50">
                                <option value="borrador" {{ $invoice->estado === 'borrador' ? 'selected' : '' }}>Guardar como Borrador (Continuar editando después)</option>
                                <option value="emitida">Emitir Definitivamente (Inmutable según Ley Antifraude)</option>
                            </select>
                        </div>

                        <!-- FECHA EMISIÓN -->
                        <div>
                            <label for="fecha_emision" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Fecha de Emisión *</label>
                            <input type="date" id="fecha_emision" name="fecha_emision" value="{{ old('fecha_emision', $invoice->fecha_emision) }}" required
                                   class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>

                        <!-- FECHA VENCIMIENTO -->
                        <div>
                            <label for="fecha_vencimiento" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Fecha de Vencimiento</label>
                            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $invoice->fecha_vencimiento) }}"
                                   class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>

                    </div>
                </div>

                <!-- TARJETA: CONCEPTOS Y LÍNEAS -->
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700">
                            2. Conceptos y Servicios
                        </h2>
                        <button type="button" @click="addItem()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Añadir Línea
                        </button>
                    </div>

                    <!-- TABLA DINÁMICA -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                <tr>
                                    <th class="py-2.5 px-3">Descripción / Concepto</th>
                                    <th class="py-2.5 px-2 w-20 text-right">Cant.</th>
                                    <th class="py-2.5 px-2 w-28 text-right">Precio (€)</th>
                                    <th class="py-2.5 px-2 w-24 text-right">IVA</th>
                                    <template x-if="regimenFiscal === 'recargo' || (selectedClient && selectedClient.aplica_recargo_equivalencia)">
                                        <th class="py-2.5 px-2 w-24 text-right">Recargo</th>
                                    </template>
                                    <th class="py-2.5 px-3 w-28 text-right">Subtotal</th>
                                    <th class="py-2.5 px-2 w-10 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="py-2.5 px-2">
                                            <input type="text" :name="`items[${index}][concepto]`" x-model="item.concepto" required
                                                   class="w-full rounded-lg border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500/20">
                                        </td>
                                        <td class="py-2.5 px-2">
                                            <input type="number" step="0.01" min="0.01" :name="`items[${index}][cantidad]`" x-model.number="item.cantidad" @input="recalculate()" required
                                                   class="w-full text-right rounded-lg border-slate-300 text-xs font-mono focus:border-emerald-500 focus:ring-emerald-500/20">
                                        </td>
                                        <td class="py-2.5 px-2">
                                            <input type="number" step="0.01" min="0" :name="`items[${index}][precio_unitario]`" x-model.number="item.precio_unitario" @input="recalculate()" required
                                                   class="w-full text-right rounded-lg border-slate-300 text-xs font-mono focus:border-emerald-500 focus:ring-emerald-500/20">
                                        </td>
                                        <td class="py-2.5 px-2">
                                            <select :name="`items[${index}][iva_porcentaje]`" x-model.number="item.iva_porcentaje" @change="onIvaChange(item)"
                                                    class="w-full text-right rounded-lg border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500/20 font-medium">
                                                <option value="21">21%</option>
                                                <option value="10">10%</option>
                                                <option value="4">4%</option>
                                                <option value="0">0%</option>
                                            </select>
                                        </td>
                                        <template x-if="regimenFiscal === 'recargo' || (selectedClient && selectedClient.aplica_recargo_equivalencia)">
                                            <td class="py-2.5 px-2">
                                                <input type="number" step="0.1" :name="`items[${index}][recargo_porcentaje]`" x-model.number="item.recargo_porcentaje" readonly
                                                       class="w-full text-right bg-slate-50 rounded-lg border-slate-200 text-xs font-mono text-slate-600">
                                            </td>
                                        </template>
                                        <td class="py-2.5 px-3 text-right font-mono font-bold text-slate-800 text-xs whitespace-nowrap">
                                            <span x-text="formatCurrency(item.cantidad * item.precio_unitario)"></span>
                                        </td>
                                        <td class="py-2.5 px-1 text-center">
                                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="p-1 text-slate-400 hover:text-rose-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- NOTAS -->
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs space-y-2">
                    <label for="notas" class="block text-xs font-bold text-slate-700 uppercase">Observaciones y Condiciones</label>
                    <textarea id="notas" name="notas" rows="3" x-model="notas"
                              class="w-full rounded-xl border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500/20"></textarea>
                </div>

            </div>

            <!-- COLUMNA DERECHA: DESGLOSE FISCAL EN TIEMPO REAL -->
            <div class="space-y-6">

                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs sticky top-24 space-y-6">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-3 flex items-center justify-between">
                        <span>Desglose Fiscal</span>
                        <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full font-semibold">Modo Edición</span>
                    </h2>

                    <!-- RETENCIÓN IRPF -->
                    <div>
                        <label for="irpf_porcentaje" class="block text-xs font-semibold text-slate-700 mb-1.5 flex items-center justify-between">
                            <span>Retención IRPF (%)</span>
                            <span class="text-[11px] text-slate-400 font-mono" x-text="`-${formatCurrency(totalIrpf)}`"></span>
                        </label>
                        <select id="irpf_porcentaje" name="irpf_porcentaje" x-model.number="irpfPercentage" @change="recalculate()"
                                class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20 font-medium">
                            <option value="0">0% (Sin retención)</option>
                            <option value="7">7% (Nuevos autónomos)</option>
                            <option value="15">15% (Tipo general)</option>
                            <option value="19">19% (Inmuebles)</option>
                        </select>
                    </div>

                    <!-- TABLA TOTALES -->
                    <div class="space-y-3 pt-2 text-sm border-t border-slate-100">
                        <div class="flex justify-between text-slate-600">
                            <span>Base Imponible:</span>
                            <span class="font-mono font-semibold text-slate-900" x-text="formatCurrency(baseImponible)"></span>
                        </div>

                        <div class="flex justify-between text-slate-600">
                            <span>Cuota de IVA:</span>
                            <span class="font-mono font-semibold text-slate-900" x-text="`+${formatCurrency(totalIva)}`"></span>
                        </div>

                        <template x-if="regimenFiscal === 'recargo' || (selectedClient && selectedClient.aplica_recargo_equivalencia)">
                            <div class="flex justify-between text-indigo-700 font-medium">
                                <span>Recargo Equivalencia:</span>
                                <span class="font-mono font-semibold" x-text="`+${formatCurrency(totalRecargo)}`"></span>
                            </div>
                        </template>

                        <div class="flex justify-between text-rose-600 font-medium" x-show="irpfPercentage > 0">
                            <span>Retención IRPF (<span x-text="`${irpfPercentage}%`"></span>):</span>
                            <span class="font-mono font-semibold" x-text="`-${formatCurrency(totalIrpf)}`"></span>
                        </div>

                        <div class="pt-4 border-t-2 border-slate-900/10 flex items-baseline justify-between">
                            <span class="text-base font-extrabold text-slate-900">Total Factura:</span>
                            <span class="text-2xl font-black font-mono tracking-tight text-emerald-600" x-text="formatCurrency(granTotal)"></span>
                        </div>
                    </div>

                    <!-- BOTÓN GUARDAR -->
                    <div class="pt-4 space-y-2">
                        <button type="submit" 
                                class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-sm shadow-md shadow-emerald-600/20 hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                            Actualizar Factura Borrador
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

<script>
function invoiceApp() {
    return {
        clients: @json($clients ?? []),
        selectedClientId: {{ $invoice->client_id }},
        selectedClient: null,
        regimenFiscal: 'general',
        irpfPercentage: {{ ($invoice->base_imponible > 0) ? round(($invoice->importe_irpf / $invoice->base_imponible) * 100) : 15 }},
        notas: @json($invoice->notas ?? ''),
        items: {!! json_encode($invoice->items->map(function($item) {
            return [
                'concepto' => $item->concepto,
                'cantidad' => (float)$item->cantidad,
                'precio_unitario' => (float)$item->precio_unitario,
                'iva_porcentaje' => (float)$item->iva_porcentaje,
                'recargo_porcentaje' => (float)$item->recargo_porcentaje,
            ];
        })->values()) !!},
        baseImponible: 0,
        totalIva: 0,
        totalRecargo: 0,
        totalIrpf: 0,
        granTotal: 0,

        init() {
            if (this.selectedClientId) {
                this.onClientChange();
            }
            if (this.items.length === 0) {
                this.items.push({ concepto: '', cantidad: 1, precio_unitario: 0, iva_porcentaje: 21, recargo_porcentaje: 0 });
            }
            this.recalculate();
        },

        onClientChange() {
            this.selectedClient = this.clients.find(c => c.id == this.selectedClientId) || null;
            if (this.selectedClient && this.selectedClient.aplica_recargo_equivalencia) {
                this.regimenFiscal = 'recargo';
            }
            this.recalculate();
        },

        onRegimenChange() {
            const legalClause = "Operación con inversión del sujeto pasivo conforme a la Directiva 2006/112/CE / Ley del IVA.";
            if (this.regimenFiscal === 'creadores') {
                this.items.forEach(item => { item.iva_porcentaje = 0; item.recargo_porcentaje = 0; });
                this.irpfPercentage = 0;
                if (!this.notas.includes(legalClause)) {
                    this.notas = this.notas ? this.notas + "\n" + legalClause : legalClause;
                }
            } else if (this.regimenFiscal === 'recargo') {
                this.items.forEach(item => this.onIvaChange(item));
            }
            this.recalculate();
        },

        onIvaChange(item) {
            if (this.regimenFiscal === 'recargo' || (this.selectedClient && this.selectedClient.aplica_recargo_equivalencia)) {
                if (item.iva_porcentaje === 21) item.recargo_porcentaje = 5.2;
                else if (item.iva_porcentaje === 10) item.recargo_porcentaje = 1.4;
                else if (item.iva_porcentaje === 4) item.recargo_porcentaje = 0.5;
                else item.recargo_porcentaje = 0;
            } else {
                item.recargo_porcentaje = 0;
            }
            this.recalculate();
        },

        addItem() {
            let initialIva = this.regimenFiscal === 'creadores' ? 0 : 21;
            let initialRecargo = (this.regimenFiscal === 'recargo' || (this.selectedClient && this.selectedClient.aplica_recargo_equivalencia)) ? 5.2 : 0;
            this.items.push({ concepto: '', cantidad: 1, precio_unitario: 0, iva_porcentaje: initialIva, recargo_porcentaje: initialRecargo });
            this.recalculate();
        },

        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
                this.recalculate();
            }
        },

        recalculate() {
            let base = 0, iva = 0, recargo = 0;
            this.items.forEach(item => {
                const sub = (parseFloat(item.cantidad) || 0) * (parseFloat(item.precio_unitario) || 0);
                base += sub;
                iva += sub * ((parseFloat(item.iva_porcentaje) || 0) / 100);
                recargo += sub * ((parseFloat(item.recargo_porcentaje) || 0) / 100);
            });

            this.baseImponible = Math.round(base * 100) / 100;
            this.totalIva = Math.round(iva * 100) / 100;
            this.totalRecargo = Math.round(recargo * 100) / 100;
            this.totalIrpf = Math.round((this.baseImponible * (parseFloat(this.irpfPercentage) || 0) / 100) * 100) / 100;
            this.granTotal = Math.round((this.baseImponible + this.totalIva + this.totalRecargo - this.totalIrpf) * 100) / 100;
        },

        formatCurrency(val) {
            return (parseFloat(val) || 0).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
        },

        validateForm(e) {
            if (!this.selectedClientId) {
                e.preventDefault();
                alert('Debes seleccionar un cliente.');
                return false;
            }
        }
    };
}
</script>
@endsection
