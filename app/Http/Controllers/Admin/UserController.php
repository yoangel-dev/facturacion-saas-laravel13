<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('tenant')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return view('admin.users.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'tenant_id' => 'required|exists:tenants,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tenant_id' => $request->tenant_id,
            'is_admin' => $request->is_admin ? 1 : 0,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente');
    }
}
