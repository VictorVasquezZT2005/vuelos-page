@extends('layouts.app')

{{-- Seccion para estilos CSS personalizados --}}
@push('styles')
<style>
    /* --- Mejoras Generales --- */
    body {
        font-family: 'Inter', sans-serif; /* Una fuente más moderna, asegúrate de importarla si la usas */
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 700;
    }

    /* --- HERO --- */
    .hero {
        position: relative;
        color: white;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
    }
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4); /* Overlay oscuro para mejorar legibilidad */
        z-index: 1;
    }
    .hero > div {
        position: relative;
        z-index: 2;
    }
    .hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
    }

    /* --- TARJETAS DE DESTINOS --- */
    .card-destination {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-destination:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 1.5rem rgba(0,0,0,0.1) !important;
    }

    /* --- SECCIÓN DE SERVICIOS --- */
    .service-icon {
        width: 70px;
        height: 70px;
        background-color: #0d6efd;
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }
    .service-item:hover .service-icon {
        background-color: #0b5ed7;
    }

    /* --- CÓMO RESERVAR (PROCESO) --- */
    .booking-process .step {
        position: relative;
    }
    .booking-process .step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 25px; /* Alineado verticalmente con el icono */
        left: 50%;
        width: 100%;
        height: 2px;
        background-color: #0d6efd;
        transform: translateX(50%);
        z-index: -1;
    }
    @media (max-width: 767px) {
        .booking-process .step:not(:last-child)::after {
            display: none; /* Ocultar línea en móviles */
        }
    }

    /* --- TESTIMONIOS --- */
    .testimonial-card {
        border-left: 5px solid #0d6efd;
        background-color: #fff;
    }
    .testimonial-card p {
        font-style: italic;
    }

    /* --- ANIMACIONES DE SCROLL --- */
    .fade-in-section {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-in-section.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush


@section('content')
<header class="hero" style="background: url('https://images.unsplash.com/photo-1504198453319-5ce911bafcde?auto=format&fit=crop&w=1950&q=80') no-repeat center center; background-size: cover; height: 70vh; display: flex; align-items: center; justify-content: center; text-align: center;">
    <div>
        <h1 class="display-3">Vuela Con Confianza</h1>
        <p class="lead">Descubre nuevos destinos y vive experiencias inolvidables con nosotros.</p>
        <a href="/vuelos" class="btn btn-primary btn-lg mt-3 fw-bold">Ver Destinos</a>
    </div>
</header>

<section id="destinos" class="container my-5 py-5 fade-in-section">
    <h2 class="text-center mb-5">Destinos Populares</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-destination shadow-sm h-100">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Playa">
                <div class="card-body">
                    <h5 class="card-title">Playas del Caribe</h5>
                    <p class="card-text">Relájate y disfruta del sol, arena y mar en los destinos más paradisíacos.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-destination shadow-sm h-100">
                <img src="https://images.unsplash.com/photo-1483683804023-6ccdb62f86ef?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Montaña">
                <div class="card-body">
                    <h5 class="card-title">Montañas y Naturaleza</h5>
                    <p class="card-text">Vuela a lugares donde la naturaleza y la aventura son protagonistas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-destination shadow-sm h-100">
                <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Ciudad">
                <div class="card-body">
                    <h5 class="card-title">Ciudades Cosmopolitas</h5>
                    <p class="card-text">Explora cultura, gastronomía y vida urbana en tus vuelos.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="servicios" class="bg-light py-5 fade-in-section">
    <div class="container">
        <h2 class="text-center mb-5">Nuestros Servicios</h2>
        <div class="row text-center g-4">
            <div class="col-md-3 service-item">
                <div class="service-icon mb-3"><i class="fas fa-plane fa-2x"></i></div>
                <h5 class="mt-2">Vuelos Seguros</h5>
                <p>Garantizamos seguridad y comodidad en cada viaje.</p>
            </div>
            <div class="col-md-3 service-item">
                <div class="service-icon mb-3"><i class="fas fa-utensils fa-2x"></i></div>
                <h5 class="mt-2">Comida a Bordo</h5>
                <p>Disfruta de menús variados durante tu vuelo.</p>
            </div>
            <div class="col-md-3 service-item">
                <div class="service-icon mb-3"><i class="fas fa-headset fa-2x"></i></div>
                <h5 class="mt-2">Atención 24/7</h5>
                <p>Nuestro equipo siempre listo para ayudarte.</p>
            </div>
            <div class="col-md-3 service-item">
                <div class="service-icon mb-3"><i class="fas fa-ticket-alt fa-2x"></i></div>
                <h5 class="mt-2">Reservas Fáciles</h5>
                <p>Compra tus boletos de manera rápida y segura.</p>
            </div>
        </div>
    </div>
</section>

<section id="reserva" class="container my-5 py-5 fade-in-section">
    <h2 class="text-center mb-5">Reservar es Muy Fácil</h2>
    <div class="row g-4 booking-process">
        <div class="col-md-3 text-center step">
            <div class="service-icon mb-3"><i class="fas fa-user-plus fa-2x"></i></div>
            <h5>1. Registrarse</h5>
            <p>Crea tu cuenta para comenzar a reservar vuelos.</p>
        </div>
        <div class="col-md-3 text-center step">
            <div class="service-icon mb-3"><i class="fas fa-plane-departure fa-2x"></i></div>
            <h5>2. Elegir Vuelo</h5>
            <p>Explora los vuelos disponibles y selecciona tu destino.</p>
        </div>
        <div class="col-md-3 text-center step">
            <div class="service-icon mb-3"><i class="fas fa-ticket-alt fa-2x"></i></div>
            <h5>3. Reservar</h5>
            <p>Confirma tu vuelo y obtén tu boleto digital.</p>
        </div>
        <div class="col-md-3 text-center step">
            <div class="service-icon mb-3"><i class="fas fa-smile fa-2x"></i></div>
            <h5>4. Disfrutar</h5>
            <p>Vuela con seguridad y comodidad a tu destino soñado.</p>
        </div>
    </div>
</section>

<section id="testimonios" class="bg-light py-5 fade-in-section">
    <div class="container">
        <h2 class="text-center mb-5">Qué Dicen Nuestros Clientes</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card testimonial-card p-4 shadow-sm h-100">
                    <p class="mb-3">"Excelente servicio, muy puntual y la tripulación amable. Una experiencia de primera clase."</p>
                    <h6 class="fw-bold mb-0">- Ana G.</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card testimonial-card p-4 shadow-sm h-100">
                    <p class="mb-3">"La experiencia de vuelo fue increíble, desde la compra del boleto hasta el aterrizaje. Volveré a reservar seguro."</p>
                    <h6 class="fw-bold mb-0">- Carlos M.</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card testimonial-card p-4 shadow-sm h-100">
                    <p class="mb-3">"Muy recomendable para viajes familiares y de negocios. El proceso es simple y el servicio al cliente es excepcional."</p>
                    <h6 class="fw-bold mb-0">- Laura P.</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contacto" class="container my-5 py-5 fade-in-section">
    <h2 class="text-center mb-4">Contáctanos</h2>
    <p class="text-center text-muted mb-5">¿Tienes alguna pregunta? Envíanos un mensaje y te responderemos pronto.</p>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card p-4 shadow-sm">
                <form action="{{ route('contacto.send') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary fw-bold w-100 btn-lg"><i class="fas fa-paper-plane me-2"></i> Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

{{-- Seccion para scripts JS personalizados --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll('.fade-in-section');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Opcional: deja de observar una vez que es visible
                // observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 // La animación se dispara cuando el 10% del elemento es visible
    });

    sections.forEach(section => {
        observer.observe(section);
    });
});
</script>
@endpush