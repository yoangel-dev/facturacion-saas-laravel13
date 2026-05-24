@component('mail::message')
# Factura #{{ $invoice->id }}

Hola {{ $invoice->client->nombre }},

Adjuntamos su factura correspondiente.

**Total:** {{ number_format($invoice->total, 2) }} €  
**Estado:** {{ ucfirst($invoice->estado) }}

@component('mail::button', ['url' => url('/invoices/' . $invoice->id . '/pdf')])
Descargar PDF
@endcomponent

Gracias por confiar en nosotros.
@endcomponent
