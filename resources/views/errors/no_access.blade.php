@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center p-5 rounded shadow-lg bg-white" style="max-width: 480px; width: 100%;">
            <div class="mb-4">
                <i class="fas fa-mobile-alt fa-4x text-danger"></i>
            </div>
            <h2 class="mb-3 text-dark font-weight-bold">Acceso Restringido</h2>
            <p class="mb-4 text-secondary">
                Esta sección del sitio no está disponible desde dispositivos móviles o tabletas.<br>
                Por favor, accede desde un ordenador o laptop para continuar.
            </p>
            <a class="btn btn-primary btn-lg px-4" href="{{ route('landing.home') }}">
                <i class="fas fa-home"></i> Volver al inicio
            </a>
        </div>
    </div>
@endsection
