@extends('layouts.panel')

@section('title', 'Editar factura')

@section('content')
<h1>Editar Factura</h1>

<form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Cliente:</label>
    <select name="client_id">
        @foreach($clients as $client)
            <option value="{{ $client->id }}" @if($client->id == $invoice->client_id) selected @endif>
                {{ $client->nombre }}
            </option>
        @endforeach
    </select><br>

    <label>Fecha emisión:</label>
    <input type="date" name="fecha_emision" value="{{ $invoice->fecha_emision }}"><br>

    <label>Total:</label>
    <input type="number" step="0.01" name="total" value="{{ $invoice->total }}"><br>

    <label>Notas:</label>
    <textarea name="notas">{{ $invoice->notas }}</textarea><br>

    <button type="submit">Actualizar</button>
</form>
@endsection
