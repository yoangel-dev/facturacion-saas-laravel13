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
        // Esta validación evita que falle el despliegue si la tabla ya existe en Railway
        if (!Schema::hasTable('tenants')) {
            Schema::create('tenants', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('tipo')->default('empresa'); // creator, autonomo, empresa
                $table->string('plan')->default('free');    // free, pro, enterprise
                $table->boolean('activo')->default(true);
                $table->integer('limite_facturas')->default(50);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tenants');
    }
};
