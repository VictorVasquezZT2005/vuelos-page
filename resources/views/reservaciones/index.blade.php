@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Mis Reservaciones</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($reservaciones->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Vuelo</th>
                        <th>Fecha</th>
                        <th>Asientos</th>
                        <th>Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservaciones as $reserva)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reserva->vuelo->origen }} → {{ $reserva->vuelo->destino }}</td>
                            <td>{{ \Carbon\Carbon::parse($reserva->vuelo->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $reserva->asientos }}</td>
                            <td>${{ number_format($reserva->asientos * $reserva->vuelo->precio, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center">Aún no tienes reservaciones realizadas.</p>
    @endif
</div>
@endsection
