<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $invoice->id }}</title>
    <style>
        /* CONFIGURACIÓN GLOBAL */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #2b2d42;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            padding: 30px 40px;
        }

        /* ESTRUCTURA DE TABLAS AUXILIARES */
        .table-layout {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin-bottom: 25px;
        }
        .table-layout td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        /* LOGO Y CABECERA */
        .brand-title {
            font-size: 24px;
            font-weight: bold;
            color: #1a365d;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .company-details {
            font-size: 11px;
            color: #718096;
            margin-top: 5px;
            line-height: 1.4;
        }
        .meta-title {
            font-size: 22px;
            font-weight: 300;
            color: #2b2d42;
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .meta-details {
            text-align: right;
            font-size: 11px;
            margin-top: 5px;
        }
        .meta-details strong {
            color: #1a365d;
        }

        /* BLOQUES DE PARTICIPANTES (EMISOR / RECEPTOR) */
        .party-header {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #a0aec0;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }
        .party-body {
            font-size: 11px;
            color: #2d3748;
            line-height: 1.4;
        }
        .party-name {
            font-size: 13px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 2px;
        }

        /* TABLA PRINCIPAL DE CONCEPTOS */
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
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            text-align: left;
        }
        .items-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #edf2f7;
            color: #2d3748;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }

        /* TOTALES SECCIÓN */
        .totals-wrapper {
            margin-top: 20px;
            width: 100%;
        }
        .totals-table {
            width: 35%;
            float: right;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 6px 8px;
            font-size: 11px;
            color: #4a5568;
        }
        .totals-table .label {
            text-align: right;
            color: #718096;
        }
        .totals-table .value {
            text-align: right;
            font-weight: 500;
        }
        .totals-table .grand-total-row td {
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }
        .totals-table .grand-total-label {
            font-size: 14px;
            font-weight: bold;
            color: #1a365d;
            text-align: right;
        }
        .totals-table .grand-total-value {
            font-size: 14px;
            font-weight: bold;
            color: #1a365d;
            text-align: right;
        }

        /* NOTAS Y PIE DE PÁGINA */
        .notes-section {
            margin-top: 40px;
            width: 60%;
            float: left;
        }
        .notes-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #718096;
            margin-bottom: 4px;
        }
        .notes-body {
            font-size: 10px;
            color: #718096;
            line-height: 1.4;
        }
        .footer {
            position: fixed;
            bottom: 30px;
            left: 40px;
            right: 40px;
            text-align: center;
            font-size: 9px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <div class="invoice-container">

        <!-- CABECERA PRINCIPAL -->
        <table class="table-layout">
            <tr>
                <!-- DATOS DEL EMISOR (TU EMPRESA O TÚ COMO AUTÓNOMO) -->
                <td>
                    <div class="brand-title">{{ $tenant->nombre }}</div>
                    <div class="company-details">
                        Razón Social: {{ $profile->razon_social ?? $tenant->nombre }}<br>
                        NIF/CIF: {{ $profile->nif_cif ?? '00000000X' }}<br>
                        {{ $profile->direccion ?? 'Tu Dirección Comercial 123' }}<br>
                        {{ $profile->pais ?? 'España' }}
                    </div>
                </td>
                <!-- INFORMACIÓN DE LA FACTURA -->
                <td style="width: 40%;">
                    <div class="meta-title">Factura</div>
                    <div class="meta-details">
                        <strong>Número:</strong> #{{ $invoice->id }}<br>
                        <strong>Fecha Emisión:</strong> {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('d/m/Y') }}<br>
                        @if($invoice->fecha_vencimiento)
                            <strong>Vencimiento:</strong> {{ \Carbon\Carbon::parse($invoice->fecha_vencimiento)->format('d/m/Y') }}<br>
                        @endif
                        <strong>Estado:</strong> {{ ucfirst($invoice->estado) }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- INFORMACIÓN DEL CLIENTE (EMPRESA, AUTÓNOMO O PARTICULAR) -->
        <table class="table-layout" style="margin-top: 10px;">
            <tr>
                <td style="width: 100%;">
                    <div class="party-header">Facturado a</div>
                    <div class="party-body">
                        <div class="party-name">{{ $invoice->client->nombre }}</div>
                        @if(!empty($invoice->client->nif_cif))
                            <strong>NIF/CIF:</strong> {{ $invoice->client->nif_cif }}<br>
                        @endif
                        @if(!empty($invoice->client->direccion))
                            <strong>Dirección:</strong> {{ $invoice->client->direccion }}<br>
                        @endif
                        <strong>Email:</strong> {{ $invoice->client->email }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- DETALLE DE CONCEPTOS -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Descripción / Concepto</th>
                    <th class="text-center" style="width: 60px;">Cant.</th>
                    <th class="text-right" style="width: 90px;">Precio U.</th>
                    <th class="text-center" style="width: 60px;">IVA</th>
                    @if($invoice->irpf_total > 0)
                        <th class="text-center" style="width: 60px;">IRPF</th>
                    @endif
                    <th class="text-right" style="width: 100px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->descripcion }}</td>
                        <td class="text-center">{{ $item->cantidad }}</td>
                        <td class="text-right">{{ number_format($item->precio_unitario, 2) }} €</td>
                        <td class="text-center">{{ $item->iva_porcentaje }}%</td>
                        @if($invoice->irpf_total > 0)
                            <td class="text-center">{{ $item->irpf_porcentaje }}%</td>
                        @endif
                        <td class="text-right">{{ number_format($item->importe_total, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TOTALES Y NOTAS -->
        <div class="totals-wrapper">
            <!-- NOTAS Y TÉRMINOS -->
            <div class="notes-section">
                @if($invoice->notas)
                    <div class="notes-title">Notas adicionales</div>
                    <div class="notes-body">
                        {{ $invoice->notas }}
                    </div>
                @endif
            </div>

            <!-- DESGLOSE DE TOTALES -->
            <table class="totals-table">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td class="value">{{ number_format($invoice->subtotal, 2) }} €</td>
                </tr>
                <tr>
                    <td class="label">IVA Total:</td>
                    <td class="value">{{ number_format($invoice->iva_total, 2) }} €</td>
                </tr>
                @if($invoice->irpf_total > 0)
                    <tr>
                        <td class="label">Retención IRPF:</td>
                        <td class="value" style="color: #c53030;">-{{ number_format($invoice->irpf_total, 2) }} €</td>
                    </tr>
                @endif
                <tr class="grand-total-row">
                    <td class="grand-total-label">Total:</td>
                    <td class="grand-total-value">{{ number_format($invoice->total, 2) }} €</td>
                </tr>
            </table>
        </div>

    </div>

    <!-- PIE DE PÁGINA LEGALES -->
    <div class="footer">
        {{ $profile->razon_social ?? $tenant->nombre }} — NIF/CIF: {{ $profile->nif_cif ?? '' }} — Sistema de facturación automatizado.
        <p class="text-center mt-4" style="font-size: 11px; color: #777;"> © 2024–2026 Yoangel-dev Software. Sistema de Facturación SaaS.</p>
    </div>

</body>
</html>
