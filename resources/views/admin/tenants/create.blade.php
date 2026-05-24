@extends('layouts.panel')

@section('title', 'Crear Tenant')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Crear Tenant</h1>

    <form action="{{ route('admin.tenants.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre del negocio</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email del propietario</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="activo">Activo</option>
                    <option value="suspendido">Suspendido</option>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">
                Volver
            </a>
            <button type="submit" class="btn btn-success">
                Crear Tenant
            </button>
        </div>
    </form>
</div>
@endsection
