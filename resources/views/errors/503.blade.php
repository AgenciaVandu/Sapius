@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center p-4 shadow rounded bg-white" style="max-width: 400px; width: 100%;">
            <div class="mb-4">
                <i class="fas fa-tools fa-4x text-dark"></i>
            </div>
            <h1 class="display-4 mb-3 text-dark">503</h1>
            <h2 class="mb-3">Servicio No Disponible</h2>
            <p class="mb-4 text-muted">
                En este momento estamos realizando tareas de mantenimiento o el servicio está temporalmente
                sobrecargado.<br>
                Por favor, vuelve a intentarlo más tarde.
            </p>
            <a class="btn btn-info btn-lg w-100" href="{{ route('login') }}">
                <i class="fas fa-redo-alt"></i>
                Reintentar
            </a>
        </div>
    </div>
@endsection
