@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center p-4 shadow rounded bg-white" style="max-width: 400px; width: 100%;">
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-3 text-warning">500</h1>
            <h2 class="mb-3">Error del Servidor</h2>
            <p class="mb-4 text-muted">
                ¡Ups! Ocurrió un problema inesperado en el servidor.<br>
                Estamos trabajando para solucionarlo lo antes posible.<br>
                Intenta de nuevo más tarde o contacta al soporte técnico.
            </p>
            <a class="btn btn-info btn-lg w-100" href="{{ route('login') }}">
                <i class="fas fa-home"></i>
                Regresar al inicio
            </a>
        </div>
    </div>
@endsection
