@extends('layouts.panel')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- CABECERA -->
    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('clients.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Clientes
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs font-medium text-slate-400">Nuevo</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 mt-1">Registrar Nuevo Cliente</h1>
            <p class="text-xs text-slate-500">Datos identificativos y configuración fiscal para facturación.</p>
        </div>
    </div>

    <!-- FORMULARIO -->
    <form action="{{ route('clients.store') }}" method="POST" class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-xs space-y-6">
        @csrf

        <div class="space-y-4">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                1. Información Fiscal y Legal
            </h2>

            <div>
                <label for="nombre_razon_social" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">
                    Nombre o Razón Social *
                </label>
                <input type="text" id="nombre_razon_social" name="nombre_razon_social" value="{{ old('nombre_razon_social') }}" required placeholder="Ej: Acme Iberia SL"
                       class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="cif_nif" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">CIF / NIF</label>
                    <input type="text" id="cif_nif" name="cif_nif" value="{{ old('cif_nif') }}" placeholder="B12345678"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20 font-mono uppercase">
                </div>

                <div>
                    <label for="pais" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">País</label>
                    <input type="text" id="pais" name="pais" value="{{ old('pais', 'ES') }}"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20 uppercase font-mono">
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                2. Contacto y Dirección
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Email de Facturación</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="facturas@cliente.test"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="telefono" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="+34 600 000 000"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20 font-mono">
                </div>
            </div>

            <div>
                <label for="direccion" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Calle Mayor 1, Piso 2"
                       class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="codigo_postal" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Código Postal</label>
                    <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}" placeholder="28001"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20 font-mono">
                </div>

                <div>
                    <label for="ciudad" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad') }}" placeholder="Madrid"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                </div>

                <div>
                    <label for="provincia" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Provincia</label>
                    <input type="text" id="provincia" name="provincia" value="{{ old('provincia') }}" placeholder="Madrid"
                           class="w-full rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-2">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                3. Régimen Fiscal
            </h2>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-3">
                <input type="checkbox" id="aplica_recargo_equivalencia" name="aplica_recargo_equivalencia" value="1" {{ old('aplica_recargo_equivalencia') ? 'checked' : '' }}
                       class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20 mt-1">
                <div>
                    <label for="aplica_recargo_equivalencia" class="text-sm font-bold text-slate-800 cursor-pointer">
                        Régimen Especial de Recargo de Equivalencia
                    </label>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Marca esta casilla si este cliente es comerciante minorista persona física sujeto a recargo de equivalencia (5.2%, 1.4%, 0.5%).
                    </p>
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('clients.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold shadow-sm transition-all">
                Guardar Cliente
            </button>
        </div>

    </form>

</div>
@endsection