@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Vuelos Disponibles</h2>

    @if($vuelos->count() > 0)
        <div class="row g-4">
            @foreach($vuelos as $vuelo)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-plane"></i> {{ $vuelo->origen }} → {{ $vuelo->destino }}</h5>
                        <p class="card-text">
                            <strong>Fecha de salida:</strong> {{ \Carbon\Carbon::parse($vuelo->fecha_salida)->format('d/m/Y H:i') }}<br>
                            <strong>Fecha de llegada:</strong> {{ \Carbon\Carbon::parse($vuelo->fecha_llegada)->format('d/m/Y H:i') }}<br>
                            <strong>Precio:</strong> ${{ number_format($vuelo->precio, 2) }}
                        </p>
                        <a href="{{ route('reservaciones.create', ['vuelo_id' => $vuelo->id]) }}" class="btn btn-primary w-100">
                            Reservar
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-center">No hay vuelos disponibles en este momento.</p>
    @endif
</div>
@endsection
