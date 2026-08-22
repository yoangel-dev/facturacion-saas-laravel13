<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

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
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'tenant_id' => 'nullable|exists:tenants,id',
            'role'      => 'required|in:superadmin,admin,user',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password, // 'password' => 'hashed' en User casts
            'tenant_id' => $request->role === 'superadmin' ? null : $request->tenant_id,
            'role'      => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        $tenants = Tenant::all();
        return view('admin.users.edit', compact('user', 'tenants'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'tenant_id' => 'nullable|exists:tenants,id',
            'role'      => 'required|in:superadmin,admin,user',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'tenant_id' => $request->role === 'superadmin' ? null : $request->tenant_id,
            'role'      => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado');
    }
}
