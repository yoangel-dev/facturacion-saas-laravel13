@extends('layouts.panel')

@section('title', 'Usuarios')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Usuarios</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Nuevo Usuario</a>
</div>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Tenant</th>
            <th>Superadmin</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>

            <td>{{ $user->tenant->nombre ?? '—' }}</td>

            <td>
                @if($user->is_superadmin)
                    <span class="badge bg-danger">Sí</span>
                @else
                    <span class="badge bg-secondary">No</span>
                @endif
            </td>

            <td>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>

                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar usuario?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}

@endsection