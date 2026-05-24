<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTenantController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalTenants'     => Tenant::count(),
            'activeTenants'    => Tenant::where('estado', 'activo')->count(),
            'suspendedTenants' => Tenant::where('estado', 'suspendido')->count(),
            'totalUsers'       => User::count(),
        ]);
    }


    public function index()
    {
        $tenants = Tenant::latest()->paginate(20);
        
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
            'email'  => 'required|email',
            'estado' => 'required',
        ]);

        Tenant::create($request->only('nombre', 'email', 'estado'));

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant creado correctamente');
    }

    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'nombre' => 'required',
            'email'  => 'required|email',
            'estado' => 'required',
        ]);

        $tenant->update($request->only('nombre', 'email', 'estado'));

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant actualizado');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant eliminado');
    }

    public function suspend(Tenant $tenant)
    {
        $tenant->update(['estado' => 'suspendido']);

        return back()->with('success', 'Tenant suspendido');
    }

    public function activate(Tenant $tenant)
    {
        $tenant->update(['estado' => 'activo']);

        return back()->with('success', 'Tenant activado');
    }
}
