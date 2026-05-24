@extends('layouts.panel')

@section('title', 'Panel Superadmin')

@section('content')

<h1 class="mb-4">Panel Superadmin</h1>

<div class="row g-3">

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <h5>Total Tenants</h5>
            <p class="fs-3 fw-bold mb-0">{{ $totalTenants }}</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <h5>Activos</h5>
            <p class="fs-3 text-success fw-bold mb-0">{{ $activeTenants }}</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <h5>Suspendidos</h5>
            <p class="fs-3 text-danger fw-bold mb-0">{{ $suspendedTenants }}</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <h5>Usuarios Totales</h5>
            <p class="fs-3 fw-bold mb-0">{{ $totalUsers }}</p>
        </div>
    </div>

</div>

@endsection