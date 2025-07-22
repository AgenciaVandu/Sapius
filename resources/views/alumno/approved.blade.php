@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    {{-- {{ Auth::user()->nombre_completo }}</h2> --}}
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Confirmación de pago</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <i data-feather="check-circle" class="feather-icon text-success" style="width: 80px; height: 80px; margin-bottom: 1.5rem;"></i>
                    <h2 class="text-success font-weight-bold mb-3">¡Pago aprobado!</h2>
                    <p class="lead text-muted mb-4">
                        Tu transacción ha sido procesada exitosamente. Gracias por tu compra.
                    </p>

                    <div class="text-left mb-4">
                        <ul class="list-unstyled text-center">
                            <li><strong>ID de transacción:</strong> {{ $id }}</li>
                        </ul>
                    </div>

                    <a href="{{ route('alumno.home') }}" class="btn btn-primary rounded-pill px-4">Ver tus cursos</a>
                </div>
            </div>
        </div>
    </div>
@endsection
