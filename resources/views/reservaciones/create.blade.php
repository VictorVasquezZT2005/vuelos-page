@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Reservar Vuelo</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="reservacionForm" action="{{ route('reservaciones.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="vuelo_id" value="{{ $vuelo->id }}">
        <input type="hidden" name="fecha_reserva" value="{{ now() }}">

        <div class="mb-3">
            <label class="form-label">Vuelo</label>
            <input type="text" class="form-control" 
                value="{{ $vuelo->origen }} → {{ $vuelo->destino }} ({{ \Carbon\Carbon::parse($vuelo->fecha_salida)->format('d/m/Y H:i') }})" 
                disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de Reserva</label>
            <input type="text" class="form-control" value="{{ now()->format('d/m/Y H:i') }}" disabled>
        </div>

        <div class="mb-3">
            <label for="asientos" class="form-label">Número de Asientos</label>
            <input type="number" name="asientos" id="asientos" class="form-control" min="1" value="{{ old('asientos',1) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Total a Pagar ($)</label>
            <input type="text" class="form-control" id="total" value="{{ number_format($vuelo->precio, 2) }}" disabled>
        </div>

        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de Pago</label>
            <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                <option value="" disabled selected>Selecciona un método</option>
                <option value="tarjeta" {{ old('metodo_pago')=='tarjeta' ? 'selected' : '' }}>Tarjeta de Crédito/Débito</option>
                <option value="paypal" {{ old('metodo_pago')=='paypal' ? 'selected' : '' }}>PayPal</option>
            </select>
        </div>

        <div id="datos_pago" style="display:none;">
            <!-- Inputs de tarjeta editables pero no enviados -->
            <div class="mb-3" id="tarjeta_inputs" style="display:none;">
                <label class="form-label">Número de Tarjeta</label>
                <input type="text" id="numero_tarjeta" class="form-control" placeholder="1234 5678 9012 3456">

                <label class="form-label mt-2">Fecha de Expiración</label>
                <input type="text" id="expiracion" class="form-control" placeholder="MM/YY" maxlength="5" value="{{ now()->format('m/y') }}">

                <label class="form-label mt-2">CVV</label>
                <input type="text" id="cvv" class="form-control" placeholder="123" maxlength="4">
                <small class="text-muted">Estos datos no se almacenan.</small>
            </div>

            <!-- PayPal sí se envía -->
            <div class="mb-3" id="paypal_inputs" style="display:none;">
                <label class="form-label">Correo de PayPal</label>
                <input type="email" name="paypal_email" class="form-control" placeholder="usuario@paypal.com" value="{{ old('paypal_email') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100">Confirmar Reservación</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const asientosInput = document.getElementById('asientos');
    const totalInput = document.getElementById('total');
    const precio = {{ $vuelo->precio }};
    const metodoPago = document.getElementById('metodo_pago');
    const datosPago = document.getElementById('datos_pago');
    const tarjetaInputs = document.getElementById('tarjeta_inputs');
    const paypalInputs = document.getElementById('paypal_inputs');
    const expiracionInput = document.getElementById('expiracion');
    const numeroTarjetaInput = document.getElementById('numero_tarjeta');
    const cvvInput = document.getElementById('cvv');

    // Actualizar total
    const actualizarTotal = () => {
        const cantidad = parseInt(asientosInput.value) || 0;
        totalInput.value = (cantidad * precio).toFixed(2);
    };
    asientosInput.addEventListener('input', actualizarTotal);
    actualizarTotal();

    // Mostrar campos según método
    function mostrarCampos() {
        datosPago.style.display = metodoPago.value ? 'block' : 'none';
        if (metodoPago.value === 'tarjeta') {
            tarjetaInputs.style.display = 'block';
            paypalInputs.style.display = 'none';
        } else if (metodoPago.value === 'paypal') {
            tarjetaInputs.style.display = 'none';
            paypalInputs.style.display = 'block';
        } else {
            tarjetaInputs.style.display = paypalInputs.style.display = 'none';
        }
    }

    metodoPago.addEventListener('change', mostrarCampos);
    mostrarCampos();

    // Pleca automática MM/YY (solo visual)
    if (expiracionInput) {
        expiracionInput.addEventListener('input', function() {
            let v = this.value.replace(/\D/g,'').slice(0,4);
            if (v.length > 2) v = v.slice(0,2) + '/' + v.slice(2);
            this.value = v;
        });
    }

    // Formato visual de número de tarjeta
    if (numeroTarjetaInput) {
        numeroTarjetaInput.addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '').slice(0,19);
            v = v.match(/.{1,4}/g)?.join(' ') || v;
            this.value = v;
        });
    }
});
</script>
@endsection
