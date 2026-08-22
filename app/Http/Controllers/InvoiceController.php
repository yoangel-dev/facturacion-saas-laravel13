<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Services\InvoiceNumberService;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceNumberService $numberService
    ) {}

    public function index(Request $request)
    {
        // El GlobalScope de BelongsToTenant filtra automáticamente las facturas del tenant autenticado
        $query = Invoice::with(['client', 'items'])->latest('fecha_emision');

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_emision', $request->fecha);
        }

        if ($request->filled('cliente')) {
            $query->where('client_id', $request->cliente);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $invoices = $query->paginate(20)->withQueryString();
        $clients = Client::orderBy('nombre_razon_social')->get();

        return view('invoices.index', compact('invoices', 'clients'));
    }

    public function create()
    {
        $clients = Client::orderBy('nombre_razon_social')->get();
        $tenant = auth()->user()->tenant;

        return view('invoices.create', compact('clients', 'tenant'));
    }

    public function store(Request $request)
    {
        $tenant = auth()->user()->tenant;

        $request->validate([
            'client_id'                  => 'required|exists:clients,id',
            'fecha_emision'              => 'required|date',
            'fecha_vencimiento'          => 'nullable|date|after_or_equal:fecha_emision',
            'serie'                      => 'nullable|string|max:10',
            'estado'                     => 'required|in:borrador,emitida',
            'irpf_porcentaje'            => 'nullable|numeric|min:0|max:100',
            'items'                      => 'required|array|min:1',
            'items.*.concepto'           => 'required|string|max:500',
            'items.*.cantidad'           => 'required|numeric|min:0.01',
            'items.*.precio_unitario'    => 'required|numeric',
            'items.*.iva_porcentaje'     => 'required|numeric|in:21,10,4,0',
            'items.*.recargo_porcentaje' => 'nullable|numeric|min:0',
            'notas'                      => 'nullable|string|max:2000',
        ]);

        $serie = strtoupper(trim($request->input('serie') ?: ($tenant->serie_factura_default ?? 'F' . date('Y'))));
        $client = Client::findOrFail($request->client_id);
        $irpfPct = (float) ($request->input('irpf_porcentaje', $tenant->irpf_por_defecto ?? 15.00));

        $invoice = DB::transaction(function () use ($request, $tenant, $client, $serie, $irpfPct) {
            // 1. Generar numeración correlativa segura con bloqueo pesimista
            $numberData = $this->numberService->generarSiguienteNumero($tenant, $serie);

            // 2. Cálculos de bases e impuestos con redondeo fiscal de 2 decimales
            $baseImponibleTotal = 0;
            $ivaTotal = 0;
            $recargoTotal = 0;
            $processedItems = [];

            foreach ($request->items as $item) {
                $cantidad = (float) $item['cantidad'];
                $precioUnitario = (float) $item['precio_unitario'];
                $ivaPct = (float) $item['iva_porcentaje'];
                $recargoPct = $client->aplica_recargo_equivalencia
                    ? (float) ($item['recargo_porcentaje'] ?? 0)
                    : 0;

                $importeBase = round($cantidad * $precioUnitario, 2);
                $importeIvaLinea = round($importeBase * ($ivaPct / 100), 2);
                $importeRecargoLinea = round($importeBase * ($recargoPct / 100), 2);
                $importeTotalLinea = $importeBase + $importeIvaLinea + $importeRecargoLinea;

                $baseImponibleTotal += $importeBase;
                $ivaTotal += $importeIvaLinea;
                $recargoTotal += $importeRecargoLinea;

                $processedItems[] = [
                    'concepto'           => $item['concepto'],
                    'cantidad'           => $cantidad,
                    'precio_unitario'    => $precioUnitario,
                    'iva_porcentaje'     => $ivaPct,
                    'recargo_porcentaje' => $recargoPct,
                    'importe_base'       => $importeBase,
                    'importe_total'      => $importeTotalLinea,
                ];
            }

            // IRPF calculado sobre la base imponible total
            $importeIrpfTotal = round($baseImponibleTotal * ($irpfPct / 100), 2);
            $granTotal = round($baseImponibleTotal + $ivaTotal + $recargoTotal - $importeIrpfTotal, 2);

            // 3. Crear factura con snapshot fiscal inmutable
            $invoice = Invoice::create([
                'tenant_id'                    => $tenant->id,
                'client_id'                    => $client->id,
                'client_snapshot'              => [
                    'nombre_razon_social' => $client->nombre_razon_social,
                    'cif_nif'             => $client->cif_nif,
                    'direccion'           => $client->direccion,
                    'codigo_postal'       => $client->codigo_postal,
                    'ciudad'              => $client->ciudad,
                    'provincia'           => $client->provincia,
                    'pais'                => $client->pais,
                ],
                'serie'                        => $serie,
                'numero'                       => $numberData['numero'],
                'numero_completo'              => $numberData['numero_completo'],
                'fecha_emision'                => $request->fecha_emision,
                'fecha_vencimiento'            => $request->fecha_vencimiento,
                'estado'                       => $request->estado,
                'base_imponible'               => $baseImponibleTotal,
                'importe_iva'                  => $ivaTotal,
                'importe_irpf'                 => $importeIrpfTotal,
                'importe_recargo_equivalencia' => $recargoTotal,
                'total'                        => $granTotal,
                'notas'                        => $request->notas,
            ]);

            // 4. Guardar líneas de factura
            foreach ($processedItems as $pItem) {
                $invoice->items()->create($pItem);
            }

            return $invoice;
        });

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', "Factura {$invoice->numero_completo} creada correctamente.");
    }

    public function show($id)
    {
        $invoice = Invoice::with(['client', 'items', 'facturaRectificada', 'facturasRectificativas'])->findOrFail($id);
        $tenant = auth()->user()->tenant;

        return view('invoices.show', compact('invoice', 'tenant'));
    }

    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        if ($invoice->estado !== 'borrador') {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'Por normativa fiscal, solo se pueden editar facturas en estado borrador. Las facturas emitidas o cobradas son inmutables.');
        }

        $clients = Client::orderBy('nombre_razon_social')->get();
        $tenant = auth()->user()->tenant;

        return view('invoices.edit', compact('invoice', 'clients', 'tenant'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        if ($invoice->estado !== 'borrador') {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'Por normativa fiscal, solo se pueden modificar facturas en estado borrador.');
        }

        $tenant = auth()->user()->tenant;

        $request->validate([
            'client_id'                  => 'required|exists:clients,id',
            'fecha_emision'              => 'required|date',
            'fecha_vencimiento'          => 'nullable|date|after_or_equal:fecha_emision',
            'estado'                     => 'required|in:borrador,emitida',
            'irpf_porcentaje'            => 'nullable|numeric|min:0|max:100',
            'items'                      => 'required|array|min:1',
            'items.*.concepto'           => 'required|string|max:500',
            'items.*.cantidad'           => 'required|numeric|min:0.01',
            'items.*.precio_unitario'    => 'required|numeric',
            'items.*.iva_porcentaje'     => 'required|numeric|in:21,10,4,0',
            'items.*.recargo_porcentaje' => 'nullable|numeric|min:0',
            'notas'                      => 'nullable|string|max:2000',
        ]);

        $client = Client::findOrFail($request->client_id);
        $irpfPct = (float) ($request->input('irpf_porcentaje', $tenant->irpf_por_defecto ?? 15.00));

        DB::transaction(function () use ($request, $invoice, $client, $irpfPct) {
            $baseImponibleTotal = 0;
            $ivaTotal = 0;
            $recargoTotal = 0;
            $processedItems = [];

            foreach ($request->items as $item) {
                $cantidad = (float) $item['cantidad'];
                $precioUnitario = (float) $item['precio_unitario'];
                $ivaPct = (float) $item['iva_porcentaje'];
                $recargoPct = $client->aplica_recargo_equivalencia
                    ? (float) ($item['recargo_porcentaje'] ?? 0)
                    : 0;

                $importeBase = round($cantidad * $precioUnitario, 2);
                $importeIvaLinea = round($importeBase * ($ivaPct / 100), 2);
                $importeRecargoLinea = round($importeBase * ($recargoPct / 100), 2);
                $importeTotalLinea = $importeBase + $importeIvaLinea + $importeRecargoLinea;

                $baseImponibleTotal += $importeBase;
                $ivaTotal += $importeIvaLinea;
                $recargoTotal += $importeRecargoLinea;

                $processedItems[] = [
                    'concepto'           => $item['concepto'],
                    'cantidad'           => $cantidad,
                    'precio_unitario'    => $precioUnitario,
                    'iva_porcentaje'     => $ivaPct,
                    'recargo_porcentaje' => $recargoPct,
                    'importe_base'       => $importeBase,
                    'importe_total'      => $importeTotalLinea,
                ];
            }

            $importeIrpfTotal = round($baseImponibleTotal * ($irpfPct / 100), 2);
            $granTotal = round($baseImponibleTotal + $ivaTotal + $recargoTotal - $importeIrpfTotal, 2);

            $invoice->update([
                'client_id'                    => $client->id,
                'client_snapshot'              => [
                    'nombre_razon_social' => $client->nombre_razon_social,
                    'cif_nif'             => $client->cif_nif,
                    'direccion'           => $client->direccion,
                    'codigo_postal'       => $client->codigo_postal,
                    'ciudad'              => $client->ciudad,
                    'provincia'           => $client->provincia,
                    'pais'                => $client->pais,
                ],
                'fecha_emision'                => $request->fecha_emision,
                'fecha_vencimiento'            => $request->fecha_vencimiento,
                'estado'                       => $request->estado,
                'base_imponible'               => $baseImponibleTotal,
                'importe_iva'                  => $ivaTotal,
                'importe_irpf'                 => $importeIrpfTotal,
                'importe_recargo_equivalencia' => $recargoTotal,
                'total'                        => $granTotal,
                'notas'                        => $request->notas,
            ]);

            // Actualizar líneas reemplazándolas en la base de datos
            $invoice->items()->delete();
            foreach ($processedItems as $pItem) {
                $invoice->items()->create($pItem);
            }
        });

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', "Factura borrador {$invoice->numero_completo} actualizada correctamente.");
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        try {
            $invoice->delete();
            return redirect()->route('invoices.index')->with('success', 'Factura borrador eliminada correctamente.');
        } catch (DomainException $e) {
            return redirect()->route('invoices.index')->with('error', $e->getMessage());
        }
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::with(['client', 'items', 'facturaRectificada'])->findOrFail($id);
        $tenant = $invoice->tenant;

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice', 'tenant'));

        return $pdf->download('factura_' . $invoice->numero_completo . '.pdf');
    }

    public function toggleEstado($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->estado === 'borrador') {
            $invoice->estado = 'emitida';
        } elseif ($invoice->estado === 'emitida') {
            $invoice->estado = 'cobrada';
        } elseif ($invoice->estado === 'cobrada') {
            $invoice->estado = 'emitida';
        }

        $invoice->save();

        return back()->with('success', 'Estado de la factura actualizado.');
    }

    public function sendEmail($id)
    {
        $invoice = Invoice::with(['client', 'items'])->findOrFail($id);

        $clientEmail = $invoice->client_snapshot['email'] ?? $invoice->client->email;

        if (empty($clientEmail)) {
            return back()->with('error', 'El cliente no tiene una dirección de email configurada.');
        }

        Mail::to($clientEmail)->send(new InvoiceMail($invoice));

        return back()->with('success', "Factura enviada por email a {$clientEmail}.");
    }
}
