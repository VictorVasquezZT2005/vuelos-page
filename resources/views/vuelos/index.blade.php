@extends('layouts.app')

@section('styles')
<style>
/* ... Pega aquí todo el código CSS ... */
</style>
@endsection

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Vuelos Disponibles ✈️</h2>

    @if($vuelos->count() > 0)
        <div class="row g-4">
            @foreach($vuelos as $vuelo)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    {{-- Contenedor de la animación mejorada --}}
                    <div class="plane-animation">
                        <i class="fas fa-plane"></i>
                        <div class="cloud cloud-1 drift-slow"></div>
                        <div class="cloud cloud-2 drift-fast"></div>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center mb-3">
                            {{ $vuelo->origen }} → {{ $vuelo->destino }}
                        </h5>

                        <p class="card-text">
                            <strong>Código:</strong> {{ $vuelo->codigo }}<br>
                            <strong>Salida:</strong> {{ \Carbon\Carbon::parse($vuelo->fecha_salida)->format('d/m/Y H:i') }}<br>
                            <strong>Llegada:</strong> {{ \Carbon\Carbon::parse($vuelo->fecha_llegada)->format('d/m/Y H:i') }}<br>
                            <strong>Precio:</strong> ${{ number_format($vuelo->precio, 2) }}<br>
                            <strong>Asientos disponibles:</strong> {{ $vuelo->asientos_disponibles }}<br>
                            <strong>Asientos ocupados:</strong> {{ $vuelo->asientos_ocupados }}
                        </p>

                        {{-- =============================================================== --}}
                        {{-- ========= INICIO DEL CÓDIGO MODIFICADO PARA EL BOTÓN ========= --}}
                        {{-- =============================================================== --}}

                        @php
                            // Se establece la zona horaria de El Salvador
                            $nowInElSalvador = \Carbon\Carbon::now('America/El_Salvador');
                            $fechaSalida = \Carbon\Carbon::parse($vuelo->fecha_salida);
                        @endphp

                        @if($fechaSalida->isFuture() && $vuelo->asientos_disponibles > 0)
                            {{-- Si el vuelo es en el futuro y hay asientos, el botón está activo --}}
                            <a href="{{ route('reservaciones.create', ['vuelo_id' => $vuelo->id]) }}" class="btn btn-primary w-100 mt-auto">
                                Reservar
                            </a>
                        @else
                            {{-- Si el vuelo ya pasó o no hay asientos, el botón está desactivado --}}
                            <button class="btn btn-secondary w-100 mt-auto" disabled>
                                Vuelo no disponible
                            </button>
                        @endif

                        {{-- =============================================================== --}}
                        {{-- =========== FIN DEL CÓDIGO MODIFICADO PARA EL BOTÓN =========== --}}
                        {{-- =============================================================== --}}

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            <p class="mb-0">No hay vuelos disponibles en este momento.</p>
        </div>
    @endif
</div>
@endsection