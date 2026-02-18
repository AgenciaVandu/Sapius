@extends('layouts.adminmart.default')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Seguimiento de Tareas</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.cursos.index') }}">Cursos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $alumno->nombre }} {{ $alumno->apellido_paterno }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tareas del Alumno: {{ $alumno->nombre_completo }}</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered no-wrap">
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Lección</th>
                                <th>Estado</th>
                                <th>Fecha de Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modulos as $modulo)
                                @foreach ($modulo->Clases as $clase)
                                    <tr>
                                        <td>{{ $modulo->titulo }}</td>
                                        <td>{{ $clase->titulo }}</td>
                                        <td>
                                            @if ($homeworks->has($clase->id))
                                                <span class="badge badge-success">Entregado</span>
                                            @else
                                                <span class="badge badge-warning">Pendiente</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($homeworks->has($clase->id))
                                                {{ $homeworks[$clase->id]->created_at->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
