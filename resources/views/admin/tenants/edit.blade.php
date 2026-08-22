@extends('layouts.admin')

@section('title', 'Editar Tenant ' . $tenant->nombre_comercial)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="border-b border-slate-800 pb-4">
        <h1 class="text-2xl font-black text-white">Editar Tenant: {{ $tenant->nombre_comercial ?? $tenant->razon_social }}</h1>
        <p class="text-xs text-slate-400 mt-1">Configuración fiscal y estado administrativo.</p>
    </div>

    <form action="{{ route('admin.tenants.update', $tenant->id) }}" method="POST" class="rounded-2xl border border-slate-800 bg-slate-950 p-6 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Nombre Comercial *</label>
                <input type="text" name="nombre_comercial" value="{{ old('nombre_comercial', $tenant->nombre_comercial) }}" required
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Razón Social *</label>
                <input type="text" name="razon_social" value="{{ old('razon_social', $tenant->razon_social) }}" required
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">CIF / NIF *</label>
                <input type="text" name="cif_nif" value="{{ old('cif_nif', $tenant->cif_nif) }}" required
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white font-mono uppercase focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Email de Contacto</label>
                <input type="email" name="email" value="{{ old('email', $tenant->email) }}"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">IRPF Defecto (%)</label>
                <input type="number" step="0.5" name="irpf_por_defecto" value="{{ old('irpf_por_defecto', $tenant->irpf_por_defecto) }}"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white font-mono focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Serie Defecto</label>
                <input type="text" name="serie_factura_default" value="{{ old('serie_factura_default', $tenant->serie_factura_default) }}"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white font-mono uppercase focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Estado *</label>
                <select name="estado" class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
                    <option value="activo" {{ $tenant->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $tenant->estado === 'inactivo' ? 'selected' : '' }}>Inactivo / Suspendido</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.tenants.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-900">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">Actualizar Tenant</button>
        </div>
    </form>

</div>
@endsection