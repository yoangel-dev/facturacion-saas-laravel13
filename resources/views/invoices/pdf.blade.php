<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $invoice->numero_completo }}</title>
    <style>
        /* CONFIGURACIÓN GLOBAL DOMPDF */
        @page {
            margin: 25px 30px 40px 30px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #2b2d42;
            margin: 0;
            padding: 0;
        }
        .table-layout {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 20px;
        }
        .table-layout td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        /* CABECERA */
        .brand-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a365d;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .company-details {
            font-size: 10px;
            color: #4a5568;
            margin-top: 4px;
            line-height: 1.35;
        }
        .meta-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a365d;
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-details {
            text-align: right;
            font-size: 10px;
            margin-top: 4px;
            line-height: 1.35;
        }
        .meta-details strong {
            color: #1a365d;
        }

        /* RECTIFICATIVA ALERT */
        .rectificativa-box {
            background-color: #fff5f5;
            border-left: 4px solid #e53e3e;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 10px;
            color: #742a2a;
        }

        /* PARTICIPANTES */
        .party-header {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #718096;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 2px;
            margin-bottom: 6px;
        }
        .party-body {
            font-size: 10px;
            color: #2d3748;
            line-height: 1.35;
        }
        .party-name {
            font-size: 12px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 2px;
        }

        /* TABLA DE CONCEPTOS */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th {
            background-color: #1a365d;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            text-align: left;
        }
        .items-table td {
            padding: 7px 8px;
            border-bottom: 1px solid #edf2f7;
            font-size: 10px;
            color: #2d3748;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }

        /* TOTALES */
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 4px 6px;
            font-size: 10px;
            color: #4a5568;
        }
        .totals-table .label {
            text-align: right;
            color: #718096;
        }
        .totals-table .value {
            text-align: right;
            font-weight: 500;
            width: 110px;
        }
        .totals-table .grand-total-row td {
            padding-top: 8px;
            border-top: 2px solid #1a365d;
        }
        .totals-table .grand-total-label {
            font-size: 13px;
            font-weight: bold;
            color: #1a365d;
            text-align: right;
        }
        .totals-table .grand-total-value {
            font-size: 13px;
            font-weight: bold;
            color: #1a365d;
            text-align: right;
        }

        /* NOTAS Y PIE */
        .notes-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #718096;
            margin-bottom: 3px;
        }
        .notes-body {
            font-size: 9px;
            color: #718096;
            line-height: 1.35;
        }
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            text-align: center;
            font-size: 8px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <!-- CABECERA PRINCIPAL: EMISOR Y METADATOS -->
    <table class="table-layout">
        <tr>
            <!-- EMISOR -->
            <td style="width: 55%;">
                <div class="brand-title">{{ $tenant->nombre_comercial ?? $tenant->razon_social }}</div>
                <div class="company-details">
                    <strong>Razón Social:</strong> {{ $tenant->razon_social }}<br>
                    <strong>NIF/CIF:</strong> {{ $tenant->cif_nif }}<br>
                    @if($tenant->direccion)
                        {{ $tenant->direccion }}<br>
                    @endif
                    @if($tenant->codigo_postal || $tenant->ciudad)
                        {{ $tenant->codigo_postal }} {{ $tenant->ciudad }} ({{ $tenant->provincia ?? 'España' }})<br>
                    @endif
                    @if($tenant->email)
                        Email: {{ $tenant->email }} | 
                    @endif
                    @if($tenant->telefono)
                        Tel: {{ $tenant->telefono }}
                    @endif
                </div>
            </td>
            <!-- METADATOS DE FACTURA -->
            <td style="width: 45%;">
                <div class="meta-title">
                    {{ $invoice->is_rectificativa ? 'Factura Rectificativa' : 'Factura' }}
                </div>
                <div class="meta-details">
                    <strong>Nº Factura:</strong> {{ $invoice->numero_completo }}<br>
                    <strong>Fecha Emisión:</strong> {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('d/m/Y') }}<br>
                    @if($invoice->fecha_vencimiento)
                        <strong>Fecha Vencimiento:</strong> {{ \Carbon\Carbon::parse($invoice->fecha_vencimiento)->format('d/m/Y') }}<br>
                    @endif
                    <strong>Estado:</strong> {{ ucfirst($invoice->estado) }}
                </div>
            </td>
        </tr>
    </table>

    <!-- AVISO DE FACTURA RECTIFICATIVA -->
    @if($invoice->is_rectificativa)
        <div class="rectificativa-box">
            <strong>DOCUMENTO DE RECTIFICACIÓN / ABONO</strong><br>
            Rectifica a la factura: <strong>{{ $invoice->facturaRectificada?->numero_completo ?? 'N/A' }}</strong><br>
            Motivo de rectificación: {{ $invoice->motivo_rectificacion ?? 'Corrección fiscal de importes' }}
        </div>
    @endif

    <!-- DATOS DEL CLIENTE / RECEPTOR -->
    @php
        $clientData = $invoice->client_snapshot ?? [
            'nombre_razon_social' => $invoice->client->nombre_razon_social ?? 'Cliente',
            'cif_nif'             => $invoice->client->cif_nif ?? '',
            'direccion'           => $invoice->client->direccion ?? '',
            'codigo_postal'       => $invoice->client->codigo_postal ?? '',
            'ciudad'              => $invoice->client->ciudad ?? '',
            'provincia'           => $invoice->client->provincia ?? '',
            'pais'                => $invoice->client->pais ?? 'ES',
        ];
    @endphp
    <table class="table-layout" style="margin-top: 5px;">
        <tr>
            <td style="width: 100%;">
                <div class="party-header">Datos del Cliente / Facturado a</div>
                <div class="party-body">
                    <div class="party-name">{{ $clientData['nombre_razon_social'] }}</div>
                    @if(!empty($clientData['cif_nif']))
                        <strong>NIF/CIF:</strong> {{ $clientData['cif_nif'] }}<br>
                    @endif
                    @if(!empty($clientData['direccion']))
                        <strong>Dirección:</strong> {{ $clientData['direccion'] }}<br>
                    @endif
                    @if(!empty($clientData['codigo_postal']) || !empty($clientData['ciudad']))
                        {{ $clientData['codigo_postal'] }} {{ $clientData['ciudad'] }} ({{ $clientData['provincia'] ?? 'España' }})
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- TABLA DE LÍNEAS / CONCEPTOS -->
    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción / Concepto</th>
                <th class="text-center" style="width: 45px;">Cant.</th>
                <th class="text-right" style="width: 75px;">Precio U.</th>
                <th class="text-center" style="width: 45px;">IVA</th>
                @if($invoice->importe_recargo_equivalencia > 0)
                    <th class="text-center" style="width: 45px;">R.E.</th>
                @endif
                <th class="text-right" style="width: 85px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->concepto }}</td>
                    <td class="text-center">{{ number_format($item->cantidad, 2) }}</td>
                    <td class="text-right">{{ number_format($item->precio_unitario, 2) }} €</td>
                    <td class="text-center">{{ number_format($item->iva_porcentaje, 0) }}%</td>
                    @if($invoice->importe_recargo_equivalencia > 0)
                        <td class="text-center">{{ number_format($item->recargo_porcentaje, 1) }}%</td>
                    @endif
                    <td class="text-right">{{ number_format($item->importe_total, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALES Y NOTAS CON TABLA DE 2 COLUMNAS (COMPATIBILIDAD DOMPDF SIN FLOATS) -->
    <table class="table-layout" style="margin-top: 20px;">
        <tr>
            <!-- NOTAS Y TÉRMINOS -->
            <td style="width: 55%; padding-right: 20px;">
                @if($invoice->notas)
                    <div class="notes-title">Notas y Condiciones de Pago</div>
                    <div class="notes-body">
                        {!! nl2br(e($invoice->notas)) !!}
                    </div>
                @endif
            </td>
            <!-- DESGLOSE FISCAL DE TOTALES -->
            <td style="width: 45%;">
                <table class="totals-table">
                    <tr>
                        <td class="label">Base Imponible:</td>
                        <td class="value">{{ number_format($invoice->base_imponible, 2) }} €</td>
                    </tr>
                    <tr>
                        <td class="label">IVA:</td>
                        <td class="value">{{ number_format($invoice->importe_iva, 2) }} €</td>
                    </tr>
                    @if($invoice->importe_recargo_equivalencia > 0)
                        <tr>
                            <td class="label">Recargo Equivalencia:</td>
                            <td class="value">{{ number_format($invoice->importe_recargo_equivalencia, 2) }} €</td>
                        </tr>
                    @endif
                    @if($invoice->importe_irpf > 0)
                        <tr>
                            <td class="label">Retención IRPF:</td>
                            <td class="value" style="color: #c53030;">-{{ number_format($invoice->importe_irpf, 2) }} €</td>
                        </tr>
                    @endif
                    <tr class="grand-total-row">
                        <td class="grand-total-label">TOTAL FACTURA:</td>
                        <td class="grand-total-value">{{ number_format($invoice->total, 2) }} €</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- PIE DE PÁGINA LEGAL -->
    <div class="footer">
        {{ $tenant->razon_social }} — NIF/CIF: {{ $tenant->cif_nif }} — Documento fiscal generado electrónicamente.
    </div>

</body>
</html>
