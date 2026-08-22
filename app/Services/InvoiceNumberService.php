<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    /**
     * Genera el siguiente número correlativo para un tenant y serie dados
     * utilizando bloqueo pesimista (pessimistic locking) en una transacción de base de datos.
     *
     * @param  Tenant  $tenant
     * @param  string  $serie
     * @return array{numero: int, numero_completo: string}
     */
    public function generarSiguienteNumero(Tenant $tenant, string $serie): array
    {
        return DB::transaction(function () use ($tenant, $serie) {
            // Buscamos el último número para este tenant y serie bloqueando las filas concurrentes
            $ultimoNumero = Invoice::withoutGlobalScopes()
                ->where('tenant_id', $tenant->id)
                ->where('serie', $serie)
                ->lockForUpdate()
                ->max('numero');

            $siguiente = ($ultimoNumero ?? 0) + 1;
            $numeroCompleto = sprintf('%s-%04d', strtoupper(trim($serie)), $siguiente);

            return [
                'numero'          => (int) $siguiente,
                'numero_completo' => $numeroCompleto,
            ];
        });
    }
}
