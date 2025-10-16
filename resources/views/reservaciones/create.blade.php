@extends('layouts.app')

{{-- 
  El controlador debe proveer las siguientes variables:
  - $vuelo: Objeto del vuelo con sus propiedades (precio, origen, etc.).
  - $asientosOcupados: Un array con los números de asiento que ya no están disponibles. Ej: ['1A', '3C', '4F'].
--}}

@section('title', 'Reservar Vuelo')

@section('content')
<style>
    /* Estilos del mapa de asientos (sin cambios, como se solicitó) */
    .seat-map { display: flex; flex-direction: column; align-items: center; margin: 2rem 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f8f9fa; overflow-x: auto; }
    .seat-row { display: flex; align-items: center; margin-bottom: 5px; }
    .seat { width: 35px; height: 35px; margin: 3px; border-radius: 5px; background-color: #a5d6a7; color: #333; font-size: 12px; font-weight: bold; display: flex; justify-content: center; align-items: center; cursor: pointer; transition: background-color 0.2s; user-select: none; }
    .seat.ocupado { background-color: #ef5350; cursor: not-allowed; color: white; }
    .seat.selected { background-color: var(--accent-color, #ff6d00); color: white; transform: scale(1.1); box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    .seat:not(.ocupado):hover { background-color: #66bb6a; }
    .aisle { width: 30px; height: 35px; }
    .seat-legend { display: flex; justify-content: center; flex-wrap: wrap; gap: 20px; margin-top: 20px; width: 100%; }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .legend-box { width: 20px; height: 20px; border-radius: 3px; }
</style>

<div class="container my-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header text-center fs-5">
                    <i class="fas fa-ticket-alt me-2"></i> Reservar Vuelo
                </div>
                <div class="card-body p-4 p-md-5">

                    @if($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="reservacionForm" action="{{ route('reservaciones.store') }}" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="vuelo_id" value="{{ $vuelo->id }}">
                        <input type="hidden" name="asientos_seleccionados" id="asientos_seleccionados">

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-plane me-2"></i>Vuelo</label>
                                <input type="text" class="form-control" value="{{ $vuelo->origen }} → {{ $vuelo->destino }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-calendar-alt me-2"></i>Fecha de Salida</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($vuelo->fecha_salida)->format('d/m/Y H:i') }}" readonly>
                            </div>
                        </div>

                        <h4 class="mt-4 mb-3 text-center text-primary">Seleccione sus Asientos</h4>
                        <div class="seat-map">
                            <div class="plane-front text-center bg-secondary text-white p-2 rounded mb-3" style="width: 80%;">CABINA DEL PILOTO</div>
                            <div id="seat-container">
                                @php
                                    $totalAsientos = $vuelo->asientos_disponibles + count($asientosOcupados);
                                    $asientosPorFila = 6;
                                    $filas = ceil($totalAsientos / $asientosPorFila);
                                    $letras = ['A', 'B', 'C', '', 'D', 'E', 'F'];
                                @endphp
                                @for ($fila = 1; $fila <= $filas; $fila++)
                                    <div class="seat-row">
                                        @foreach ($letras as $letra)
                                            @if ($letra == '')
                                                <div class="aisle"></div>
                                            @else
                                                @php
                                                    $numeroAsiento = $fila . $letra;
                                                    $isOcupado = in_array($numeroAsiento, $asientosOcupados);
                                                @endphp
                                                <div class="seat {{ $isOcupado ? 'ocupado' : '' }}" data-seat-number="{{ $numeroAsiento }}">{{ $numeroAsiento }}</div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endfor
                            </div>
                            <div class="seat-legend">
                                <div class="legend-item"><div class="legend-box" style="background-color: #a5d6a7;"></div><span>Disponible</span></div>
                                <div class="legend-item"><div class="legend-box" style="background-color: var(--accent-color, #ff6d00);"></div><span>Seleccionado</span></div>
                                <div class="legend-item"><div class="legend-box" style="background-color: #ef5350;"></div><span>Ocupado</span></div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-7 mb-3">
                                <label for="asientos_display" class="form-label fw-bold">Asientos Seleccionados</label>
                                <input type="text" id="asientos_display" class="form-control" value="Ninguno" readonly>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label fw-bold">Total a Pagar</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control fs-5" id="total" value="0.00" readonly>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h4 class="mb-3 text-center text-primary">Información de Pago</h4>

                        <div class="mb-3">
                            <label for="metodo_pago" class="form-label fw-bold">Método de Pago</label>
                            <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                <option value="" disabled selected>Selecciona un método</option>
                                <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta de Crédito/Débito</option>
                                <option value="paypal" {{ old('metodo_pago') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            </select>
                        </div>

                        <div id="datos_pago" style="display:none;">
                            <div id="tarjeta_inputs" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">Número de Tarjeta</label>
                                    <input type="text" id="numero_tarjeta" class="form-control" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha de Expiración</label>
                                        <input type="text" id="expiracion" class="form-control" placeholder="MM/YY" maxlength="5">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV</label>
                                        <input type="text" id="cvv" class="form-control" placeholder="123" maxlength="4">
                                    </div>
                                </div>
                                <small class="text-muted">Por seguridad, estos datos son solo para validación visual y no se almacenan.</small>
                            </div>
                            <div id="paypal_inputs" style="display:none;" class="mb-3">
                                <label class="form-label">Correo de PayPal</label>
                                <input type="email" name="paypal_email" class="form-control" placeholder="usuario@ejemplo.com" value="{{ old('paypal_email') }}">
                            </div>
                        </div>
                        
                        <div class="row mt-4 g-2">
                            <div class="col-md-6">
                                <a href="{{ route('vuelos.index') }}" class="btn btn-outline-secondary w-100 py-2">
                                    <i class="fas fa-arrow-left me-2"></i> Regresar a Vuelos
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-check-circle me-2"></i> Confirmar Reservación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// El script JavaScript permanece sin cambios
document.addEventListener('DOMContentLoaded', function() {
    const precioPorAsiento = {{ $vuelo->precio }};
    const seatContainer = document.getElementById('seat-container');
    const asientosDisplayInput = document.getElementById('asientos_display');
    const hiddenAsientosSeleccionados = document.getElementById('asientos_seleccionados');
    const totalInput = document.getElementById('total');
    const metodoPago = document.getElementById('metodo_pago');
    const datosPago = document.getElementById('datos_pago');
    const tarjetaInputs = document.getElementById('tarjeta_inputs');
    const paypalInputs = document.getElementById('paypal_inputs');
    const expiracionInput = document.getElementById('expiracion');
    const numeroTarjetaInput = document.getElementById('numero_tarjeta');

    seatContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('seat') && !e.target.classList.contains('ocupado')) {
            e.target.classList.toggle('selected');
            actualizarSeleccionYTotal();
        }
    });

    const actualizarSeleccionYTotal = () => {
        const asientosSeleccionados = document.querySelectorAll('.seat.selected');
        const cantidad = asientosSeleccionados.length;
        const numerosDeAsiento = Array.from(asientosSeleccionados).map(seat => seat.dataset.seatNumber);
        asientosDisplayInput.value = cantidad > 0 ? numerosDeAsiento.join(', ') : 'Ninguno';
        totalInput.value = (cantidad * precioPorAsiento).toFixed(2);
        hiddenAsientosSeleccionados.value = numerosDeAsiento.join(',');
    };

    const mostrarCamposDePago = () => {
        const metodo = metodoPago.value;
        datosPago.style.display = metodo ? 'block' : 'none';
        tarjetaInputs.style.display = (metodo === 'tarjeta') ? 'block' : 'none';
        paypalInputs.style.display = (metodo === 'paypal') ? 'block' : 'none';
    };

    metodoPago.addEventListener('change', mostrarCamposDePago);
    mostrarCamposDePago();

    if (expiracionInput) {
        expiracionInput.addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '').slice(0, 4);
            if (v.length > 2) { v = v.slice(0, 2) + '/' + v.slice(2); }
            this.value = v;
        });
    }

    if (numeroTarjetaInput) {
        numeroTarjetaInput.addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '').slice(0, 16);
            v = v.match(/.{1,4}/g)?.join(' ') || v;
            this.value = v;
        });
    }
});
</script>
@endsection