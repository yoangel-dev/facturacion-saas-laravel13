<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminTenantController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// RUTAS PÚBLICAS
// =========================================================================

Route::get('/', function () {
    return view('welcome');
});

// =========================================================================
// PANEL SUPERADMIN
// =========================================================================

Route::middleware(['auth', 'superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Superadmin
        Route::get('/', [AdminTenantController::class, 'dashboard'])->name('dashboard');

        // Tenants
        Route::resource('tenants', AdminTenantController::class);
        Route::get('tenants/{tenant}/suspend', [AdminTenantController::class, 'suspend'])->name('tenants.suspend');
        Route::get('tenants/{tenant}/activate', [AdminTenantController::class, 'activate'])->name('tenants.activate');

        // Users Globales
        Route::resource('users', AdminUserController::class);
    });

// =========================================================================
// PANEL ADMIN (MANAGER)
// =========================================================================

Route::middleware(['auth', 'admin'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        // Dashboard Manager
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // Gestión de Tenants
        Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
        Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
        Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
        Route::get('/tenants/{id}/toggle', [TenantController::class, 'toggle'])->name('tenants.toggle');
        Route::get('/tenants/{id}/invoices', [TenantController::class, 'invoices'])->name('tenants.invoices');
        Route::get('/tenants/{id}/clients', [TenantController::class, 'clients'])->name('tenants.clients');

        // Gestión de Usuarios
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

// =========================================================================
// RUTAS CON AUTENTICACIÓN GENERAL (PERFIL Y DASHBOARD POR DEFECTO)
// =========================================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================================================
// PANEL DE CLIENTES Y FACTURACIÓN (USUARIOS AUTENTICADOS)
// =========================================================================

Route::middleware(['auth'])->group(function () {
    // PANEL DASHBOARD
    Route::get('/panel', function () {
        return view('panel.dashboard');
    })->name('panel.dashboard');

    // CLIENTES
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::get('/{id}', [ClientController::class, 'show'])->name('clients.show');
    });

    // FACTURAS
    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::get('/{id}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
        Route::get('/{id}/toggle', [InvoiceController::class, 'toggleEstado'])->name('invoices.toggle');
        Route::get('/{id}/email', [InvoiceController::class, 'sendEmail'])->name('invoices.email');
    });
});

require __DIR__.'/auth.php';
