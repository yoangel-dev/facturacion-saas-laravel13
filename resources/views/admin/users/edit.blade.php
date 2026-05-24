@extends('layouts.panel')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Editar Usuario</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nueva contraseña (opcional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tenant</label>
                <select name="tenant_id" class="form-select">
                    <option value="">— Sin tenant —</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ $user->tenant_id == $tenant->id ? 'selected' : '' }}>
                            {{ $tenant->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Superadmin</label>
                <select name="is_superadmin" class="form-select">
                    <option value="0" {{ !$user->is_superadmin ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $user->is_superadmin ? 'selected' : '' }}>Sí</option>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                Volver
            </a>
            <button type="submit" class="btn btn-warning">
                Actualizar Usuario
            </button>
        </div>
    </form>
</div>
@endsection
