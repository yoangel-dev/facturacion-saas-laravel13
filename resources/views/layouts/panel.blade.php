<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('panel.dashboard') }}">
                Facturación SaaS
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                {{-- Menú izquierdo --}}
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('invoices.index') }}">Facturas</a>
                    </li>

                    {{-- Opciones del SUPERADMIN --}}
                    @if(auth()->user()->is_superadmin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Superadmin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.tenants.index') }}">Tenants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios</a>
                        </li>
                    @endif
                </ul>

                {{-- Botón de cerrar sesión (derecha) --}}
                <div class="d-flex">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>