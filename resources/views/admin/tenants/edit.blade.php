@extends('layouts.panel')

@section('title', 'Editar Tenant')

@section('content')

<h1 class="mb-4">Editar Tenant</h1>

<form action="{{ route('admin.tenants.update', $tenant) }}" method="POST" class="card p-4 shadow-sm">
    @csrf @method('PUT')

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Nombre del negocio</label>
            <input type="text" name="nombre" class="form-control" value="{{ $tenant->nombre }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email del propietario</label>
            <input type="email" name="email" class="form-control" value="{{ $tenant->email }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="activo" {{ $tenant->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="suspendido" {{ $tenant->estado === 'suspendido' ? 'selected' : '' }}>Suspendido</option>
            </select>
        </div>

    </div>

    <div class="mt-4 d-flex justify-content-between">
        <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">Volver</a>
        <button class="btn btn-warning">Actualizar Tenant</button>
    </div>

</form>

@endsection