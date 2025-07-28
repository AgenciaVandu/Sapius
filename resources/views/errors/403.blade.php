@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center p-4 shadow rounded bg-white" style="max-width: 400px; width: 100%;">
            <div class="mb-4">
                <i class="fas fa-ban fa-4x text-danger"></i>
            </div>
            <h1 class="display-4 mb-3 text-danger">403</h1>
            <h2 class="mb-3">Acceso Denegado</h2>
            <p class="mb-4 text-muted">
                Lo sentimos, no tienes permisos para acceder a esta página.<br>
                Si crees que esto es un error, contacta al administrador del sistema.
            </p>
            <a class="btn btn-info btn-lg w-100" href="{{ route('login') }}">
                <i class="fas fa-home"></i>
                Regresar al inicio
            </a>
        </div>
    </div>
@endsection
