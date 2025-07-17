@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Reportes</h3>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-info mr-3" style="font-size:1.5rem;">
                            <i class="fas fa-file-alt"></i>
                        </span>
                        <div>
                            <h5 class="card-title mb-1 font-weight-bold">Reporte de Inscripciones</h5>
                            <p class="card-text text-muted mb-0">Accede al informe detallado de inscripciones realizadas.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.inscriptions') }}" class="btn btn-primary btn-lg">
                        Ver Reporte <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
