<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('tenant')->latest()->paginate(20);
        
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
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'tenant_id' => 'nullable|exists:tenants,id',
            'role'      => 'required',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'tenant_id'     => $request->tenant_id,
            'role'          => $request->role,
            'is_superadmin' => $request->boolean('is_superadmin'),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado');
    }

    public function edit(User $user)
    {
        $tenants = Tenant::all();
        
        return view('admin.users.edit', compact('user', 'tenants'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'tenant_id' => 'nullable|exists:tenants,id',
            'role'      => 'required',
        ]);

        $data = $request->only('name', 'email', 'tenant_id', 'role');
        $data['is_superadmin'] = $request->boolean('is_superadmin');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado');
    }
}
