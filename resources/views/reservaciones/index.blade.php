@extends('layouts.app')

@section('title', 'Mis Reservaciones')

@section('content')
<div class="container my-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-header text-center fs-5">
                    <i class="fas fa-ticket-alt me-2"></i> Mis Reservaciones
                </div>
                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($reservaciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle text-center">
                                <thead style="background: var(--gradient-primary);">
                                    <tr class="text-white">
                                        <th># Reserva</th>
                                        <th>Vuelo</th>
                                        <th>Fecha</th>
                                        <th>Asientos</th>
                                        <th>Precio Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservaciones as $reserva)
                                        <tr>
                                            <td class="fw-bold">{{ $reserva->id }}</td>
                                            <td>{{ $reserva->vuelo->origen }} → {{ $reserva->vuelo->destino }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reserva->vuelo->fecha_salida)->format('d/m/Y') }}</td>
                                            <td>{{ $reserva->asientos }}</td>
                                            <td class="fw-bold">${{ number_format($reserva->asientos * $reserva->vuelo->precio, 2) }}</td>
                                            <td>
                                                <a href="{{ route('reservaciones.boleto', $reserva->id) }}" target="_blank" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-file-pdf me-1"></i> Boleto
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-4 border rounded" style="background-color: var(--light-color);">
                            <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                            <h4 class="mb-2">Aún no tienes reservaciones</h4>
                            <p class="text-muted">¡Anímate a explorar nuestros destinos y reserva tu próxima aventura!</p>
                            <a href="{{ route('vuelos.index') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plane me-2"></i> Ver Vuelos Disponibles
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- INICIO DEL MODAL PARA INFORMACIÓN -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--gradient-primary); color: white;">
                <h5 class="modal-title" id="infoModalLabel"><i class="fas fa-info-circle me-2"></i> Detalles de la Reservación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal-content-placeholder" class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando detalles...</p>
                </div>
                <div id="modal-content-data" style="display: none;">
                    {{-- Los datos se insertarán aquí --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN DEL MODAL -->
@endsection {{-- <-- ¡CORRECCIÓN! CIERRA LA SECCIÓN 'content' --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const infoModal = document.getElementById('infoModal');

    infoModal.addEventListener('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const reservacionId = button.getAttribute('data-id');
        const contentPlaceholder = document.getElementById('modal-content-placeholder');
        const contentData = document.getElementById('modal-content-data');

        contentPlaceholder.style.display = 'block';
        contentData.style.display = 'none';
        contentData.innerHTML = '';

        try {
            const response = await fetch(`/reservaciones/${reservacionId}`);
            if (!response.ok) throw new Error('No se pudieron cargar los datos.');

            const data = await response.json();
            
            const asientosHtml = data.numeros_asiento.map(asiento => 
                `<span class="badge bg-primary fs-6 me-1">${asiento}</span>`
            ).join('');

            const fechaReserva = new Date(data.fecha_reserva).toLocaleString('es-ES', { dateStyle: 'long', timeStyle: 'short' });

            contentData.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-plane-departure text-primary"></i> Detalles del Vuelo</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Ruta:</strong> ${data.vuelo.origen} → ${data.vuelo.destino}</li>
                            <li class="list-group-item"><strong>Fecha de Salida:</strong> ${new Date(data.vuelo.fecha_salida).toLocaleDateString('es-ES')}</li>
                        </ul>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <h5><i class="fas fa-user-check text-primary"></i> Detalles de la Reserva</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Fecha de Reserva:</strong> ${fechaReserva}</li>
                            <li class="list-group-item"><strong>Cantidad de Asientos:</strong> ${data.asientos}</li>
                            <li class="list-group-item"><strong>Asientos Reservados:</strong> ${asientosHtml}</li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4">
                <h5><i class="fas fa-credit-card text-primary"></i> Información de Pago</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Método de Pago:</strong> <span class="text-capitalize">${data.metodo_pago}</span></li>
                    ${data.metodo_pago === 'paypal' ? `<li class="list-group-item"><strong>Email de PayPal:</strong> ${data.paypal_email}</li>` : ''}
                </ul>
            `;
            
            contentPlaceholder.style.display = 'none';
            contentData.style.display = 'block';

        } catch (error) {
            contentPlaceholder.innerHTML = '<p class="text-danger">Error al cargar la información. Por favor, inténtelo de nuevo.</p>';
        }
    });
});
</script>
@endpush {{-- <-- ¡CORRECCIÓN! CIERRA EL PUSH 'scripts' --}}
