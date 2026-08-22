@extends('layouts.admin')

@section('title', 'Registrar Nuevo Tenant')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="border-b border-slate-800 pb-4">
        <h1 class="text-2xl font-black text-white">Registrar Nuevo Tenant / Empresa</h1>
        <p class="text-xs text-slate-400 mt-1">Crea un espacio aislado para un nuevo autónomo o pyme.</p>
    </div>

    <form action="{{ route('admin.tenants.store') }}" method="POST" class="rounded-2xl border border-slate-800 bg-slate-950 p-6 shadow-sm space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Nombre Comercial *</label>
                <input type="text" name="nombre_comercial" value="{{ old('nombre_comercial') }}" required placeholder="Ej: Studio Digital SL"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Razón Social *</label>
                <input type="text" name="razon_social" value="{{ old('razon_social') }}" required placeholder="Ej: Studio Digital SL"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">CIF / NIF *</label>
                <input type="text" name="cif_nif" value="{{ old('cif_nif') }}" required placeholder="B12345678"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white font-mono uppercase focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Email de Contacto</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contacto@tenant.test"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">IRPF Defecto (%)</label>
                <input type="number" step="0.5" name="irpf_por_defecto" value="{{ old('irpf_por_defecto', 15.00) }}"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white font-mono focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Serie Defecto</label>
                <input type="text" name="serie_factura_default" value="{{ old('serie_factura_default', 'F2026') }}"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white font-mono uppercase focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Estado Initial *</label>
                <select name="estado" class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
                    <option value="activo" selected>Activo</option>
                    <option value="inactivo">Inactivo / Suspendido</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.tenants.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-900">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">Guardar Tenant</button>
        </div>
    </form>

</div>
@endsection
