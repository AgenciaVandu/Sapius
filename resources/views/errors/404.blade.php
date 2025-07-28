@extends('layouts.landing')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10 text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                    </div>
                    <h1 class="display-4 font-weight-bold">404</h1>
                    <h2 class="mb-3">Página no encontrada</h2>
                    <p class="lead mb-4">
                        Lo sentimos, la página que buscas no existe o ha sido movida.<br>
                        Por favor, verifica la dirección o regresa al inicio.
                    </p>
                    <a class="btn btn-info btn-lg mb-2" href="{{ route('login') }}">
                        <i class="fas fa-home"></i>
                        Ir al inicio
                    </a>
                    <div class="mt-3 text-muted">
                        Si crees que esto es un error, contacta al administrador del sistema.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
