@extends('layouts.panel')

@section('title', 'Crear Usuario')

@section('content')

<h1 class="mb-4">Crear Usuario</h1>

<form action="{{ route('admin.users.store') }}" method="POST" class="card p-4 shadow-sm">
    @csrf

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Tenant</label>
            <select name="tenant_id" class="form-select">
                <option value="">— Sin tenant —</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}">{{ $tenant->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Rol</label>
            <select name="role" class="form-select">
                <option value="user">Usuario</option>
                <option value="admin">Admin</option>
            </select>
        </div>


        <div class="col-md-6">
            <label class="form-label">Superadmin</label>
            <select name="is_superadmin" class="form-select">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>

    </div>

    <div class="mt-4 d-flex justify-content-between">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver</a>
        <button class="btn btn-success">Crear Usuario</button>
    </div>

</form>

@endsection