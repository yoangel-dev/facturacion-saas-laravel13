<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        $pdf = \PDF::loadView('invoices.pdf', [
            'invoice' => $this->invoice,
            'tenant' => $this->invoice->tenant
        ]);

        return $this->subject('Factura #' . $this->invoice->id)
                    ->markdown('emails.invoice')
                    ->attachData(
                        $pdf->output(),
                        'factura_' . $this->invoice->id . '.pdf',
                        ['mime' => 'application/pdf']
                    );
    }

}
