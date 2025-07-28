@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center p-4 shadow rounded bg-white" style="max-width: 400px; width: 100%;">
            <div class="mb-4">
                <i class="fas fa-user-lock fa-4x text-primary"></i>
            </div>
            <h1 class="display-4 mb-3 text-primary">401</h1>
            <h2 class="mb-3">No Autorizado</h2>
            <p class="mb-4 text-muted">
                Necesitas iniciar sesión para acceder a esta página.<br>
                Si ya tienes una cuenta, por favor ingresa tus credenciales.
            </p>
            <a class="btn btn-info btn-lg w-100" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i>
                Iniciar sesión
            </a>
        </div>
    </div>
@endsection
