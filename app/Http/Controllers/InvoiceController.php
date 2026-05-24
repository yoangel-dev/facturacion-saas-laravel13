<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail; // Asegúrate de importar la fachada Mail

class InvoiceController extends Controller
{
    public function index()
    {
        // 1. Iniciamos la consulta filtrando por el tenant actual y cargando la relación con el cliente
        $query = Invoice::where('tenant_id', auth()->user()->tenant_id)->with('client');

        // 2. Aplicamos los filtros dinámicos si existen en la petición (GET)
        if (request('fecha')) {
            $query->whereDate('fecha_emision', request('fecha'));
        }

        if (request('cliente')) {
            $query->where('client_id', request('cliente'));
        }

        if (request('estado')) {
            $query->where('estado', request('estado'));
        }

        // 3. Obtenemos las facturas que coincidan con los filtros aplicados
        $invoices = $query->get();

        // 4. Obtenemos los clientes pertenecientes únicamente a este tenant para llenar el select del filtro
        $clients = Client::where('tenant_id', auth()->user()->tenant_id)->get();

        // 5. Enviamos ambas colecciones de datos a la vista index
        return view('invoices.index', compact('invoices', 'clients'));
    }

    public function create()
    {
        $clients = Client::where('tenant_id', auth()->user()->tenant_id)->get(); // para seleccionar cliente
        return view('invoices.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'fecha_emision' => 'required|date',
            'items.*.descripcion' => 'required',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Crear factura
        $invoice = Invoice::create([
            'tenant_id' => auth()->user()->tenant_id, // temporal
            'client_id' => $request->client_id,
            'fecha_emision' => $request->fecha_emision,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'subtotal' => 0,
            'iva_total' => 0,
            'irpf_total' => 0,
            'total' => 0,
            'estado' => 'borrador',
            'notas' => $request->notas,
        ]);

        // Totales acumulados
        $subtotal = 0;
        $iva_total = 0;
        $irpf_total = 0;

        // Guardar líneas
        foreach ($request->items as $item) {
            $importe_base = $item['cantidad'] * $item['precio_unitario'];
            $importe_iva = $importe_base * ($item['iva_porcentaje'] / 100);
            $importe_irpf = $importe_base * ($item['irpf_porcentaje'] / 100);

            $importe_total = $importe_base + $importe_iva - $importe_irpf;

            $subtotal += $importe_base;
            $iva_total += $importe_iva;
            $irpf_total += $importe_irpf;

            $invoice->items()->create([
                'descripcion' => $item['descripcion'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'iva_porcentaje' => $item['iva_porcentaje'],
                'irpf_porcentaje' => $item['irpf_porcentaje'],
                'importe_total' => $importe_total,
            ]);
        }

        // Actualizar totales de la factura
        $invoice->update([
            'subtotal' => $subtotal,
            'iva_total' => $iva_total,
            'irpf_total' => $irpf_total,
            'total' => $subtotal + $iva_total - $irpf_total,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Factura creada correctamente');
    }

    public function show($id)
    {
        $invoice = Invoice::with('client')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $clients = Client::all();
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        return redirect()->route('invoices.index')->with('success', 'Factura actualizada');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Factura eliminada');
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::with('client', 'items')->findOrFail($id);

        // Cargar tenant real
        $tenant = Tenant::findOrFail($invoice->tenant_id);

        $pdf = PDF::loadView('invoices.pdf', compact('invoice', 'tenant'));

        return $pdf->download('factura_'.$invoice->id.'.pdf');
    }

    public function toggleEstado($id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->estado = $invoice->estado === 'cobrada'
            ? 'emitida'
            : 'cobrada';

        $invoice->save();

        return back()->with('success', 'Estado actualizado'); // Corregido typo 'wirh'
    }

    public function sendEmail($id)
    {
        $invoice = Invoice::findOrFail($id);

        Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));

        return back()->with('success', 'Factura enviada por email');
    }
}
