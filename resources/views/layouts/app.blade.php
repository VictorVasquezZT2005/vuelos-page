<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title','Aerolínea')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <i class="fas fa-plane-departure"></i> Aerolínea
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if(auth()->check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('vuelos.index') }}"><i class="fas fa-plane"></i> Vuelos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservaciones.index') }}"><i class="fas fa-ticket-alt"></i> Mis Reservaciones</a></li>

                    <!-- Dropdown de usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ auth()->user()->nombre ?? auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main class="container my-5">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
