@extends('layouts.admin')

@section('title', 'Gestión Global de Usuarios')

@section('content')
<div class="space-y-6">

    <!-- CABECERA -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-white">Gestión de Usuarios Plataforma</h1>
            <p class="text-xs text-slate-400 mt-1">Administra accesos, asignación de Tenants y roles globales.</p>
        </div>

        <div>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" /></svg>
                Nuevo Usuario
            </a>
        </div>
    </div>

    <!-- TABLA DE USUARIOS -->
    <div class="rounded-2xl border border-slate-800 bg-slate-950 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900 border-b border-slate-800 text-xs uppercase font-semibold text-slate-400">
                    <tr>
                        <th class="py-3.5 px-6">Usuario</th>
                        <th class="py-3.5 px-6">Email</th>
                        <th class="py-3.5 px-6">Tenant Asignado</th>
                        <th class="py-3.5 px-6 text-center">Rol</th>
                        <th class="py-3.5 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-900/50">
                            <td class="py-4 px-6 font-bold text-white">
                                {{ $u->name }}
                            </td>
                            <td class="py-4 px-6 font-mono text-xs text-slate-400">
                                {{ $u->email }}
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-300">
                                {{ $u->tenant?->nombre_comercial ?? $u->tenant?->razon_social ?? 'Sin Tenant (Global)' }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($u->role === 'superadmin')
                                    <span class="inline-flex items-center rounded-full bg-amber-500/10 px-2.5 py-0.5 text-xs font-semibold text-amber-400 border border-amber-500/20">
                                        Superadmin
                                    </span>
                                @elseif($u->role === 'admin')
                                    <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-2.5 py-0.5 text-xs font-semibold text-indigo-400 border border-indigo-500/20">
                                        Admin Tenant
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-800 px-2.5 py-0.5 text-xs font-medium text-slate-400">
                                        Usuario
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2 text-xs">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="text-amber-400 hover:underline font-bold">Editar</a>
                                    
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:underline">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500 text-xs">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection