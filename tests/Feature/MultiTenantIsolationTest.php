<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;

test('tenant a cannot see tenant b clients or invoices', function () {
    $tenantA = Tenant::where('cif_nif', 'B87654321')->first();
    $tenantB = Tenant::where('cif_nif', '77889900K')->first();

    $userA = User::where('tenant_id', $tenantA->id)->first();
    $userB = User::where('tenant_id', $tenantB->id)->first();

    $expectedClientsA = Client::withoutGlobalScopes()->where('tenant_id', $tenantA->id)->count();
    $expectedInvoicesA = Invoice::withoutGlobalScopes()->where('tenant_id', $tenantA->id)->count();

    // Autenticado como Usuario de Tenant A
    $this->actingAs($userA);

    expect(Client::count())->toBe($expectedClientsA);
    expect(Invoice::count())->toBe($expectedInvoicesA);

    // Comprobamos que no puede consultar por ID clientes de Tenant B
    $clientB = Client::withoutGlobalScopes()->where('tenant_id', $tenantB->id)->first();
    expect(Client::find($clientB->id))->toBeNull();

    // Comprobamos que no puede consultar por ID facturas de Tenant B
    $invoiceB = Invoice::withoutGlobalScopes()->where('tenant_id', $tenantB->id)->first();
    expect(Invoice::find($invoiceB->id))->toBeNull();

    $expectedClientsB = Client::withoutGlobalScopes()->where('tenant_id', $tenantB->id)->count();
    $expectedInvoicesB = Invoice::withoutGlobalScopes()->where('tenant_id', $tenantB->id)->count();

    // Autenticado como Usuario de Tenant B
    $this->actingAs($userB);

    expect(Client::count())->toBe($expectedClientsB);
    expect(Invoice::count())->toBe($expectedInvoicesB);

    // Comprobamos que no puede consultar por ID clientes de Tenant A
    $clientA = Client::withoutGlobalScopes()->where('tenant_id', $tenantA->id)->first();
    expect(Client::find($clientA->id))->toBeNull();
});

test('superadmin can see all clients and invoices globally', function () {
    $superadmin = User::where('role', 'superadmin')->first();

    $this->actingAs($superadmin);

    $totalClientsGlobal = Client::withoutGlobalScopes()->count();
    $totalInvoicesGlobal = Invoice::withoutGlobalScopes()->count();

    // El superadmin tiene visión global de todos los tenants
    expect(Client::count())->toBe($totalClientsGlobal);
    expect(Invoice::count())->toBe($totalInvoicesGlobal);
});
