<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // Relación con tenant (Si se borra el tenant/usuario, se borran sus facturas)
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');

            // Relación con cliente (Si se borra el cliente, se borran sus facturas automáticamente)
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');

            // Datos básicos de la factura
            $table->string('numero')->nullable(); // Ej: 2026-0001
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento')->nullable();

            // Totales
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('iva_total', 10, 2)->default(0);
            $table->decimal('irpf_total', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // Estado
            $table->enum('estado', ['borrador', 'emitida', 'cobrada', 'cancelada'])
                  ->default('borrador');

            // Notas
            $table->text('notas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
