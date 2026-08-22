<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with professional mock data.
     */
    public function run(): void
    {
        // =========================================================================
        // 1. SUPERADMIN GLOBAL
        // =========================================================================
        $superadmin = User::create([
            'tenant_id' => null,
            'name'      => 'Super Administrador Global',
            'email'     => 'admin@facturasaas.test',
            'password'  => 'password',
            'role'      => 'superadmin',
        ]);

        // =========================================================================
        // 2. TENANT A: "Diseño & Desarrollo Digital SL" (Estimación Directa / IRPF 15%)
        // =========================================================================
        $tenantA = Tenant::create([
            'nombre_comercial'      => 'Diseño & Desarrollo Digital',
            'razon_social'          => 'Diseño & Desarrollo Digital SL',
            'cif_nif'               => 'B87654321',
            'direccion'             => 'Paseo de la Castellana 100, Planta 4',
            'codigo_postal'         => '28046',
            'ciudad'                => 'Madrid',
            'provincia'             => 'Madrid',
            'email'                 => 'contacto@digital.test',
            'telefono'              => '+34 912 345 678',
            'irpf_por_defecto'      => 15.00,
            'serie_factura_default' => 'F2026',
            'estado'                => 'activo',
        ]);

        User::create([
            'tenant_id' => $tenantA->id,
            'name'      => 'Carlos Ruiz (Digital SL)',
            'email'     => 'admin@digital.test',
            'password'  => 'password',
            'role'      => 'admin',
        ]);

        // Clientes Tenant A
        $clientA1 = Client::create([
            'tenant_id'                   => $tenantA->id,
            'nombre_razon_social'         => 'Innovación Tecnológica Ibérica SA',
            'cif_nif'                     => 'A28000001',
            'email'                       => 'facturas@innovacion.test',
            'telefono'                    => '+34 914 112 233',
            'direccion'                   => 'Calle Alcalá 45, 2º Izq',
            'codigo_postal'               => '28014',
            'ciudad'                      => 'Madrid',
            'provincia'                   => 'Madrid',
            'pais'                        => 'ES',
            'aplica_recargo_equivalencia' => false,
        ]);

        $clientA2 = Client::create([
            'tenant_id'                   => $tenantA->id,
            'nombre_razon_social'         => 'Consultores y Asesores García SL',
            'cif_nif'                     => 'B81234567',
            'email'                       => 'admin@consultoresgarcia.test',
            'telefono'                    => '+34 933 445 566',
            'direccion'                   => 'Avinguda Diagonal 200',
            'codigo_postal'               => '08018',
            'ciudad'                      => 'Barcelona',
            'provincia'                   => 'Barcelona',
            'pais'                        => 'ES',
            'aplica_recargo_equivalencia' => false,
        ]);

        $clientA3 = Client::create([
            'tenant_id'                   => $tenantA->id,
            'nombre_razon_social'         => 'María Hernández Sánchez (Autónoma)',
            'cif_nif'                     => '44556677T',
            'email'                       => 'maria.hernandez@freelance.test',
            'telefono'                    => '+34 954 778 899',
            'direccion'                   => 'Calle Sierpes 12',
            'codigo_postal'               => '41004',
            'ciudad'                      => 'Sevilla',
            'provincia'                   => 'Sevilla',
            'pais'                        => 'ES',
            'aplica_recargo_equivalencia' => false,
        ]);

        // Facturas Tenant A:
        // Factura 1 (Borrador)
        $invA1 = Invoice::create([
            'tenant_id'                    => $tenantA->id,
            'client_id'                    => $clientA1->id,
            'serie'                        => 'F2026',
            'numero'                       => 1,
            'numero_completo'              => 'F2026-0001',
            'fecha_emision'                => '2026-01-10',
            'fecha_vencimiento'            => '2026-02-10',
            'estado'                       => 'borrador',
            'base_imponible'               => 1500.00,
            'importe_iva'                  => 315.00,
            'importe_irpf'                 => 225.00,
            'importe_recargo_equivalencia' => 0.00,
            'total'                        => 1590.00,
            'notas'                        => 'Presupuesto de diseño web pendiente de confirmación de hitos.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invA1->id,
            'concepto'           => 'Diseño UX/UI para App Móvil y Prototipado Figma',
            'cantidad'           => 1.00,
            'precio_unitario'    => 1500.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 0.00,
            'importe_base'       => 1500.00,
            'importe_total'      => 1590.00,
        ]);

        // Factura 2 (Borrador)
        $invA2 = Invoice::create([
            'tenant_id'                    => $tenantA->id,
            'client_id'                    => $clientA2->id,
            'serie'                        => 'F2026',
            'numero'                       => 2,
            'numero_completo'              => 'F2026-0002',
            'fecha_emision'                => '2026-01-15',
            'fecha_vencimiento'            => '2026-02-15',
            'estado'                       => 'borrador',
            'base_imponible'               => 800.00,
            'importe_iva'                  => 168.00,
            'importe_irpf'                 => 120.00,
            'importe_recargo_equivalencia' => 0.00,
            'total'                        => 848.00,
            'notas'                        => 'Servicios cloud enero 2026.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invA2->id,
            'concepto'           => 'Mantenimiento Mensual de Servidores e Infraestructura Cloud',
            'cantidad'           => 1.00,
            'precio_unitario'    => 800.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 0.00,
            'importe_base'       => 800.00,
            'importe_total'      => 848.00,
        ]);

        // Factura 3 (Emitida)
        $invA3 = Invoice::create([
            'tenant_id'                    => $tenantA->id,
            'client_id'                    => $clientA1->id,
            'serie'                        => 'F2026',
            'numero'                       => 3,
            'numero_completo'              => 'F2026-0003',
            'fecha_emision'                => '2026-02-01',
            'fecha_vencimiento'            => '2026-03-01',
            'estado'                       => 'emitida',
            'base_imponible'               => 1200.00,
            'importe_iva'                  => 252.00,
            'importe_irpf'                 => 180.00,
            'importe_recargo_equivalencia' => 0.00,
            'total'                        => 1272.00,
            'notas'                        => 'Pago mediante transferencia bancaria a 30 días.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invA3->id,
            'concepto'           => 'Desarrollo Backend API REST Laravel y Webhooks',
            'cantidad'           => 20.00,
            'precio_unitario'    => 60.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 0.00,
            'importe_base'       => 1200.00,
            'importe_total'      => 1272.00,
        ]);

        // Factura 4 (Emitida)
        $invA4 = Invoice::create([
            'tenant_id'                    => $tenantA->id,
            'client_id'                    => $clientA3->id,
            'serie'                        => 'F2026',
            'numero'                       => 4,
            'numero_completo'              => 'F2026-0004',
            'fecha_emision'                => '2026-02-10',
            'fecha_vencimiento'            => '2026-03-10',
            'estado'                       => 'emitida',
            'base_imponible'               => 2000.00,
            'importe_iva'                  => 420.00,
            'importe_irpf'                 => 300.00,
            'importe_recargo_equivalencia' => 0.00,
            'total'                        => 2120.00,
            'notas'                        => 'Auditoría completa de seguridad y cumplimiento normativo.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invA4->id,
            'concepto'           => 'Auditoría de Ciberseguridad y Análisis de Vulnerabilidades Web',
            'cantidad'           => 1.00,
            'precio_unitario'    => 2000.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 0.00,
            'importe_base'       => 2000.00,
            'importe_total'      => 2120.00,
        ]);

        // Factura 5 (Cobrada)
        $invA5 = Invoice::create([
            'tenant_id'                    => $tenantA->id,
            'client_id'                    => $clientA2->id,
            'serie'                        => 'F2026',
            'numero'                       => 5,
            'numero_completo'              => 'F2026-0005',
            'fecha_emision'                => '2026-02-15',
            'fecha_vencimiento'            => '2026-03-15',
            'estado'                       => 'cobrada',
            'base_imponible'               => 900.00,
            'importe_iva'                  => 189.00,
            'importe_irpf'                 => 135.00,
            'importe_recargo_equivalencia' => 0.00,
            'total'                        => 954.00,
            'notas'                        => 'Cobrada el 16/02/2026 mediante domiciliación bancaria SEPA.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invA5->id,
            'concepto'           => 'Consultoría Estratégica de Arquitectura de Microservicios',
            'cantidad'           => 10.00,
            'precio_unitario'    => 90.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 0.00,
            'importe_base'       => 900.00,
            'importe_total'      => 954.00,
        ]);

        // 1 Factura Rectificativa en Tenant A (vinculada a Factura 4)
        $invARect = Invoice::create([
            'tenant_id'                    => $tenantA->id,
            'client_id'                    => $clientA3->id,
            'serie'                        => 'R2026',
            'numero'                       => 1,
            'numero_completo'              => 'R2026-0001',
            'fecha_emision'                => '2026-02-18',
            'fecha_vencimiento'            => '2026-03-18',
            'estado'                       => 'emitida',
            'base_imponible'               => -500.00,
            'importe_iva'                  => -105.00,
            'importe_irpf'                 => -75.00,
            'importe_recargo_equivalencia' => 0.00,
            'total'                        => -530.00,
            'is_rectificativa'             => true,
            'factura_rectificada_id'       => $invA4->id,
            'motivo_rectificacion'         => 'Abono por descuento comercial por volumen acordado con el cliente tras la auditoría inicial.',
            'notas'                        => 'Factura rectificativa sobre F2026-0004.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invARect->id,
            'concepto'           => 'Abono / Rectificación descuento comercial sobre Factura F2026-0004',
            'cantidad'           => 1.00,
            'precio_unitario'    => -500.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 0.00,
            'importe_base'       => -500.00,
            'importe_total'      => -530.00,
        ]);

        // =========================================================================
        // 3. TENANT B: "Comercio Minorista Gómez" (Recargo de Equivalencia)
        // =========================================================================
        $tenantB = Tenant::create([
            'nombre_comercial'      => 'Boutique Gómez',
            'razon_social'          => 'Antonio Gómez Pérez',
            'cif_nif'               => '77889900K',
            'direccion'             => 'Calle Colón 34',
            'codigo_postal'         => '46004',
            'ciudad'                => 'Valencia',
            'provincia'             => 'Valencia',
            'email'                 => 'contacto@gomez.test',
            'telefono'              => '+34 963 111 222',
            'irpf_por_defecto'      => 0.00,
            'serie_factura_default' => 'C2026',
            'estado'                => 'activo',
        ]);

        User::create([
            'tenant_id' => $tenantB->id,
            'name'      => 'Antonio Gómez (Comercio Gómez)',
            'email'     => 'admin@gomez.test',
            'password'  => 'password',
            'role'      => 'admin',
        ]);

        // Clientes Tenant B
        $clientB1 = Client::create([
            'tenant_id'                   => $tenantB->id,
            'nombre_razon_social'         => 'Textiles del Turia SL',
            'cif_nif'                     => 'B46123456',
            'email'                       => 'pedidos@textilesturia.test',
            'telefono'                    => '+34 961 889 900',
            'direccion'                   => 'Polígono Industrial Fuente del Jarro, Nave 14',
            'codigo_postal'               => '46988',
            'ciudad'                      => 'Paterna',
            'provincia'                   => 'Valencia',
            'pais'                        => 'ES',
            'aplica_recargo_equivalencia' => true,
        ]);

        $clientB2 = Client::create([
            'tenant_id'                   => $tenantB->id,
            'nombre_razon_social'         => 'Modas y Confecciones Levante CB',
            'cif_nif'                     => 'E98765432',
            'email'                       => 'info@modaslevante.test',
            'telefono'                    => '+34 965 223 344',
            'direccion'                   => 'Avenida de Aguilera 80',
            'codigo_postal'               => '03006',
            'ciudad'                      => 'Alicante',
            'provincia'                   => 'Alicante',
            'pais'                        => 'ES',
            'aplica_recargo_equivalencia' => true,
        ]);

        // Facturas Tenant B:
        // Factura B1 (Emitida con Recargo de Equivalencia 5.2%)
        $invB1 = Invoice::create([
            'tenant_id'                    => $tenantB->id,
            'client_id'                    => $clientB1->id,
            'serie'                        => 'C2026',
            'numero'                       => 1,
            'numero_completo'              => 'C2026-0001',
            'fecha_emision'                => '2026-02-05',
            'fecha_vencimiento'            => '2026-03-05',
            'estado'                       => 'emitida',
            'base_imponible'               => 1000.00,
            'importe_iva'                  => 210.00,
            'importe_irpf'                 => 0.00,
            'importe_recargo_equivalencia' => 52.00, // 5.2%
            'total'                        => 1262.00,
            'notas'                        => 'Factura bajo régimen especial de Recargo de Equivalencia.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invB1->id,
            'concepto'           => 'Lote Tejidos de Algodón Orgánico y Lino',
            'cantidad'           => 50.00,
            'precio_unitario'    => 20.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 5.20,
            'importe_base'       => 1000.00,
            'importe_total'      => 1262.00,
        ]);

        // Factura B2 (Cobrada)
        $invB2 = Invoice::create([
            'tenant_id'                    => $tenantB->id,
            'client_id'                    => $clientB2->id,
            'serie'                        => 'C2026',
            'numero'                       => 2,
            'numero_completo'              => 'C2026-0002',
            'fecha_emision'                => '2026-02-12',
            'fecha_vencimiento'            => '2026-03-12',
            'estado'                       => 'cobrada',
            'base_imponible'               => 500.00,
            'importe_iva'                  => 105.00,
            'importe_irpf'                 => 0.00,
            'importe_recargo_equivalencia' => 26.00, // 5.2%
            'total'                        => 631.00,
            'notas'                        => 'Cobro recibido por TPV virtual.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invB2->id,
            'concepto'           => 'Suministro de Accesorios y Botonería de Alta Gama',
            'cantidad'           => 100.00,
            'precio_unitario'    => 5.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 5.20,
            'importe_base'       => 500.00,
            'importe_total'      => 631.00,
        ]);

        // Factura B3 (Borrador)
        $invB3 = Invoice::create([
            'tenant_id'                    => $tenantB->id,
            'client_id'                    => $clientB1->id,
            'serie'                        => 'C2026',
            'numero'                       => 3,
            'numero_completo'              => 'C2026-0003',
            'fecha_emision'                => '2026-02-20',
            'fecha_vencimiento'            => '2026-03-20',
            'estado'                       => 'borrador',
            'base_imponible'               => 350.00,
            'importe_iva'                  => 73.50,
            'importe_irpf'                 => 0.00,
            'importe_recargo_equivalencia' => 18.20, // 5.2%
            'total'                        => 441.70,
            'notas'                        => 'Presupuesto de prendas de muestra.',
        ]);
        InvoiceItem::create([
            'invoice_id'         => $invB3->id,
            'concepto'           => 'Prendas de Muestra Temporada Verano 2026',
            'cantidad'           => 10.00,
            'precio_unitario'    => 35.00,
            'iva_porcentaje'     => 21.00,
            'recargo_porcentaje' => 5.20,
            'importe_base'       => 350.00,
            'importe_total'      => 441.70,
        ]);
    }
}
