@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Error en el pago</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <i data-feather="x-circle" class="feather-icon text-danger" style="width: 80px; height: 80px; margin-bottom: 1.5rem;"></i>
                    <h2 class="text-danger font-weight-bold mb-3">¡Tarjeta Declinada!</h2>
                    <p class="lead text-muted mb-4">
                        Tu transacción no pudo ser procesada. Por favor, revisa los datos de tu tarjeta o intenta con otro método de pago.
                    </p>
                    <a href="{{ route('alumno.home') }}" class="btn btn-outline-danger rounded-pill px-4">Regresar al inicio</a>
                </div>
            </div>
        </div>
    </div>
@endsection
