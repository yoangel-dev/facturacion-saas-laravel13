<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL; // 🔒 IMPORTANTE: Añadimos la fachada URL

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define aquí la redirección por defecto tras el Login en Laravel 11
        
        // 🔒 FORZAR HTTPS EN PRODUCCIÓN: Elimina las alertas de seguridad y habilita descargas de PDF
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
