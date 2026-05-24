<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'tenant_id',
        'nombre',
        'nif_cif',
        'email',
        'telefono',
        'direccion',
        'pais',
        'provincia',
        'cp'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
