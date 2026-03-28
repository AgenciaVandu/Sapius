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
                                @foreach ($modulo->Clases as $clase)
                                    @php
                                        // 1. Lección Vista
                                        $terminada = in_array($clase->id, $completedLessons);

                                        // Check for individual unlock
                                        $unlock = $unlockedLessonsData->get($clase->id);
                                        $isClosed = false;
                                        
                                        // Determine if it should be closed based on global schedule (if not unlocked)
                                        // We need the schedule here too if we want to show the 'Unlock' button correctly.
                                        // However, course_progress doesn't currently have the $schedule.
                                        // I'll add the logic to get it or just rely on the button being always visible for admin if needed.
                                        // Let's assume for now we want the same button logic.

                                        // 2. Tarea Enviada
                                        $enviado = $homeworks->has($clase->id);
                                        $hw = $enviado ? $homeworks[$clase->id] : null;
                                        $checkTarea = $enviado ? ($hw->is_late ? '<span class="badge badge-success">Entregada</span> <span class="badge badge-danger">Atrasada</span>' : '<span class="badge badge-success">Entregada</span>') : '<span class="badge badge-light text-muted">Pendiente</span>';

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
                                                    $checkExamenStr = '<strong>Presentado</strong>' . ($examen->is_late ? ' <span class="badge badge-danger">Atrasado</span>' : '') . '<br><small>(' . $examen->total_correctas . '/' . $examen->total_preguntas . ')</small>';
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
