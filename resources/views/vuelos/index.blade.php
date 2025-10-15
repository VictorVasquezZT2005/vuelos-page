@extends('layouts.app')

{{-- Aquí va el CSS mejorado que te mostré arriba --}}
@section('styles')
<style>
/* ... Pega aquí todo el código CSS de arriba ... */
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
                        {{-- El avión --}}
                        <i class="fas fa-plane"></i>
                        
                        {{-- Las nubes que se moverán --}}
                        <div class="cloud cloud-1 drift-slow"></div>
                        <div class="cloud cloud-2 drift-fast"></div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center mb-3">
                            {{ $vuelo->origen }} → {{ $vuelo->destino }}
                        </h5>
                        <p class="card-text">
                            <strong>Salida:</strong> {{ \Carbon\Carbon::parse($vuelo->fecha_salida)->format('d/m/Y H:i') }}<br>
                            <strong>Llegada:</strong> {{ \Carbon\Carbon::parse($vuelo->fecha_llegada)->format('d/m/Y H:i') }}<br>
                            <strong>Precio:</strong> ${{ number_format($vuelo->precio, 2) }}
                        </p>
                        <a href="{{ route('reservaciones.create', ['vuelo_id' => $vuelo->id]) }}" class="btn btn-primary w-100 mt-auto">
                            Reservar
                        </a>
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