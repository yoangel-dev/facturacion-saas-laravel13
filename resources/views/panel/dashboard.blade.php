@extends('layouts.panel')

@section('title', 'Panel')

@section('content')
    <h1 class="mb-4">Panel de facturación</h1>

    <div class="alert alert-info">
        Bienvenido, {{ auth()->user()->name }}.
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text">Gestiona tus clientes.</p>
                    <a href="{{ route('clients.index') }}" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Facturas</h5>
                    <p class="card-text">Crea y administra tus facturas.</p>
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary">Ir</a>
                </div>
            </div>
        </div>
    </div>
@endsection