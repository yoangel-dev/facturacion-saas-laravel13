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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->text('concepto');
            $table->decimal('cantidad', 8, 2)->default(1.00);
            $table->decimal('precio_unitario', 10, 2)->default(0.00);
            $table->decimal('iva_porcentaje', 4, 2)->default(21.00);
            $table->decimal('recargo_porcentaje', 4, 2)->default(0.00);
            $table->decimal('importe_base', 10, 2)->default(0.00);
            $table->decimal('importe_total', 10, 2)->default(0.00);
            $table->timestamps();

            $table->index('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
