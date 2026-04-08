@extends('layouts.adminmart.default')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
                Progreso de {{ $alumno->nombre }} {{ $alumno->apellidos }}
            </h3>
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
                                {{-- Exámenes del Módulo --}}
                                @foreach ($modulo->Pruebas as $prueba)
                                    @php
                                        $checkExamenStr = '<span class="text-muted font-italic">No Presentado</span>';
                                        $calificacionExamenStr = '-';
                                        $bgColor = '';
                                        $textColor = '';

                                        if ($examenes->has($prueba->id)) {
                                            $examen = $examenes[$prueba->id];
                                            if ($examen->finalizado == 'si') {
                                                if ($examen->score_total < 1200) {
                                                    $bgColor = '#FFCCCC';
                                                    $textColor = '#a94442';
                                                } else {
                                                    $bgColor = '#D4EDDA';
                                                    $textColor = '#155724';
                                                }
                                                $checkExamenStr = '<strong>Presentado</strong>' . ($examen->is_late ? ' <span class="badge badge-danger">Atrasado</span>' : '') . '<br><small>(' . $examen->total_correctas . '/' . $examen->total_preguntas . ')</small>';
                                                $calificacionExamenStr = '<strong>' . $examen->score_total . '</strong>';
                                            } else {
                                                $bgColor = '#FFF3CD';
                                                $textColor = '#856404';
                                                $checkExamenStr = '<strong>En Progreso</strong>';
                                            }
                                        } else {
                                            $bgColor = '#FFFF8A';
                                            $textColor = '#948503';
                                        }
                                    @endphp
                                    <tr style="background-color: #f0f7ff;">
                                        <td class="text-center align-middle border-right-0" style="width: 50px;">
                                            <i class="fas fa-file-alt text-primary"></i>
                                        </td>
                                        <td class="pl-3 align-middle border-left-0">
                                            <strong>Examen de Módulo:</strong> {{ $prueba->titulo }}
                                        </td>
                                        <td class="align-middle text-center text-muted">-</td>
                                        <td class="align-middle text-center text-muted">-</td>
                                        <td class="align-middle text-center" style="@if($bgColor) background-color: {{$bgColor}}; color: {{$textColor}}; @endif">
                                            {!! $checkExamenStr !!}
                                        </td>
                                        <td class="align-middle text-center" style="@if($bgColor) background-color: {{$bgColor}}; color: {{$textColor}}; @endif">
                                            {!! $calificacionExamenStr !!}
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($modulo->Clases as $clase)
                                    @php
                                        // 1. Lección Vista
                                        $terminada = in_array($clase->id, $completedLessons);
                                        $unlock = $unlockedLessonsData->get($clase->id);
                                        
                                        // 2. Tarea Enviada
                                        $enviado = $homeworks->has($clase->id);
                                        $hw = $enviado ? $homeworks[$clase->id] : null;
                                        $checkTarea = $enviado ? ($hw->is_late ? '<span class="badge badge-success">Entregada</span> <span class="badge badge-danger">Atrasada</span>' : '<span class="badge badge-success">Entregada</span>') : '<span class="badge badge-light text-muted">Pendiente</span>';

                                        // Auto-Completion override
                                        $anyExamenFinalizado = $clase->Pruebas->contains(function($p) use ($examenes) {
                                            return $examenes->has($p->id) && $examenes[$p->id]->finalizado == 'si';
                                        });
                                        if (!$terminada && ($enviado || $anyExamenFinalizado)) {
                                            $terminada = true;
                                        }
                                        $checkTerminada = $terminada ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-warning">No</span>';
                                    @endphp
                                    
                                    @if ($clase->Pruebas->count() == 0)
                                        <tr>
                                            <td class="text-center align-middle border-right-0" style="width: 50px;">
                                                <i class="fas fa-level-up-alt fa-rotate-90 text-muted"></i>
                                            </td>
                                            <td class="pl-3 align-middle border-left-0">
                                                {{ $clase->titulo }}
                                                @if($unlock)
                                                    <span class="badge badge-info ml-1" title="Fecha límite: {{ \Carbon\Carbon::parse($unlock->until_date)->format('d/m/Y H:i') }}">Desbloqueo Individual</span>
                                                @endif
                                                <button class="btn btn-sm btn-link p-0 ml-1 text-primary btn-unlock" 
                                                        title="{{ $unlock ? 'Editar Desbloqueo' : 'Desbloquear Individualmente' }}"
                                                        data-leccion-id="{{ $clase->id }}"
                                                        data-titulo="{{ $clase->titulo }}"
                                                        data-current-deadline="{{ $unlock ? \Carbon\Carbon::parse($unlock->until_date)->format('d/m/Y H:i') : '' }}">
                                                    <i class="fas {{ $unlock ? 'fa-edit' : 'fa-unlock-alt' }}"></i>
                                                </button>
                                                @if($unlock)
                                                    <button class="btn btn-sm btn-link p-0 ml-1 text-danger btn-lock-now" 
                                                            title="Volver a Bloquear"
                                                            data-leccion-id="{{ $clase->id }}">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">{!! $checkTerminada !!}</td>
                                            <td class="align-middle text-center">{!! $checkTarea !!}</td>
                                            <td class="align-middle text-center"><span class="text-muted font-italic">N/A</span></td>
                                            <td class="align-middle text-center"><span class="text-muted font-italic">N/A</span></td>
                                        </tr>
                                    @else
                                        @foreach ($clase->Pruebas as $index => $prueba)
                                            @php
                                                $checkExamenStr = '<span class="text-muted font-italic">No Presentado</span>';
                                                $calificacionExamenStr = '-';
                                                $bgColor = '';
                                                $textColor = '';

                                                if ($examenes->has($prueba->id)) {
                                                    $examen = $examenes[$prueba->id];
                                                    if ($examen->finalizado == 'si') {
                                                        if ($examen->score_total < 1200) {
                                                            $bgColor = '#FFCCCC';
                                                            $textColor = '#a94442';
                                                        } else {
                                                            $bgColor = '#D4EDDA';
                                                            $textColor = '#155724';
                                                        }
                                                        $checkExamenStr = '<strong>Presentado</strong>' . ($examen->is_late ? ' <span class="badge badge-danger">Atrasado</span>' : '') . '<br><small>(' . $examen->total_correctas . '/' . $examen->total_preguntas . ')</small>';
                                                        $calificacionExamenStr = '<strong>' . $examen->score_total . '</strong>';
                                                    } else {
                                                        $bgColor = '#FFF3CD';
                                                        $textColor = '#856404';
                                                        $checkExamenStr = '<strong>En Progreso</strong>';
                                                    }
                                                } else {
                                                    $bgColor = '#FFFF8A';
                                                    $textColor = '#948503';
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center align-middle border-right-0" style="width: 50px;">
                                                    @if($index == 0)
                                                        <i class="fas fa-level-up-alt fa-rotate-90 text-muted"></i>
                                                    @endif
                                                </td>
                                                <td class="pl-3 align-middle border-left-0">
                                                    @if($index == 0)
                                                        {{ $clase->titulo }}
                                                        @if($unlock)
                                                            <span class="badge badge-info ml-1" title="Fecha límite: {{ \Carbon\Carbon::parse($unlock->until_date)->format('d/m/Y H:i') }}">Desbloqueo Individual</span>
                                                        @endif
                                                        <button class="btn btn-sm btn-link p-0 ml-1 text-primary btn-unlock" 
                                                                title="{{ $unlock ? 'Editar Desbloqueo' : 'Desbloquear Individualmente' }}"
                                                                data-leccion-id="{{ $clase->id }}"
                                                                data-titulo="{{ $clase->titulo }}"
                                                                data-current-deadline="{{ $unlock ? \Carbon\Carbon::parse($unlock->until_date)->format('d/m/Y H:i') : '' }}">
                                                            <i class="fas {{ $unlock ? 'fa-edit' : 'fa-unlock-alt' }}"></i>
                                                        </button>
                                                        @if($unlock)
                                                            <button class="btn btn-sm btn-link p-0 ml-1 text-danger btn-lock-now" 
                                                                    title="Volver a Bloquear"
                                                                    data-leccion-id="{{ $clase->id }}">
                                                                <i class="fas fa-lock"></i>
                                                            </button>
                                                        @endif
                                                    @else
                                                        <span class="text-muted ml-4"><i class="fas fa-caret-right mr-1"></i>Examen: {{ $prueba->titulo }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">@if($index == 0) {!! $checkTerminada !!} @else - @endif</td>
                                                <td class="align-middle text-center">@if($index == 0) {!! $checkTarea !!} @else - @endif</td>
                                                <td class="align-middle text-center" style="@if($bgColor) background-color: {{$bgColor}}; color: {{$textColor}}; @endif">
                                                    {!! $checkExamenStr !!}
                                                </td>
                                                <td class="align-middle text-center" style="@if($bgColor) background-color: {{$bgColor}}; color: {{$textColor}}; @endif">
                                                    {!! $calificacionExamenStr !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Desbloqueo --}}
<div class="modal fade" id="modalUnlock" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Desbloquear Lección Individualmente</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Estás permitiendo que el alumno entregue sus actividades para: <strong id="unlock-lesson-title"></strong></p>
                <div class="form-group">
                    <label>Nueva Fecha Límite (Individual):</label>
                    <input type="text" id="unlock-date" class="form-control" placeholder="dd/mm/aaaa hh:mm" value="{{ \Carbon\Carbon::now()->addDays(2)->format('d/m/Y 23:59') }}">
                    <small class="text-muted">El alumno podrá ver y subir contenido hasta este momento.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-save-unlock">Guardar Desbloqueo</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var currentLeccionId = null;

        $('.btn-unlock').click(function() {
            currentLeccionId = $(this).data('leccion-id');
            var titulo = $(this).data('titulo');
            var deadline = $(this).data('current-deadline');

            $('#unlock-lesson-title').text(titulo);
            if(deadline) {
                $('#unlock-date').val(deadline);
            }
            $('#modalUnlock').modal('show');
        });

        $('#btn-save-unlock').click(function() {
            var date = $('#unlock-date').val();
            if(!date) {
                alert('Por favor especifica una fecha');
                return;
            }

            $.ajax({
                url: "{{ route('admin.curso.lesson.unlock') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: "{{ $alumno->id }}",
                    curso_programado_id: "{{ $curso_programado->id }}",
                    leccion_id: currentLeccionId,
                    until_date: date,
                    action: 'unlock'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error al procesar el desbloqueo');
                }
            });
        });

        $('.btn-lock-now').click(function() {
            if(!confirm('¿Seguro que quieres volver a bloquear esta lección para el alumno?')) return;
            
            var leccionId = $(this).data('leccion-id');
            $.ajax({
                url: "{{ route('admin.curso.lesson.unlock') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: "{{ $alumno->id }}",
                    curso_programado_id: "{{ $curso_programado->id }}",
                    leccion_id: leccionId,
                    action: 'lock'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error al procesar el bloqueo');
                }
            });
        });
    });
</script>
@endsection
