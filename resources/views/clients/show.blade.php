@extends('layouts.panel')

@section('title', 'Detalles del cliente')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalles del Cliente</h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Información del cliente
        </div>

        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $client->nombre }}</p>
            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Teléfono:</strong> {{ $client->telefono ?? 'No especificado' }}</p>
            <p><strong>Dirección:</strong> {{ $client->direccion ?? 'No especificada' }}</p>
            <p><strong>NIF / CIF:</strong> {{ $client->nif_cif ?? 'No especificado' }}</p>

            <hr>

            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                Volver al listado
            </a>
        </div>
    </div>
</div>
@endsection
