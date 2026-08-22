<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'nombre_razon_social',
        'cif_nif',
        'email',
        'telefono',
        'direccion',
        'codigo_postal',
        'ciudad',
        'provincia',
        'pais',
        'aplica_recargo_equivalencia',
    ];

    protected function casts(): array
    {
        return [
            'aplica_recargo_equivalencia' => 'boolean',
        ];
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
