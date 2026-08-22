<?php

use App\Http\Controllers\Admin\AdminTenantController;
use App\Http\Controllers\Admin\AdminUserController;
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
// PANEL SUPERADMIN (GESTIÓN GLOBAL DE TENANTS Y USUARIOS)
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
// RUTAS CON AUTENTICACIÓN GENERAL (PERFIL Y REDIRECCIÓN)
// =========================================================================

Route::get('/dashboard', function () {
    return redirect()->route('panel.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\DashboardController;

// =========================================================================
// PANEL DE CLIENTES Y FACTURACIÓN (MULTI-TENANT AISLADO)
// =========================================================================

Route::middleware(['auth'])->group(function () {
    // PANEL DASHBOARD
    Route::get('/panel', [DashboardController::class, 'index'])->name('panel.dashboard');

    // CLIENTES
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/', [ClientController::class, 'store'])->name('store');
        Route::get('/{id}', [ClientController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClientController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('destroy');
    });

    // FACTURAS
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/pdf', [InvoiceController::class, 'downloadPdf'])->name('pdf');
        Route::get('/{id}/toggle', [InvoiceController::class, 'toggleEstado'])->name('toggle');
        Route::get('/{id}/email', [InvoiceController::class, 'sendEmail'])->name('email');
    });
});

require __DIR__.'/auth.php';
