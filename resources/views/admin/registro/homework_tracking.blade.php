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
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Lección</th>
                                <th>Estado</th>
                                <th>Fecha Límite</th>
                                <th>Fecha de Entrega</th>
                            </tr>
                        </thead>
                        @foreach ($modulos as $modulo)
                            <tbody style="border-top: 2px solid #dee2e6;">
                                <tr data-toggle="collapse" data-target="#module-{{ $modulo->id }}" aria-expanded="false" aria-controls="module-{{ $modulo->id }}" style="cursor: pointer; background-color: #f4f6f9;">
                                    <td colspan="4">
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
                                        $now = \Carbon\Carbon::now();
                                        $moduleScheduleItem = $schedule->firstWhere('id', $modulo->id);
                                        $scheduleItem = $schedule->firstWhere('id', $clase->id) ?? $moduleScheduleItem;

                                        $fechaFinalCarbon = null;
                                        $estadoStr = '<span class="badge badge-warning" style="background-color:#ffcc00; color:black;">Pendiente</span>';
                                        $fechaLimiteStr = '-';
                                        $isClosed = false;

                                        if ($scheduleItem && isset($scheduleItem['fecha_final'])) {
                                            try {
                                                $endFormat = 'd/m/Y';
                                                $endStr = $scheduleItem['fecha_final'];
                                                if (isset($scheduleItem['hora_final'])) {
                                                    $endFormat .= ' H:i';
                                                    $endStr .= ' ' . $scheduleItem['hora_final'];
                                                }
                                                $fechaFinalCarbon = \Carbon\Carbon::createFromFormat($endFormat, $endStr);
                                                if (!isset($scheduleItem['hora_final'])) {
                                                    $fechaFinalCarbon->setTime(23, 59, 59);
                                                }
                                                $fechaLimiteStr = $fechaFinalCarbon->format('d/m/Y H:i');

                                                if (!$homeworks->has($clase->id)) {
                                                    if ($now->gt($fechaFinalCarbon)) {
                                                        $isClosed = true;
                                                        $estadoStr = '<span class="badge badge-danger">Cerrada</span>';
                                                    } else {
                                                        if (isset($scheduleItem['fecha_inicial'])) {
                                                            $startFormat = 'd/m/Y';
                                                            $startStr = explode(' ', $scheduleItem['fecha_inicial'])[0];
                                                            $fechaInicialCarbon = \Carbon\Carbon::createFromFormat($startFormat, $startStr);
                                                            $reminderStartDate = $fechaInicialCarbon->copy()->addDays(2);
                                                            
                                                            if ($now->gte($reminderStartDate)) {
                                                                $estadoStr = '<span class="badge text-white" style="background-color: #e6a23c;">Atrasada</span>';
                                                            }
                                                        }
                                                    }
                                                }
                                            } catch (\Exception $e) {}
                                        }

                                        // Check for individual unlock
                                        $unlock = $unlockedLessonsData->get($clase->id);
                                        if ($unlock) {
                                            $fechaLimiteStr = \Carbon\Carbon::parse($unlock->until_date)->format('d/m/Y H:i');
                                            if (!$homeworks->has($clase->id)) {
                                                if ($now->gt(\Carbon\Carbon::parse($unlock->until_date))) {
                                                    $estadoStr = '<span class="badge badge-danger">Cerrada (DP)</span>';
                                                    $isClosed = true;
                                                } else {
                                                    $estadoStr = '<span class="badge badge-info">Bloqueo Removido</span>';
                                                    $isClosed = false;
                                                }
                                            }
                                        }

                                        if ($homeworks->has($clase->id)) {
                                            $hw = $homeworks[$clase->id];
                                            if ($hw->is_late) {
                                                $estadoStr = '<span class="badge badge-success">Entregado</span> <span class="badge badge-danger">Atrasado</span>';
                                            } else {
                                                $estadoStr = '<span class="badge badge-success">Entregado</span>';
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center align-middle" style="width: 50px;">
                                            <i class="fas fa-level-up-alt fa-rotate-90 text-muted"></i>
                                        </td>
                                        <td class="pl-3 align-middle">{{ $clase->titulo }}</td>
                                        <td class="align-middle">
                                            {!! $estadoStr !!} 
                                            @if($isClosed || $unlock)
                                                <button class="btn btn-sm btn-link p-0 ml-1 text-primary btn-unlock" 
                                                        title="{{ $unlock ? 'Editar Desbloqueo' : 'Desbloquear' }}"
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
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $fechaLimiteStr }}</td>
                                        <td class="align-middle">
                                            @if ($homeworks->has($clase->id))
                                                {{ $homeworks[$clase->id]->created_at->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
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
                <h5 class="modal-title">Desbloquear Lección Escolarmente</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Estás permitiendo que el alumno entregue su tarea para: <strong id="unlock-lesson-title"></strong></p>
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
