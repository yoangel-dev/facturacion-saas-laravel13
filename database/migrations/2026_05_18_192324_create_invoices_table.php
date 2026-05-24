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

        // Relación con tenant (usuario dueño de la factura)
        $table->unsignedBigInteger('tenant_id');

        // Relación con cliente
        $table->unsignedBigInteger('client_id');

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
