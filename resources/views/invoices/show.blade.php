@extends('layouts.panel')

@section('title', 'Detalle factura')

@section('content')
    <h1 class="mb-3">Factura #{{ $invoice->id }}</h1>

    <p><strong>Cliente:</strong> {{ $invoice->client->nombre }}</p>
    <p><strong>Fecha:</strong> {{ $invoice->fecha_emision }}</p>
    <p><strong>Total:</strong> {{ $invoice->total }} €</p>

    <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-secondary mb-3">Descargar PDF</a>

    <h3>Líneas</h3>
    <table class="table table-sm table-bordered">
        <thead class="table-light">
            <tr>
                <th>Descripción</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>IVA %</th>
                <th>IRPF %</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->precio_unitario }} €</td>
                    <td>{{ $item->iva_porcentaje }}%</td>
                    <td>{{ $item->irpf_porcentaje }}%</td>
                    <td>{{ $item->importe_total }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Volver</a>
@endsection
