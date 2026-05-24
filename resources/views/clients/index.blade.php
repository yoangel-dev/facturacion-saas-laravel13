@extends('layouts.panel')

@section('title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Clientes</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Nuevo cliente</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th style="width: 180px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->nombre }}</td>
                    <td>{{ $client->email }}</td>
                    <td>
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-sm btn-info">
                         Ver
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" 
                            method="POST" 
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" 
                                    class="btn btn-sm btn-outline-danger"
                                    title="Eliminar cliente"
                                    onclick="return confirm('¿Seguro que quieres eliminar este cliente?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
