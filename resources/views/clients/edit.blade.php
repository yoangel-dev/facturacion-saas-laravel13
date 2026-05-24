@extends('layouts.panel')

@section('title', 'Editar cliente')

@section('content')
    <h1 class="mb-4">Editar cliente</h1>

    <form action="{{ route('clients.update', $client->id) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $client->nombre }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $client->email }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">NIF/CIF</label>
            <input type="text" name="nif_cif" class="form-control" value="{{ $client->nif_cif }}">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection
