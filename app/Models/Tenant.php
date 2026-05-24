<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    public function toggle($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->activo = !$tenant->activo;
        $tenant->save();

        return back()->with('success', 'Estado del tenant actualizado');
    }

    protected $fillable = [
        'nombre',
        'tipo',
        'plan',
        'activo',
        'limite_facturas'
    ];
}
