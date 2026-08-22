<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // El GlobalScope de BelongsToTenant aísla automáticamente los clientes del tenant actual
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::with('invoices')->findOrFail($id);
        return view('clients.show', compact('client'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_razon_social'         => 'required|string|max:255',
            'cif_nif'                     => 'nullable|string|max:20',
            'email'                       => 'nullable|email|max:255',
            'telefono'                    => 'nullable|string|max:30',
            'direccion'                   => 'nullable|string|max:255',
            'codigo_postal'               => 'nullable|string|max:10',
            'ciudad'                      => 'nullable|string|max:100',
            'provincia'                   => 'nullable|string|max:100',
            'pais'                        => 'nullable|string|max:5',
            'aplica_recargo_equivalencia' => 'nullable|boolean',
        ]);

        $validated['aplica_recargo_equivalencia'] = $request->boolean('aplica_recargo_equivalencia');

        $client = Client::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente creado correctamente.',
                'client'  => $client,
            ], 201);
        }

        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'nombre_razon_social'         => 'required|string|max:255',
            'cif_nif'                     => 'nullable|string|max:20',
            'email'                       => 'nullable|email|max:255',
            'telefono'                    => 'nullable|string|max:30',
            'direccion'                   => 'nullable|string|max:255',
            'codigo_postal'               => 'nullable|string|max:10',
            'ciudad'                      => 'nullable|string|max:100',
            'provincia'                   => 'nullable|string|max:100',
            'pais'                        => 'nullable|string|max:5',
            'aplica_recargo_equivalencia' => 'nullable|boolean',
        ]);

        $validated['aplica_recargo_equivalencia'] = $request->boolean('aplica_recargo_equivalencia');

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        // Prevenir borrado si tiene facturas asociadas para mantener trazabilidad contable
        if ($client->invoices()->exists()) {
            return redirect()->route('clients.index')->with('error', 'No se puede eliminar el cliente porque tiene facturas emitidas asociadas.');
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
