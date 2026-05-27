<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User; // Importamos el modelo de usuarios
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modificamos la tabla para añadir la columna si no existe
        if (!Schema::hasColumn('users', 'is_superadmin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_superadmin')->default(false)->after('tenant_id');
            });
        }

        // 2. COMANDO AUTOMÁTICO: Creamos tu usuario administrador de forma segura
        // Si la tabla users existe y no hay cuentas registradas aún, inyectamos la tuya
        if (Schema::hasTable('users') && User::count() === 0) {
            User::create([
                'name' => 'Yoangel Alayon',
                'email' => 'yoangel.alayon@gmail.com', // <-- Configura tu correo de acceso real
                'password' => Hash::make('Welcome1'), // <-- Configura tu contraseña
                'is_superadmin' => true, // Le otorgamos el rol de superadministrador de inmediato
                'tenant_id' => null, // O pon el ID 1 si tu lógica exige que empiece en un tenant existente
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_superadmin')) {
                $table->dropColumn('is_superadmin');
            }
        });
    }
};
