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
                                        <th>Vuelo</th>
                                        <th>Fecha de Salida</th>
                                        <th>Asientos</th>
                                        <th>Precio Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservaciones as $reserva)
                                        <tr>
                                            <td class="fw-bold">{{ $reserva->vuelo->origen }} → {{ $reserva->vuelo->destino }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reserva->vuelo->fecha_salida)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $reserva->asientos }}</td>
                                            <td class="fw-bold">${{ number_format($reserva->asientos * $reserva->vuelo->precio, 2) }}</td>
                                            <td>
                                                @php
                                                    $fechaSalida = \Carbon\Carbon::parse($reserva->vuelo->fecha_salida);
                                                @endphp

                                                {{-- Solo muestra el botón si el vuelo aún no ha partido --}}
                                                @if($fechaSalida->isFuture())
                                                    <a href="{{ route('reservaciones.boleto', $reserva->id) }}" target="_blank" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-file-pdf me-1"></i> Boleto
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- ... Mensaje de que no hay reservaciones ... --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ... Aquí va tu código del Modal y de los Scripts ... --}}

@endsection

@push('scripts')
    {{-- ... Tu script para el modal ... --}}
@endpush