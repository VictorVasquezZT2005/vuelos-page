@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Reservar Vuelo</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('reservaciones.store') }}" method="POST">
        @csrf
        <input type="hidden" name="cliente_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="vuelo_id" value="{{ $vuelo->id }}">

        <div class="mb-3">
            <label class="form-label">Vuelo</label>
            <input type="text" class="form-control" value="{{ $vuelo->origen }} → {{ $vuelo->destino }} ({{ \Carbon\Carbon::parse($vuelo->fecha)->format('d/m/Y') }} {{ $vuelo->hora }})" disabled>
        </div>

        <div class="mb-3">
            <label for="asientos" class="form-label">Número de Asientos</label>
            <input type="number" name="asientos" id="asientos" class="form-control" min="1" value="1" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Confirmar Reservación</button>
    </form>
</div>
@endsection
