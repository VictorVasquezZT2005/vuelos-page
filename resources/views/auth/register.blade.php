@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="container my-5">
    <h2>Registro de Cliente</h2>
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2" required>
        <input type="email" name="correo" placeholder="Correo" class="form-control mb-2" required>
        <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-2">
        <input type="password" name="password" placeholder="Contraseña" class="form-control mb-2" required>
        <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
</div>
@endsection
