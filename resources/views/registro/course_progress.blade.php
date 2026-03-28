@extends('layouts.adminmart.default')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Tu Progreso del Curso</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('alumno.home') }}">Mis Cursos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Progreso de Lecciones</li>
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
                <h4 class="card-title">Progreso Detallado: {{ $curso_programado->Curso->titulo }}</h4>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Módulo / Lección</th>
                                <th class="text-center">Lección Vista</th>
                                <th class="text-center">Tarea Enviada</th>
                                <th class="text-center">Examen</th>
                                <th class="text-center">Calificación Examen</th>
                            </tr>
                        </thead>
                        @foreach ($modulos as $modulo)
                            <tbody style="border-top: 2px solid #dee2e6;">
                                <tr data-toggle="collapse" data-target="#module-{{ $modulo->id }}" aria-expanded="false" aria-controls="module-{{ $modulo->id }}" style="cursor: pointer; background-color: #f4f6f9;">
                                    <td colspan="5">
                                        <h5 class="mb-0 font-weight-bold text-dark">
                                            <i class="fas fa-folder text-primary mr-2"></i>{{ $modulo->titulo }}
                                        </h5>
                                    </td>
                                    <td class="text-right align-middle">
                                        <span class="badge badge-pill badge-secondary mr-2">{{ $modulo->Clases->count() }} lecciones</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="module-{{ $modulo->id }}" class="collapse">
                                @foreach ($modulo->Clases as $clase)
                                    @php
                                        // 1. Lección Vista
                                        $terminada = in_array($clase->id, $completedLessons);

                                        // 2. Tarea Enviada
                                        $enviado = $homeworks->has($clase->id);
                                        $checkTarea = $enviado ? '<span class="badge badge-success">Entregada</span>' : '<span class="badge badge-light text-muted">Pendiente</span>';

                                        // 3. Examen (Pruebas)
                                        $checkExamenStr = '<span class="text-muted font-italic">N/A</span>';
                                        $calificacionExamenStr = '<span class="text-muted font-italic">N/A</span>';
                                        $bgColor = '';
                                        $textColor = '';
                                        $examenFinalizado = false;

                                        if ($clase->Pruebas->count() > 0) {
                                            $prueba = $clase->Pruebas->first();
                                            if ($examenes->has($prueba->id)) {
                                                $examen = $examenes[$prueba->id];
                                                if ($examen->finalizado == 'si') {
                                                    $examenFinalizado = true;
                                                    
                                                    // Semáforo visual para examen
                                                    if ($examen->score_total < 1200) {
                                                        $bgColor = '#FFCCCC'; // Rojo (Deficiente)
                                                        $textColor = '#a94442';
                                                    } else {
                                                        $bgColor = '#D4EDDA'; // Verde (Aprobado)
                                                        $textColor = '#155724';
                                                    }
                                                    $checkExamenStr = '<strong>Presentado</strong><br><small>(' . $examen->total_correctas . '/' . $examen->total_preguntas . ')</small>';
                                                    $calificacionExamenStr = '<strong>' . $examen->score_total . '</strong>';
                                                } else {
                                                    $bgColor = '#FFF3CD';
                                                    $textColor = '#856404';
                                                    $checkExamenStr = '<strong>En Progreso</strong>';
                                                    $calificacionExamenStr = '-';
                                                }
                                            } else {
                                                // Examen asignado pero no iniciado
                                                $bgColor = '#FFFF8A';
                                                $textColor = '#948503';
                                                $checkExamenStr = '<strong>No Presentado</strong>';
                                                $calificacionExamenStr = '-';
                                            }
                                        }

                                        // Logic Auto-Completion override via Examen o Tarea
                                        if (!$terminada && ($enviado || $examenFinalizado)) {
                                            $terminada = true;
                                        }
                                        $checkTerminada = $terminada ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-warning">No</span>';
                                    @endphp
                                    <tr>
                                        <td class="text-center align-middle border-right-0" style="width: 50px;">
                                            <i class="fas fa-level-up-alt fa-rotate-90 text-muted"></i>
                                        </td>
                                        <td class="pl-3 align-middle border-left-0">{{ $clase->titulo }}</td>
                                        <td class="align-middle text-center">
                                            {!! $checkTerminada !!}
                                        </td>
                                        <td class="align-middle text-center">
                                            {!! $checkTarea !!}
                                        </td>
                                        <td class="align-middle text-center" style="@if($bgColor) background-color: {{$bgColor}}; color: {{$textColor}}; @endif">
                                            {!! $checkExamenStr !!}
                                        </td>
                                        <td class="align-middle text-center" style="@if($bgColor) background-color: {{$bgColor}}; color: {{$textColor}}; @endif">
                                            {!! $calificacionExamenStr !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
