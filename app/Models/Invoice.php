<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'tenant_id',
        'client_id',
        'numero',
        'fecha_emision',
        'fecha_vencimiento',
        'subtotal',
        'iva_total',
        'irpf_total',
        'total',
        'estado',
        'notas'
    ];

    // Relación con cliente
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación en el modelo InvoiceItem
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
