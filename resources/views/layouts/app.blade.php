<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Aerolínea SkyWings')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #0d47a1;
            --accent-color: #ff6d00;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --gradient-accent: linear-gradient(135deg, var(--accent-color), #ff9100);
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 24px rgba(0, 0, 0, 0.12);
            --border-radius: 12px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        /* Navbar mejorado */
        .navbar {
            background: var(--gradient-primary) !important;
            box-shadow: var(--shadow-medium);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: translateY(-2px);
        }
        
        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.6rem;
            color: white;
        }
        
        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.9) !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-nav .nav-link i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            color: white !important;
        }
        
        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            padding: 0.5rem;
            margin-top: 10px;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: rgba(26, 115, 232, 0.1);
        }
        
        .btn-logout {
            background: var(--gradient-accent);
            border: none;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 109, 0, 0.3);
        }
        
        /* Main content */
        main {
            min-height: calc(100vh - 180px);
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 2.5rem 0 1.5rem;
            margin-top: 3rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
            margin-right: 1.5rem;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        /* Tarjetas mejoradas */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }
        
        .card-header {
            background: var(--gradient-primary);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        /* Botones mejorados */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(26, 115, 232, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(26, 115, 232, 0.3);
        }
        
        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .navbar-nav .nav-link {
                margin: 0.2rem 0;
            }
        }
        .plane-animation {
    position: relative;
    height: 60px; /* Un poco más de altura para el efecto */
    overflow: hidden;
    border-radius: 8px;
    margin-bottom: 15px;
    /* Fondo de cielo un poco más vivo */
    background: linear-gradient(to bottom, #87CEEB, #B0E0E6);
}

/* Estilo y animación para el avión */
.plane-animation .fa-plane {
    position: absolute;
    top: 50%;
    font-size: 24px;
    color: #333;
    /* Animación del vuelo */
    animation: fly-and-dip 5s infinite linear;
    z-index: 10; /* Asegura que el avión esté sobre las nubes */
}

/* Nueva animación de vuelo con subidas y bajadas */
@keyframes fly-and-dip {
    0% {
        left: -10%;
        transform: translateY(-50%) rotate(-10deg); /* Ligeramente inclinado hacia arriba */
    }
    50% {
        transform: translateY(0%) rotate(5deg); /* Baja un poco y se inclina */
    }
    100% {
        left: 110%;
        transform: translateY(-50%) rotate(-10deg); /* Vuelve a subir al final */
    }
}

/* Estilos para las nubes */
.cloud {
    position: absolute;
    background: #fff;
    border-radius: 50%;
    opacity: 0.8;
    z-index: 1; /* Detrás del avión */
}

/* Creamos formas de nubes combinando círculos */
.cloud:before, .cloud:after {
    content: '';
    position: absolute;
    background: #fff;
    border-radius: 50%;
}

.cloud-1 { width: 40px; height: 40px; top: 20%; }
.cloud-1:before { width: 25px; height: 25px; top: -15px; left: 5px; }
.cloud-1:after { width: 30px; height: 30px; top: -5px; right: -10px; }

.cloud-2 { width: 60px; height: 60px; top: 40%; }
.cloud-2:before { width: 35px; height: 35px; top: -25px; left: 10px; }
.cloud-2:after { width: 40px; height: 40px; top: -10px; right: -15px; }

/* Animación para que las nubes se muevan */
.drift-fast {
    animation: drift 8s infinite linear; /* Nube más rápida */
}

.drift-slow {
    animation: drift 12s infinite linear; /* Nube más lenta */
}

@keyframes drift {
    from {
        left: -20%;
    }
    to {
        left: 120%;
    }
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <i class="fas fa-plane-departure"></i> SkyWings
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vuelos.index') }}">
                            <i class="fas fa-plane"></i> Vuelos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reservaciones.index') }}">
                            <i class="fas fa-ticket-alt"></i> Mis Reservaciones
                        </a>
                    </li>

                    <!-- Dropdown de usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->nombre ?? auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-2 py-1">
                                    @csrf
                                    <button type="submit" class="btn btn-logout w-100">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i> Registrarse
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4 fade-in">
    @yield('content')
</main>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">
                    <i class="fas fa-plane-departure me-2"></i> SkyWings Airlines
                </h5>
                <p class="mb-4">Tu compañía de confianza para viajar por el mundo. Ofreciendo los mejores precios y servicios desde 1995.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <h5 class="mb-3">Enlaces Rápidos</h5>
                <div class="footer-links d-flex flex-column">
                    <a href="{{ route('welcome') }}">Inicio</a>
                    <a href="{{ route('vuelos.index') }}">Vuelos</a>
                    <a href="#">Destinos</a>
                    <a href="#">Ofertas</a>
                </div>
            </div>
            <div class="col-md-3">
                <h5 class="mb-3">Contacto</h5>
                <p><i class="fas fa-phone me-2"></i> +1 (800) 123-4567</p>
                <p><i class="fas fa-envelope me-2"></i> info@skywings.com</p>
                <p><i class="fas fa-map-marker-alt me-2"></i> Av. Principal 123, Ciudad</p>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
        <div class="text-center">
            <p class="mb-0">&copy; 2023 SkyWings Airlines. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Agregar clase activa al enlace actual
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.href;
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        
        navLinks.forEach(link => {
            if (link.href === currentUrl) {
                link.classList.add('active');
            }
        });
        
        // Efecto de animación al hacer scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '0.5rem 0';
                navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.padding = '0.8rem 0';
                navbar.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.12)';
            }
        });
    });
</script>
</body>
</html>