<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {
            // 1. Crear el Tenant inicial para el nuevo usuario
            $tenant = Tenant::create([
                'nombre_comercial'      => $request->name,
                'razon_social'          => $request->name,
                'cif_nif'               => 'ES00000000X',
                'email'                 => $request->email,
                'irpf_por_defecto'      => 15.00,
                'serie_factura_default' => 'F' . date('Y'),
                'estado'                => 'activo',
            ]);

            // 2. Crear el Usuario asignando tenant_id y rol admin
            // Dado que el modelo User tiene 'password' => 'hashed', pasamos la contraseña en plano para evitar doble hashing
            return User::create([
                'tenant_id' => $tenant->id,
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password,
                'role'      => 'admin',
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('panel.dashboard', absolute: false));
    }
}
