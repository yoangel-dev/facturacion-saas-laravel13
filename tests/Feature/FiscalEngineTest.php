<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;
use App\Services\InvoiceNumberService;

test('generates sequential numbers correctly per tenant and serie', function () {
    $service = new InvoiceNumberService();
    $tenantA = Tenant::where('cif_nif', 'B87654321')->first();

    $currentMaxF = Invoice::withoutGlobalScopes()->where('tenant_id', $tenantA->id)->where('serie', 'F2026')->max('numero') ?? 0;
    $nextA = $service->generarSiguienteNumero($tenantA, 'F2026');
    expect($nextA['numero'])->toBe($currentMaxF + 1);
    expect($nextA['numero_completo'])->toBe('F2026-' . str_pad($currentMaxF + 1, 4, '0', STR_PAD_LEFT));

    $currentMaxR = Invoice::withoutGlobalScopes()->where('tenant_id', $tenantA->id)->where('serie', 'R2026')->max('numero') ?? 0;
    $nextRec = $service->generarSiguienteNumero($tenantA, 'R2026');
    expect($nextRec['numero'])->toBe($currentMaxR + 1);
    expect($nextRec['numero_completo'])->toBe('R2026-' . str_pad($currentMaxR + 1, 4, '0', STR_PAD_LEFT));
});

test('stores invoice with live fiscal math and snapshot', function () {
    $tenantA = Tenant::where('cif_nif', 'B87654321')->first();
    $userA = User::where('tenant_id', $tenantA->id)->first();
    $client = Client::withoutGlobalScopes()->where('tenant_id', $tenantA->id)->first();

    $service = new InvoiceNumberService();
    $expectedNum = $service->generarSiguienteNumero($tenantA, 'F2026');

    $response = $this->actingAs($userA)->post(route('invoices.store'), [
        'client_id'       => $client->id,
        'serie'           => 'F2026',
        'fecha_emision'   => '2026-03-01',
        'estado'          => 'emitida',
        'irpf_porcentaje' => 15.00,
        'items'           => [
            [
                'concepto'           => 'Desarrollo Frontend React',
                'cantidad'           => 10,
                'precio_unitario'    => 50.00,
                'iva_porcentaje'     => 21,
                'recargo_porcentaje' => 0,
            ],
            [
                'concepto'           => 'Configuración Dominio y SSL',
                'cantidad'           => 1,
                'precio_unitario'    => 100.00,
                'iva_porcentaje'     => 21,
                'recargo_porcentaje' => 0,
            ],
        ],
        'notas'           => 'Transferencia a 15 días',
    ]);

    $response->assertRedirect();

    // Verificamos en BD: Base = 500 + 100 = 600, IVA = 126, IRPF = 90, Total = 636
    $this->assertDatabaseHas('invoices', [
        'tenant_id'       => $tenantA->id,
        'numero_completo' => $expectedNum['numero_completo'],
        'base_imponible'  => 600.00,
        'importe_iva'     => 126.00,
        'importe_irpf'    => 90.00,
        'total'           => 636.00,
        'estado'          => 'emitida',
    ]);
});
