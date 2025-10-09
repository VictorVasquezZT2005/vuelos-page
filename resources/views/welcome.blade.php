@extends('layouts.app')

@section('content')
<!-- HERO -->
<header class="hero" style="background: url('https://images.unsplash.com/photo-1504198453319-5ce911bafcde?auto=format&fit=crop&w=1950&q=80') no-repeat center center; background-size: cover; height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center;"> <div> <h1>Vuela Con Confianza</h1> <p>Descubre nuevos destinos y vive experiencias inolvidables con Aerolínea</p> <a href="{{ route('login') }}" class="btn btn-lg btn-primary mt-3"><i class="fas fa-ticket-alt"></i> Iniciar Sesión</a> </div> </header>

<!-- DESTINOS -->
<section id="destinos" class="container my-5">
    <h2 class="text-center mb-4">Destinos Populares</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Playa">
                <div class="card-body">
                    <h5 class="card-title">Playas del Caribe</h5>
                    <p class="card-text">Relájate y disfruta del sol, arena y mar en los destinos más paradisíacos.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="https://images.unsplash.com/photo-1483683804023-6ccdb62f86ef?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Montaña">
                <div class="card-body">
                    <h5 class="card-title">Montañas y Naturaleza</h5>
                    <p class="card-text">Vuela a lugares donde la naturaleza y la aventura son protagonistas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Ciudad">
                <div class="card-body">
                    <h5 class="card-title">Ciudades Cosmopolitas</h5>
                    <p class="card-text">Explora cultura, gastronomía y vida urbana en tus vuelos.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICIOS -->
<section id="servicios" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Nuestros Servicios</h2>
        <div class="row text-center g-4">
            <div class="col-md-3">
                <i class="fas fa-plane fs-2 text-primary"></i>
                <h5 class="mt-2">Vuelos Seguros</h5>
                <p>Garantizamos seguridad y comodidad en cada viaje.</p>
            </div>
            <div class="col-md-3">
                <i class="fas fa-utensils fs-2 text-primary"></i>
                <h5 class="mt-2">Comida a Bordo</h5>
                <p>Disfruta de menús variados durante tu vuelo.</p>
            </div>
            <div class="col-md-3">
                <i class="fas fa-headset fs-2 text-primary"></i>
                <h5 class="mt-2">Atención 24/7</h5>
                <p>Nuestro equipo siempre listo para ayudarte.</p>
            </div>
            <div class="col-md-3">
                <i class="fas fa-ticket-alt fs-2 text-primary"></i>
                <h5 class="mt-2">Reservas Fáciles</h5>
                <p>Compra tus boletos de manera rápida y segura.</p>
            </div>
        </div>
    </div>
</section>

<!-- CÓMO RESERVAR -->
<section id="reserva" class="container my-5">
    <h2 class="text-center mb-4">Cómo Reservar</h2>
    <div class="row g-4">
        <div class="col-md-3 text-center">
            <i class="fas fa-user-plus fs-1 text-primary mb-2"></i>
            <h5>Registrarse</h5>
            <p>Crea tu cuenta para comenzar a reservar vuelos.</p>
        </div>
        <div class="col-md-3 text-center">
            <i class="fas fa-plane-departure fs-1 text-primary mb-2"></i>
            <h5>Elegir Vuelo</h5>
            <p>Explora los vuelos disponibles y selecciona tu destino.</p>
        </div>
        <div class="col-md-3 text-center">
            <i class="fas fa-ticket-alt fs-1 text-primary mb-2"></i>
            <h5>Reservar</h5>
            <p>Confirma tu vuelo y obtén tu boleto digital.</p>
        </div>
        <div class="col-md-3 text-center">
            <i class="fas fa-smile fs-1 text-primary mb-2"></i>
            <h5>Disfrutar</h5>
            <p>Vuela con seguridad y comodidad a tu destino soñado.</p>
        </div>
    </div>
</section>

<!-- TESTIMONIOS -->
<section id="testimonios" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Qué dicen nuestros clientes</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <p>"Excelente servicio, muy puntual y la tripulación amable."</p>
                    <h6 class="fw-bold mb-0">- Ana G.</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <p>"La experiencia de vuelo fue increíble, volveré a reservar seguro."</p>
                    <h6 class="fw-bold mb-0">- Carlos M.</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <p>"Muy recomendable para viajes familiares y de negocios."</p>
                    <h6 class="fw-bold mb-0">- Laura P.</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTACTO -->
<section id="contacto" class="container my-5">
    <h2 class="text-center mb-4">Contáctanos</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{ route('contacto.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
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
                <button type="submit" class="btn btn-primary fw-bold"><i class="fas fa-paper-plane me-2"></i> Enviar Mensaje</button>
            </form>
        </div>
    </div>
</section>
@endsection
