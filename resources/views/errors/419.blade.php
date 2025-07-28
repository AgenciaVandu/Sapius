@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center p-4 shadow rounded bg-white" style="max-width: 400px; width: 100%;">
            <div class="mb-4">
                <i class="fas fa-clock fa-4x text-secondary"></i>
            </div>
            <h1 class="display-4 mb-3 text-secondary">419</h1>
            <h2 class="mb-3">Página Expirada</h2>
            <p class="mb-4 text-muted">
                Tu sesión ha expirado o esta página ya no es válida.<br>
                Por seguridad, debes recargar la página o iniciar sesión nuevamente.
            </p>
            <a class="btn btn-info btn-lg w-100" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i>
                Iniciar sesión
            </a>
        </div>
    </div>
@endsection
