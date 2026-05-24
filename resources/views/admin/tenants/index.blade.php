@extends('layouts.panel')

@section('title', 'Tenants')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tenants</h1>
        <a href="{{ route('admin.tenants.create') }}" class="btn btn-primary">
            Nuevo Tenant
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->id }}</td>
                        <td>{{ $tenant->nombre }}</td>
                        <td>{{ $tenant->email }}</td>
                        <td>
                            <span class="badge @if($tenant->estado === 'activo') bg-success @else bg-danger @endif">
                                {{ ucfirst($tenant->estado) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn btn-sm btn-warning">
                                Editar
                            </a>

                            @if($tenant->estado === 'activo')
                                <a href="{{ route('admin.tenants.suspend', $tenant) }}" class="btn btn-sm btn-danger">
                                    Suspender
                                </a>
                            @else
                                <a href="{{ route('admin.tenants.activate', $tenant) }}" class="btn btn-sm btn-success">
                                    Activar
                                </a>
                            @endif

                            <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar tenant?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $tenants->links() }}
    </div>
</div>
@endsection
