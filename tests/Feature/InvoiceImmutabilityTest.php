<?php

use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;

test('cannot delete an emitted or cobrada invoice', function () {
    $tenantA = Tenant::where('cif_nif', 'B87654321')->first();
    $userA = User::where('tenant_id', $tenantA->id)->first();

    $this->actingAs($userA);

    $emittedInvoice = Invoice::where('estado', 'emitida')->first();

    expect(fn () => $emittedInvoice->delete())->toThrow(DomainException::class);
});

test('cannot modify total or fiscal fields of an emitted invoice', function () {
    $tenantA = Tenant::where('cif_nif', 'B87654321')->first();
    $userA = User::where('tenant_id', $tenantA->id)->first();

    $this->actingAs($userA);

    $emittedInvoice = Invoice::where('estado', 'emitida')->first();

    expect(function () use ($emittedInvoice) {
        $emittedInvoice->update([
            'total'          => 9999.00,
            'base_imponible' => 8000.00,
        ]);
    })->toThrow(DomainException::class);
});

test('can delete a draft borrador invoice', function () {
    $tenantA = Tenant::where('cif_nif', 'B87654321')->first();
    $userA = User::where('tenant_id', $tenantA->id)->first();

    $this->actingAs($userA);

    $draftInvoice = Invoice::where('estado', 'borrador')->first();
    $draftId = $draftInvoice->id;

    $deleted = $draftInvoice->delete();
    expect($deleted)->toBeTrue();

    expect(Invoice::find($draftId))->toBeNull();
});
