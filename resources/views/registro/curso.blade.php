@extends('layouts.adminmart.default')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $curso_programado->Curso->titulo
                }}
            </h3>
        </div>
        <div class="col-5 align-self-center">
            <div class="customize-input float-right">
                <button class="btn btn-sm btn-outline-info rounded-pill btn-tutorial-animate" onclick="startTutorial()">
                    <i class="far fa-question-circle"></i> Ver Tutorial
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            @if ($curso_programado->Curso->imagen)
            <img class="card-img-top img-fluid"
                src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso_programado->Curso->imagen]) }}"
                alt="Card image cap">
            @else
            <img class="card-img-top img-fluid" src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                alt="Card image cap">
            @endif
            <div class="card-body">
                <p class="card-text">{!! $curso_programado->Curso->descripcion !!}</p>
                <h4 class="card-title">Módulos</h4>
                <div class="list-group">
                    @php
                    $hoy = strtotime(date('d-m-Y'));
                    $contenido = collect($contenido_programado->contenido ?? []);
                    // Ordenar módulos según el campo "orden" en contenido_programado
                    $modulos = $curso_programado->Curso->Lecciones
                    ->sortBy(function ($modulo) use ($contenido) {
                    $item = $contenido->firstWhere('id', $modulo->id);
                    return $item['orden'] ?? 0;
                    })
                    ->values();
                    @endphp

                    @foreach ($modulos as $modulo)
                    @php
                    $item_contenido = $contenido->firstWhere('id', $modulo->id);
                    $fecha_inicial = isset($item_contenido['fecha_inicial'])
                    ? strtotime(str_replace('/', '-', $item_contenido['fecha_inicial']))
                    : null;
                    $fecha_final = isset($item_contenido['fecha_final'])
                    ? (isset($item_contenido['hora_final']) ? strtotime(str_replace('/', '-', $item_contenido['fecha_final'].' '.$item_contenido['hora_final'])) : strtotime(str_replace('/', '-', $item_contenido['fecha_final'].' 23:59:59')))
                    : 0; 
                        
                    $unlockData = isset($unlockedLessonsData) ? $unlockedLessonsData->get($modulo->id) : null;
                    if ($unlockData) {
                        $fecha_final = strtotime($unlockData->until_date);
                    }
                        
                    $verifica_fecha = $hoy >= $fecha_inicial && $hoy <= $fecha_final; @endphp @if ($inscrito==null ||
                        ($inscrito !=null && $inscrito->aceptado == 'no'))
                        <a href="javascript:void(0)" class="list-group-item disabled">{{ $modulo->titulo }}</a>
                        @elseif($inscrito != null && $inscrito->aceptado == 'si')
                        @if ($verifica_fecha)
                        <a href="javascript:void(0)" class="list-group-item"
                            onclick="event.preventDefault(); document.getElementById('form{{ $modulo->id }}').submit();">
                            {{ $modulo->titulo }}
                        </a>
                        <form method="POST" action="{{ route('leccion.detallada') }}" id="form{{ $modulo->id }}">
                            @csrf
                            <input name="leccion_id" type="hidden" value="{{ $modulo->id }}">
                            <input name="curso_programado_id" type="hidden" value="{{ $curso_programado->id }}">
                            <input name="inscripcion_id" type="hidden" value="{{ $inscrito->id }}">
                        </form>
                        @else
                        <a href="javascript:void(0)" class="list-group-item disabled">{{ $modulo->titulo }}</a>
                        @endif
                        @endif
                        @endforeach
                </div>
            </div>
            <div class="card-footer text-muted"></div>
        </div>
    </div>

    <div class="col-md-4">

        {{-- Global Progress & Menu Card --}}
        {{-- <div class="card shadow-sm border-0 mb-3">
            <div class="card-body p-0 sidebar-content"> --}}
                {{-- Global Progress Bar --}}
               {{--  <div class="p-3 border-bottom bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted font-weight-bold">Progreso del Curso</small>
                        <span class="badge badge-primary" id="global-progress-text">{{ $globalProgress }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div id="global-progress-bar" class="progress-bar bg-success" role="progressbar"
                            style="width: {{ $globalProgress }}%;" aria-valuenow="{{ $globalProgress }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div> --}}

                {{-- Accordion Menu --}}
       {{--          <div id="accordion" class="accordion">
                    @foreach($curso_programado->Curso->Lecciones as $modulo)
                    <div class="card mb-0">
                        <div class="card-header" id="heading{{ $modulo->id }}">
                            <h5 class="mb-0">
                                <button
                                    class="btn btn-link w-100 text-left d-flex justify-content-between align-items-center"
                                    data-toggle="collapse" data-target="#collapse{{ $modulo->id }}"
                                    aria-expanded="false" aria-controls="collapse{{ $modulo->id }}">
                                    <span class="text-truncate" style="max-width: 80%;">{{ $modulo->titulo }}</span>
                                    <i class="fas fa-chevron-down text-muted" style="font-size: 0.8rem;"></i>
                                </button>
                            </h5>
                            @if($modulo->progress > 0)
                            <div class="px-3 pb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        Progreso: {{ $modulo->completedCount }}/{{ $modulo->totalClases }}
                                    </small>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $modulo->progress
                                        }}%</small>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $modulo->progress }}%;" aria-valuenow="{{ $modulo->progress }}"
                                        aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div id="collapse{{ $modulo->id }}" class="collapse" aria-labelledby="heading{{ $modulo->id }}"
                            data-parent="#accordion">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach($modulo->Clases as $clase)
                                    @php
                                    $isCompleted = in_array($clase->id, $completedLessons);
                                    @endphp
                                    <a href="javascript:void(0)"
                                        onclick="event.preventDefault(); document.getElementById('form-menu-{{ $clase->id }}').submit();"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center" style="max-width: 90%;">
                                            <i class="far {{ $isCompleted ? 'fa-check-circle text-success' : 'fa-circle text-muted' }} mr-2"
                                                style="font-size: 0.9em;"></i>
                                            <span class="text-truncate">{{ $clase->titulo }}</span>
                                        </div>
                                    </a>
                                    <form method="POST" action="{{ route('leccion.detallada') }}"
                                        id="form-menu-{{ $clase->id }}">
                                        @csrf
                                        <input name="leccion_id" type="hidden" value="{{ $clase->id }}">
                                        <input name="curso_programado_id" type="hidden"
                                            value="{{ $curso_programado->id }}">
                                        <input name="inscripcion_id" type="hidden" value="{{ $inscrito->id ?? '' }}">
                                    </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-body">
                @if ($inscrito == null)
                <a href="{{ route('inscripcion.form', ['curso_programado_id' => $curso_programado->id]) }}"
                    class="btn btn-block btn-dark btn-detalle">Inscribir</a>
                @elseif($inscrito->aceptado == 'no')
                <div class="alert alert-warning bg-warning text-white border-0" role="alert">
                    Aprobración <strong>Pendiente</strong>
                </div>
                @else
                <div class="alert alert-success" role="alert">
                    <strong>En Curso</strong>
                </div>
                <a href="{{ route('alumno.curso.lista-resultados', ['inscripcion_id' => $inscrito->id]) }}"
                    class="btn btn-block btn-info">Ver Calificaciones</a>
                <a href="{{ route('alumno.curso.homework.tracking', ['curso_programado_id' => $curso_programado->id]) }}"
                    class="btn btn-block btn-primary mt-2">Ver Mis Tareas</a>
                <a href="{{ route('alumno.curso.progress', ['curso_programado_id' => $curso_programado->id]) }}"
                    class="btn btn-block btn-success mt-2">Mi Progreso</a>
                @endif

                <small class="d-block mt-3">
                    Inicia: {{ date('d/m/Y', strtotime($curso_programado->fecha_inicio)) }}<br>
                    Finaliza: {{ date('d/m/Y', strtotime($curso_programado->fecha_fin)) }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            if (!window.driver || !window.driver.js || !window.driver.js.driver) {
                console.error('Driver.js is not loaded correctly.');
                return;
            }

            const driver = window.driver.js.driver;

            const driverObj = driver({
                showProgress: true,
                animate: true,
                doneBtnText: 'Entendido',
                nextBtnText: 'Siguiente',
                prevBtnText: 'Anterior',
                steps: [{
                        element: '.page-breadcrumb',
                        popover: {
                            title: 'Detalles del Curso',
                            description: 'Aquí encontrarás toda la información detallada del curso seleccionado.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    {
                        element: '#accordion',
                        popover: {
                            title: 'Navegación del Curso',
                            description: 'Usa este menú para navegar entre los módulos y clases del curso.',
                            side: "left",
                            align: 'start'
                        }
                    }
                ]
            });

            window.startTutorial = function() {
                console.log('Starting tutorial...');
                driverObj.drive();
            };

        } catch (error) {
            console.error('Error initializing tutorial:', error);
        }
    });
</script>
@endsection