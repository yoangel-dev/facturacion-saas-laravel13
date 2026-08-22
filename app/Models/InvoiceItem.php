<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'concepto',
        'cantidad',
        'precio_unitario',
        'iva_porcentaje',
        'recargo_porcentaje',
        'importe_base',
        'importe_total',
    ];

    protected function casts(): array
    {
        return [
            'cantidad'           => 'decimal:2',
            'precio_unitario'    => 'decimal:2',
            'iva_porcentaje'     => 'decimal:2',
            'recargo_porcentaje' => 'decimal:2',
            'importe_base'       => 'decimal:2',
            'importe_total'      => 'decimal:2',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
