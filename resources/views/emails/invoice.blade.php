@component('mail::message')
# Factura {{ $invoice->numero_completo }}

Hola {{ $invoice->client_snapshot['nombre_razon_social'] ?? $invoice->client->nombre_razon_social }},

Adjuntamos su factura correspondiente generada en formato PDF.

**Fecha de Emisión:** {{ \Carbon\Carbon::parse($invoice->fecha_emision)->format('d/m/Y') }}  
**Base Imponible:** {{ number_format($invoice->base_imponible, 2) }} €  
**Total a Pagar:** {{ number_format($invoice->total, 2) }} €  
**Estado:** {{ ucfirst($invoice->estado) }}

Gracias por confiar en nosotros.

Saludos cordiales,  
**{{ $invoice->tenant->razon_social }}**
@endcomponent
