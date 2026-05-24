<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('admin.tenants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'plan' => 'required',
            'limite_facturas' => 'required|integer'
        ]);

        Tenant::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'plan' => $request->plan,
            'activo' => true,
            'limite_facturas' => $request->limite_facturas
        ]);

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant creado correctamente');
    }

    public function invoices($id)
    {
        $tenant = Tenant::findOrFail($id);
        $invoices = Invoice::where('tenant_id', $id)->get();

        return view('admin.tenants.invoices', compact('tenant', 'invoices'));
    }

    public function clients($id)
    {
        $tenant = Tenant::findOrFail($id);
        $clients = Client::where('tenant_id', $id)->get();

        return view('admin.tenants.clients', compact('tenant', 'clients'));
    }
}
