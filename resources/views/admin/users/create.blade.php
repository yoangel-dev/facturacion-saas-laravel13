@extends('layouts.admin')

@section('title', 'Crear Usuario Administrador')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <div class="border-b border-slate-800 pb-4">
        <h1 class="text-2xl font-black text-white">Crear Usuario Administrador</h1>
        <p class="text-xs text-slate-400 mt-1">Registra accesos para administradores de Tenant o Superadmins globales.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="rounded-2xl border border-slate-800 bg-slate-950 p-6 shadow-sm space-y-5">
        @csrf

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Nombre Completo *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej: Carlos Ruiz"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Correo Electrónico *</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@empresa.test"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Contraseña *</label>
                <input type="password" name="password" required placeholder="••••••••"
                       class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Rol de Acceso *</label>
                <select name="role" class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
                    <option value="admin" selected>Admin (Administrador de Tenant)</option>
                    <option value="superadmin">Superadmin (Acceso Global Plataforma)</option>
                    <option value="user">User (Usuario Estándar)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Tenant Asignado</label>
                <select name="tenant_id" class="w-full rounded-xl bg-slate-900 border-slate-800 text-sm text-white focus:border-amber-500 focus:ring-amber-500/20">
                    <option value="">-- Sin Tenant (Requerido solo para Superadmin) --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                            {{ $tenant->nombre_comercial ?? $tenant->razon_social }} ({{ $tenant->cif_nif }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-900">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">Crear Usuario</button>
        </div>
    </form>

</div>
@endsection