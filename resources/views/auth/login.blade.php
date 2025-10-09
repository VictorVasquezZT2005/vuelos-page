@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container my-5">
    <h2>Iniciar Sesión</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <input type="email" name="correo" placeholder="Correo" class="form-control mb-2" required>
        <input type="password" name="password" placeholder="Contraseña" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
</div>
@endsection
