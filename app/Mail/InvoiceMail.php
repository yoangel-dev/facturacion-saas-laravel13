<?php

namespace App\Mail;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice
    ) {}

    public function build()
    {
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $this->invoice,
            'tenant'  => $this->invoice->tenant,
        ]);

        return $this->subject('Factura ' . $this->invoice->numero_completo . ' - ' . $this->invoice->tenant->nombre_comercial)
                    ->markdown('emails.invoice')
                    ->attachData(
                        $pdf->output(),
                        'factura_' . $this->invoice->numero_completo . '.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
