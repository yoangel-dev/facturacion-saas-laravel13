@extends('layouts.panel')

@section('title', 'Facturas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Facturas</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">Nueva factura</a>
        
    </div>

    <form method="GET" class="row g-2 mb-3">

    <div class="col-md-3">
        <input type="date" name="fecha" class="form-control"
               value="{{ request('fecha') }}" placeholder="Fecha">
    </div>

    <div class="col-md-3">
        <select name="cliente" class="form-control">
            <option value="">Todos los clientes</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}"
                    @selected(request('cliente') == $client->id)>
                    {{ $client->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="estado" class="form-control">
            <option value="">Todos los estados</option>
            <option value="pendiente" @selected(request('estado')=='pendiente')>Pendiente</option>
            <option value="pagada" @selected(request('estado')=='pagada')>Pagada</option>
            <option value="vencida" @selected(request('estado')=='vencida')>Vencida</option>
            <option value="borrador" @selected(request('estado')=='borrador')>Borrador</option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-dark w-100">Filtrar</button>
    </div>

</form>

    

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Total</th>
                <th style="width: 220px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>

                    <td>{{ $invoice->client?->nombre ?? 'Cliente Eliminado' }}</td>

                    {{-- Estado real de la factura --}}
                    <td>
                        <span class="badge 
                            @if($invoice->estado === 'emitida') bg-primary
                            @elseif($invoice->estado === 'cobrada') bg-success
                            @endif
                        ">
                            {{ ucfirst($invoice->estado) }}
                        </span>
                    </td>

                    {{-- Fecha de emisión formateada --}}
                    <td>{{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('d/m/Y') }}</td>

                    {{-- Total formateado --}}
                    <td>{{ number_format($invoice->total, 2) }} €</td>

                    <td class="text-center">

                        <a href="{{ route('invoices.show', $invoice->id) }}" 
                        class="btn btn-sm btn-info"
                        title="Ver factura">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('invoices.edit', $invoice->id) }}" 
                        class="btn btn-sm btn-warning"
                        title="Editar factura">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="{{ route('invoices.pdf', $invoice->id) }}" 
                        class="btn btn-sm btn-secondary"
                        title="Descargar PDF">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </a>

                        {{-- <a href="{{ route('invoices.email', $invoice->id) }}"
                        class="btn btn-sm btn-outline-primary"
                        title="Enviar por email">
                            <i class="bi bi-envelope"></i>
                        </a> --}}

                        <a href="{{ route('invoices.toggle', $invoice->id) }}"
                        class="btn btn-sm btn-outline-success"
                        title="Cambiar estado">
                            <i class="bi bi-check-circle"></i>
                        </a>

                        <form action="{{ route('invoices.destroy', $invoice->id) }}" 
                            method="POST" 
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" 
                                    class="btn btn-sm btn-outline-danger"
                                    title="Eliminar factura"
                                    onclick="return confirm('¿Seguro que quieres eliminar esta factura?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection