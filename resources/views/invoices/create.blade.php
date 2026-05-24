@extends('layouts.panel')

@section('title', 'Crear factura')

@section('content')

    <div class="container">

        <h1 class="mb-4">Crear Factura</h1>

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <!-- DATOS GENERALES -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Datos generales
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Cliente</label>
                        <select name="client_id" class="form-select" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha de emisión</label>
                        <input type="date" name="fecha_emision" class="form-control" required>
                    </div>

                </div>
            </div>

            <!-- LÍNEAS DE FACTURA -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>Líneas de factura</span>
                    <button type="button" class="btn btn-light btn-sm" onclick="addItem()">Añadir línea</button>
                </div>

                <div class="card-body" id="items">

                    <div class="row g-3 item mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="items[0][descripcion]" class="form-control" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Cantidad</label>
                            <input type="number" name="items[0][cantidad]" class="form-control" value="1" min="1" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Precio unitario</label>
                            <input type="number" step="0.01" name="items[0][precio_unitario]" class="form-control" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">IVA %</label>
                            <input type="number" step="0.01" name="items[0][iva_porcentaje]" class="form-control" value="0">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">IRPF %</label>
                            <input type="number" step="0.01" name="items[0][irpf_porcentaje]" class="form-control" value="0">
                        </div>
                    </div>

                </div>
            </div>

            <!-- NOTAS -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Notas
                </div>
                <div class="card-body">
                    <textarea name="notas" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <!-- BOTÓN GUARDAR -->
            <button type="submit" class="btn btn-success btn-lg w-100">
                Guardar factura
            </button>

        </form>
    </div>

    <script>
        let index = 1;

        function addItem() {
            const container = document.getElementById('items');

            const html = `
                <div class="row g-3 item mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Descripción</label>
                        <input type="text" name="items[${index}][descripcion]" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="items[${index}][cantidad]" class="form-control" value="1" min="1" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Precio unitario</label>
                        <input type="number" step="0.01" name="items[${index}][precio_unitario]" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">IVA %</label>
                        <input type="number" step="0.01" name="items[${index}][iva_porcentaje]" class="form-control" value="0">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">IRPF %</label>
                        <input type="number" step="0.01" name="items[${index}][irpf_porcentaje]" class="form-control" value="0">
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            index++;
        }
    </script>

@endsection
