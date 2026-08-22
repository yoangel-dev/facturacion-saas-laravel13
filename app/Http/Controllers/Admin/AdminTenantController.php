<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTenantController extends Controller
{
    public function dashboard()
    {
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('estado', 'activo')->count();
        $suspendedTenants = Tenant::where('estado', 'inactivo')->count();
        $totalUsers = User::count();

        // Sin GlobalScope para agregación global Superadmin
        $totalInvoicesGlobal = Invoice::withoutGlobalScopes()->count();
        $totalFacturadoGlobal = Invoice::withoutGlobalScopes()->where('estado', '!=', 'anulada')->sum('total');
        $latestTenants = Tenant::withCount(['users', 'invoices'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTenants',
            'activeTenants',
            'suspendedTenants',
            'totalUsers',
            'totalInvoicesGlobal',
            'totalFacturadoGlobal',
            'latestTenants'
        ));
    }

    public function index()
    {
        $tenants = Tenant::withCount(['users', 'invoices'])->latest()->paginate(20);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('admin.tenants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_comercial'      => 'required|string|max:255',
            'razon_social'          => 'required|string|max:255',
            'cif_nif'               => 'required|string|max:20|unique:tenants,cif_nif',
            'email'                 => 'nullable|email|max:255',
            'telefono'              => 'nullable|string|max:30',
            'direccion'             => 'nullable|string|max:255',
            'codigo_postal'         => 'nullable|string|max:10',
            'ciudad'                => 'nullable|string|max:100',
            'provincia'             => 'nullable|string|max:100',
            'irpf_por_defecto'      => 'nullable|numeric|min:0|max:100',
            'serie_factura_default' => 'nullable|string|max:10',
            'estado'                => 'required|in:activo,inactivo',
        ]);

        Tenant::create($validated);

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant registrado correctamente');
    }

    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'nombre_comercial'      => 'required|string|max:255',
            'razon_social'          => 'required|string|max:255',
            'cif_nif'               => 'required|string|max:20|unique:tenants,cif_nif,' . $tenant->id,
            'email'                 => 'nullable|email|max:255',
            'telefono'              => 'nullable|string|max:30',
            'direccion'             => 'nullable|string|max:255',
            'codigo_postal'         => 'nullable|string|max:10',
            'ciudad'                => 'nullable|string|max:100',
            'provincia'             => 'nullable|string|max:100',
            'irpf_por_defecto'      => 'nullable|numeric|min:0|max:100',
            'serie_factura_default' => 'nullable|string|max:10',
            'estado'                => 'required|in:activo,inactivo',
        ]);

        $tenant->update($validated);

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant actualizado correctamente');
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->invoices()->exists() || $tenant->users()->exists()) {
            return redirect()->route('admin.tenants.index')
                ->with('error', 'No se puede eliminar un tenant que contiene facturas o usuarios vinculados.');
        }

        $tenant->delete();

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant eliminado correctamente');
    }

    public function suspend(Tenant $tenant)
    {
        $tenant->update(['estado' => 'inactivo']);
        return back()->with('success', 'Tenant suspendido.');
    }

    public function activate(Tenant $tenant)
    {
        $tenant->update(['estado' => 'activo']);
        return back()->with('success', 'Tenant activado.');
    }
}
