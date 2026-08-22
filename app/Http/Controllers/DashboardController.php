<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main SaaS panel dashboard with high-performance aggregated metrics.
     */
    public function index()
    {
        if (auth()->user()->role === 'superadmin' || !auth()->user()->tenant_id) {
            return redirect()->route('admin.dashboard');
        }

        $tenant = auth()->user()->tenant;

        // Agregación directa de SQL en una sola query para reducir la latencia < 20ms
        $stats = Invoice::selectRaw("
            COUNT(*) as total_invoices,
            COALESCE(SUM(CASE WHEN estado != 'anulada' THEN total ELSE 0 END), 0) as total_facturado,
            COALESCE(SUM(CASE WHEN estado = 'cobrada' THEN total ELSE 0 END), 0) as total_cobrado,
            COALESCE(SUM(CASE WHEN estado = 'emitida' THEN total ELSE 0 END), 0) as total_pendiente,
            COUNT(CASE WHEN estado = 'emitida' THEN 1 END) as facturas_pendientes,
            COUNT(CASE WHEN estado = 'cobrada' THEN 1 END) as facturas_cobradas,
            COUNT(CASE WHEN estado = 'borrador' THEN 1 END) as facturas_borrador
        ")->first();

        $totalClients = Client::count();

        // Eager loading para prevenir N+1 queries al renderizar detalles de cliente o líneas
        $ultimasFacturas = Invoice::with(['client', 'items'])
            ->latest('fecha_emision')
            ->take(6)
            ->get();

        return view('panel.dashboard', compact('tenant', 'stats', 'totalClients', 'ultimasFacturas'));
    }
}
