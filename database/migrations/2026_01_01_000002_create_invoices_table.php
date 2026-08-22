<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('restrict');
            $table->foreignId('client_id')->constrained('clients')->onDelete('restrict');

            // Snapshot inmutable de los datos fiscales del cliente al emitir
            $table->json('client_snapshot')->nullable();

            // Numeración correlativa y series
            $table->string('serie', 10);
            $table->unsignedInteger('numero');
            $table->string('numero_completo', 20);

            // Fechas y estados
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('estado', ['borrador', 'emitida', 'cobrada', 'anulada'])->default('borrador');

            // Totales e importes
            $table->decimal('base_imponible', 10, 2)->default(0);
            $table->decimal('importe_iva', 10, 2)->default(0);
            $table->decimal('importe_irpf', 10, 2)->default(0);
            $table->decimal('importe_recargo_equivalencia', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // Facturación Rectificativa
            $table->boolean('is_rectificativa')->default(false);
            $table->foreignId('factura_rectificada_id')
                  ->nullable()
                  ->constrained('invoices')
                  ->onDelete('restrict');
            $table->text('motivo_rectificacion')->nullable();

            // Notas
            $table->text('notas')->nullable();

            $table->timestamps();

            // Restricción de unicidad estricta para evitar duplicados en numeración por serie y tenant
            $table->unique(['tenant_id', 'serie', 'numero'], 'uniq_tenant_serie_numero');
            $table->index(['tenant_id', 'estado', 'fecha_emision']);
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
