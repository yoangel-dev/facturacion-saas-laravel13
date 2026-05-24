<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('tenant_id', auth()->user()->tenant_id)->get(); // luego filtraremos por tenant_id
        return view('clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client =Client::where('tenant_id', auth()->user()->tenant_id)->findOrFail($id);

        return view('clients.show', compact('client'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        Client::create([
            'tenant_id' => auth()->user()->tenant_id, // temporal, luego será el usuario logueado
            'nombre'    => $request->nombre,
            'nif_cif'   => $request->nif_cif,
            'email'     => $request->email,
            'telefono'  => $request->telefono,
            'direccion' => $request->direccion,
            'pais'      => $request->pais,
            'provincia' => $request->provincia,
            'cp'        => $request->cp,
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado');
    }
}
