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
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold mb-3">Listado de Inscripciones</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>id transaccion</th>
                                    <th>Curso</th>
                                    <th>Email</th>
                                    {{-- <th>Monto</th> --}}
                                    <th>Fecha de inscripción</th>
                                    <th>Ver</th>
                                    <!-- Agrega más columnas si es necesario -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inscriptions as $inscription)
                                    <tr>
                                        <td> {{ $inscription->referencia ?? '-' }}</td>
                                        <td>{{ $inscription->CursoProgramado->identificador ?? '-' }}</td>
                                        <td>{{ $inscription->user->email ?? '-' }}</td>
                                        {{-- <td>${{ number_format($inscription->CursoProgramado->precio, 2) ?? '-' }}</td> --}}
                                        <td>{{ $inscription->created_at ? $inscription->created_at->format('d/m/Y H:i') : '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.reports.inscriptions.show', $inscription->referencia) }}" class="btn btn-sm btn-primary">Ver</a>
                                        </td>
                                        <!-- Agrega más datos si es necesario -->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay inscripciones registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $inscriptions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
