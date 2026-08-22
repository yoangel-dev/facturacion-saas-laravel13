<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_comercial',
        'razon_social',
        'cif_nif',
        'direccion',
        'codigo_postal',
        'ciudad',
        'provincia',
        'email',
        'telefono',
        'irpf_por_defecto',
        'serie_factura_default',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'irpf_por_defecto' => 'decimal:2',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function isActivo(): bool
    {
        return $this->estado === 'activo';
    }
}
