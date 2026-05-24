@extends('layouts.panel')

@section('title', 'Crear cliente')

@section('content')

<div class="container">

    <h1 class="mb-4">Crear Cliente</h1>

    <form action="{{ route('clients.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">NIF / CIF</label>
                <input type="text" name="nif_cif" class="form-control">
            </div>

            <div class="col-md-12">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>

        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-success">Guardar cliente</button>
        </div>

    </form>

</div>

@endsection