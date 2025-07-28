@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center p-4 shadow rounded bg-white" style="max-width: 400px; width: 100%;">
            <div class="mb-4">
                <i class="fas fa-hand-paper fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-3 text-warning">405</h1>
            <h2 class="mb-3">Método No Permitido</h2>
            <p class="mb-4 text-muted">
                El método de la solicitud no está permitido para esta ruta.<br>
                Por favor verifica cómo estás accediendo al recurso o contacta al soporte técnico.
            </p>
            <a class="btn btn-info btn-lg w-100" href="{{ route('login') }}">
                <i class="fas fa-home"></i>
                Regresar al inicio
            </a>
        </div>
    </div>
@endsection
