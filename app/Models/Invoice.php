<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use DomainException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'client_id',
        'client_snapshot',
        'serie',
        'numero',
        'numero_completo',
        'fecha_emision',
        'fecha_vencimiento',
        'estado',
        'base_imponible',
        'importe_iva',
        'importe_irpf',
        'importe_recargo_equivalencia',
        'total',
        'is_rectificativa',
        'factura_rectificada_id',
        'motivo_rectificacion',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'client_snapshot'               => 'array',
            'fecha_emision'                 => 'date',
            'fecha_vencimiento'             => 'date',
            'base_imponible'                => 'decimal:2',
            'importe_iva'                   => 'decimal:2',
            'importe_irpf'                  => 'decimal:2',
            'importe_recargo_equivalencia'  => 'decimal:2',
            'total'                         => 'decimal:2',
            'is_rectificativa'              => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // 🔒 INMUTABILIDAD FISCAL: Prevenir modificación de facturas emitidas o cobradas
        static::updating(function (Invoice $invoice) {
            $originalEstado = $invoice->getOriginal('estado');

            if (in_array($originalEstado, ['emitida', 'cobrada'])) {
                $dirtyFields = array_keys($invoice->getDirty());
                $allowedFields = ['estado']; // Solo se permite marcar cobrada o cambiar estado de cobro
                $forbiddenChanges = array_diff($dirtyFields, $allowedFields);

                if (!empty($forbiddenChanges)) {
                    throw new DomainException(
                        "Normativa Fiscal: No se permite modificar los datos de una factura en estado '{$originalEstado}'. " .
                        "Para corregir importes debe emitir una Factura Rectificativa."
                    );
                }
            }

            // Snapshot automático al emitir si aún no tiene
            if (in_array($invoice->estado, ['emitida', 'cobrada']) && empty($invoice->client_snapshot) && $invoice->client) {
                $invoice->client_snapshot = [
                    'nombre_razon_social' => $invoice->client->nombre_razon_social,
                    'cif_nif'             => $invoice->client->cif_nif,
                    'direccion'           => $invoice->client->direccion,
                    'codigo_postal'       => $invoice->client->codigo_postal,
                    'ciudad'              => $invoice->client->ciudad,
                    'provincia'           => $invoice->client->provincia,
                    'pais'                => $invoice->client->pais,
                ];
            }
        });

        // 🔒 INMUTABILIDAD FISCAL: Prevenir eliminación física de facturas emitidas o cobradas
        static::deleting(function (Invoice $invoice) {
            if (in_array($invoice->estado, ['emitida', 'cobrada'])) {
                throw new DomainException(
                    "Normativa Fiscal: No se puede eliminar la factura '{$invoice->numero_completo}' " .
                    "porque está en estado '{$invoice->estado}'. Debe anularse o emitirse una Factura Rectificativa."
                );
            }
        });

        // Snapshot en creación si ya nace emitida/cobrada
        static::creating(function (Invoice $invoice) {
            if (in_array($invoice->estado, ['emitida', 'cobrada']) && empty($invoice->client_snapshot) && $invoice->client_id) {
                $client = Client::withoutGlobalScopes()->find($invoice->client_id);
                if ($client) {
                    $invoice->client_snapshot = [
                        'nombre_razon_social' => $client->nombre_razon_social,
                        'cif_nif'             => $client->cif_nif,
                        'direccion'           => $client->direccion,
                        'codigo_postal'       => $client->codigo_postal,
                        'ciudad'              => $client->ciudad,
                        'provincia'           => $client->provincia,
                        'pais'                => $client->pais,
                    ];
                }
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function facturaRectificada(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'factura_rectificada_id');
    }

    public function facturasRectificativas(): HasMany
    {
        return $this->hasMany(Invoice::class, 'factura_rectificada_id');
    }
}
