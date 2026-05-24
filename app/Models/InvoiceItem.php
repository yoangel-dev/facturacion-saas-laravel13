<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'iva_porcentaje',
        'irpf_porcentaje',
        'importe_total',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
