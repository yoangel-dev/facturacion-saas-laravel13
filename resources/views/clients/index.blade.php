@extends('layouts.panel')

@section('title', 'Directorio de Clientes')

@section('content')
<div x-data="{ search: '' }" class="space-y-6">

    <!-- CABECERA -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Directorio de Clientes</h1>
            <p class="text-xs text-slate-500 mt-0.5">Gestión de datos fiscales, CIF/NIF y regímenes de IVA.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('clients.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-sm font-semibold shadow-md shadow-emerald-600/20 transition-all hover:shadow-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" /></svg>
                Nuevo Cliente
            </a>
        </div>
    </div>

    <!-- BUSCADOR RÁPIDO EN VIVO CON ALPINE.JS -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-xs">
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="text" x-model="search" placeholder="Buscar cliente por razón social, CIF/NIF, email o ciudad..." 
                   class="w-full pl-10 rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
        </div>
    </div>

    <!-- TABLA DE CLIENTES -->
    <div class="rounded-2xl border border-slate-200/80 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-200/80 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Cliente / Razón Social</th>
                        <th class="py-3.5 px-6">CIF / NIF</th>
                        <th class="py-3.5 px-6">Contacto</th>
                        <th class="py-3.5 px-6">Ubicación</th>
                        <th class="py-3.5 px-6 text-center">Régimen IVA</th>
                        <th class="py-3.5 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($clients as $client)
                        <tr class="hover:bg-slate-50/50 transition-colors"
                            x-show="!search || '{{ strtolower($client->nombre_razon_social . ' ' . $client->cif_nif . ' ' . $client->email . ' ' . $client->ciudad) }}'.includes(search.toLowerCase())">
                            
                            <!-- NOMBRE -->
                            <td class="py-4 px-6 font-semibold text-slate-900">
                                <a href="{{ route('clients.show', $client->id) }}" class="text-slate-900 hover:text-emerald-600 flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($client->nombre_razon_social, 0, 2)) }}
                                    </div>
                                    <span>{{ $client->nombre_razon_social }}</span>
                                </a>
                            </td>

                            <!-- CIF / NIF -->
                            <td class="py-4 px-6 font-mono text-xs text-slate-600 whitespace-nowrap">
                                <span class="bg-slate-100 px-2 py-1 rounded-md text-slate-700 font-bold">
                                    {{ $client->cif_nif ?: 'No asignado' }}
                                </span>
                            </td>

                            <!-- CONTACTO -->
                            <td class="py-4 px-6 text-xs text-slate-600">
                                @if($client->email)
                                    <div class="text-slate-800 font-medium">{{ $client->email }}</div>
                                @endif
                                @if($client->telefono)
                                    <div class="text-slate-400 font-mono">{{ $client->telefono }}</div>
                                @endif
                                @if(!$client->email && !$client->telefono)
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>

                            <!-- UBICACIÓN -->
                            <td class="py-4 px-6 text-xs text-slate-600 whitespace-nowrap">
                                {{ $client->ciudad ? $client->ciudad . ($client->provincia ? ' (' . $client->provincia . ')' : '') : 'España' }}
                            </td>

                            <!-- RÉGIMEN IVA -->
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($client->aplica_recargo_equivalencia)
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                                        Recargo Equivalencia
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                        Régimen General
                                    </span>
                                @endif
                            </td>

                            <!-- ACCIONES -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- EMITIR FACTURA A ESTE CLIENTE -->
                                    <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}" 
                                       class="p-1.5 rounded-lg text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 transition-colors" 
                                       title="Nueva Factura a este cliente">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </a>

                                    <!-- EDITAR -->
                                    <a href="{{ route('clients.edit', $client->id) }}" 
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors" 
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>

                                    <!-- ELIMINAR -->
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition-colors" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto space-y-3">
                                    <svg class="w-10 h-10 mx-auto text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                                    <p class="text-sm font-medium text-slate-600">No hay clientes registrados en este tenant.</p>
                                    <a href="{{ route('clients.create') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                        + Añadir primer cliente
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
