@extends('layouts.adminmart.default')



@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $leccion->Curso->titulo }}</h3>
            <div class="d-flex align-items-center">
                <div class="mr-3">{{ $leccion->titulo }}</div>
            </div>
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
    {{-- Columna izquierda: video y contenido --}}
    <div class="col-md-8">
        <div class="card">
            @if (isset($video) || isset($videoext))
            @php
                $videoObject = $video ?? $videoext;
                $streamRoute = auth()->user()->hasRole('alumno') === false 
                    ? route(Auth::user()->rol[0]->slug . '.medias.stream2', ['filename' => $videoObject->ruta])
                    : route(Auth::user()->rol[0]->slug . '.medias.stream', ['filename' => $videoObject->ruta]);
            @endphp
            <div style="text-align: center">
                <video id="videoClase" style="width:100%" src="{{ $streamRoute }}" controls
                    preload="metadata" controlsList="nodownload">
                    Tu navegador no soporta la etiqueta video.
                </video>
            </div>
            @else
            @if($leccion->imagen)
            <img class="card-img-top img-fluid"
                src="{{ route(Auth::user()->rol[0]->slug . '.lecciones.image', ['file' => $leccion->imagen]) }}"
                alt="Card image cap">
            @endif
            @endif

            <div class="card-body" id="clases">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">{{ $leccion->titulo }}</h4>

                    @if($leccion->leccion_id > 0)
                    @php
                    $isCompleted = in_array($leccion->id, $completedLessons);
                    @endphp
                    <button id="btn-complete"
                        class="btn {{ $isCompleted ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill"
                        onclick="toggleCompletion({{ $leccion->id }}, {{ $curso_programado_id }})">
                        <i class="fas {{ $isCompleted ? 'fa-check' : 'fa-check-circle' }} mr-1"></i>
                        <span id="btn-complete-text">{{ $isCompleted ? 'Completado' : 'Marcar como visto' }}</span>
                    </button>
                    @endif
                </div>



                <div class="card-text mb-4">{!! $leccion->contenido !!}</div>

                @if (count($leccion->Clases))
                <h4 class="card-title">Clases</h4>
                @php
                $hoy = strtotime(date('d-m-Y'));
                $contenido = collect($contenido_programado->contenido ?? []);

                // Ordenar clases según el campo 'orden'
                $clases_ordenadas = collect($leccion->Clases)
                ->sortBy(function ($c) use ($contenido) {
                $item = $contenido->firstWhere('id', $c->id);
                return $item['orden'] ?? 0;
                })
                ->values();
                @endphp

                <div class="list-group list-group-custom">
                    @foreach ($clases_ordenadas as $item)
                        @if ($item->curso_id == $leccion->Curso->id)
                            @php
                                $item_contenido = $contenido->firstWhere('id', $item->id);
                                $fecha_inicial = isset($item_contenido['fecha_inicial']) ? strtotime(str_replace('/', '-', $item_contenido['fecha_inicial'])) : null;
                                $fecha_final = isset($item_contenido['fecha_final']) ? (isset($item_contenido['hora_final']) ? strtotime(str_replace('/', '-', $item_contenido['fecha_final'] . ' ' . $item_contenido['hora_final'])) : strtotime(str_replace('/', '-', $item_contenido['fecha_final'] . ' 23:59:59'))) : 0;

                                $unlockData = isset($unlockedLessonsData) ? $unlockedLessonsData->get($item->id) : null;
                                if ($unlockData) {
                                    $fecha_final = strtotime($unlockData->until_date);
                                }

                                $childUnlocked = $item->Clases->contains(function ($clase) use ($unlockedLessonsData) {
                                    return isset($unlockedLessonsData) && $unlockedLessonsData->has($clase->id);
                                });

                                $verifica_fecha = ($hoy >= $fecha_inicial && $hoy <= $fecha_final) || $childUnlocked;
                                $isCompleted = in_array($item->id, $completedLessons);
                            @endphp
                            
                            @if ($verifica_fecha)
                                <a href="javascript:void(0)"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 mb-2 shadow-sm border-left-primary"
                                    onclick="event.preventDefault(); document.getElementById('form{{ $item->id }}').submit();"
                                    style="border-left: 4px solid #002146 !important; border-radius: 8px; transition: all 0.2s ease-in-out; background-color: #ffffff;">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%; background-color: {{ $isCompleted ? '#e8f5e9' : '#e3f2fd' }};">
                                            <i class="fas {{ $isCompleted ? 'fa-check text-success' : 'fa-play text-primary' }}" style="font-size: 0.9rem;"></i>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold text-dark d-block">{{ $item->titulo }}</span>
                                            <small class="text-muted">{{ $isCompleted ? 'Completada' : 'Disponible para ver' }}</small>
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted small"></i>
                                </a>
                                <form method="POST" action="{{ route('leccion.detallada') }}" id="form{{ $item->id }}">
                                    @csrf
                                    <input name="leccion_id" type="hidden" value="{{ $item->id }}">
                                    <input name="curso_programado_id" type="hidden" value="{{ $curso_programado_id }}">
                                    <input name="inscripcion_id" type="hidden" value="{{ $inscrito->id }}">
                                </form>
                            @else
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3 mb-2"
                                    style="background-color: #fcfcfc; border-radius: 8px; border-left: 4px solid #dee2e6 !important; opacity: 0.8;">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%; background-color: #f8f9fa; color: #adb5bd;">
                                            <i class="fas fa-lock" style="font-size: 0.9rem;"></i>
                                        </div>
                                        <div>
                                            <span class="font-weight-medium text-muted d-block">{{ $item->titulo }}</span>
                                            <small class="text-muted">No disponible aún</small>
                                        </div>
                                    </div>
                                    <span class="badge badge-light text-muted p-2">Bloqueado</span>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Columna derecha: multimedia, tareas y pruebas --}}
    <div class="col-md-4">
        {{-- Accordion for Modules --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body p-0 sidebar-content">
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
                {{-- <div id="accordion" class="accordion">
                    @foreach($curso_programado->Curso->Lecciones as $modulo)
                    <div class="card mb-0">
                        <div class="card-header" id="heading{{ $modulo->id }}">
                            <h5 class="mb-0">
                                <button
                                    class="btn btn-link w-100 text-left d-flex justify-content-between align-items-center"
                                    data-toggle="collapse" data-target="#collapse{{ $modulo->id }}"
                                    aria-expanded="{{ $leccion->leccion_id == $modulo->id ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $modulo->id }}">
                                    <span class="text-truncate" style="max-width: 80%;">{{ $modulo->titulo }}</span>
                                    <i class="fas fa-chevron-down text-muted" style="font-size: 0.8rem;"></i>
                                </button>
                            </h5>
                            @if($modulo->progress > 0)
                            <div class="px-3 pb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted" style="font-size: 0.7rem;"
                                        id="progress-count-{{ $modulo->id }}">Progreso: {{ $modulo->completedCount }}/{{
                                        $modulo->totalClases }}</small>
                                    <small class="text-muted" style="font-size: 0.7rem;"
                                        id="progress-text-{{ $modulo->id }}">{{ $modulo->progress }}%</small>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div id="progress-bar-{{ $modulo->id }}" class="progress-bar bg-success"
                                        role="progressbar" style="width: {{ $modulo->progress }}%;"
                                        aria-valuenow="{{ $modulo->progress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div id="collapse{{ $modulo->id }}"
                            class="collapse {{ $leccion->leccion_id == $modulo->id || $leccion->id == $modulo->id ? 'show' : '' }}"
                            aria-labelledby="heading{{ $modulo->id }}" data-parent="#accordion">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach($modulo->Clases as $clase)
                                    @php
                                    $isActive = $leccion->id == $clase->id;
                                    $isCompleted = in_array($clase->id, $completedLessons);
                                    @endphp
                                    <a href="javascript:void(0)"
                                        onclick="event.preventDefault(); document.getElementById('form{{ $clase->id }}').submit();"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $isActive ? 'active' : '' }}">
                                        <div class="d-flex align-items-center" style="max-width: 90%;">
                                            <i id="icon-lesson-{{ $clase->id }}"
                                                class="far {{ $isCompleted ? 'fa-check-circle text-success' : 'fa-circle text-muted' }} mr-2"
                                                style="font-size: 0.9em;"></i>
                                            <span class="text-truncate">{{ $clase->titulo }}</span>
                                        </div>
                                        @if($m = $clase->Medias->where('tipo','video')->first())
                                        <i class="fas fa-play-circle text-muted" style="font-size: 0.9em;"></i>
                                        @endif
                                    </a>
                                    <form method="POST" action="{{ route('leccion.detallada') }}"
                                        id="form{{ $clase->id }}">
                                        @csrf
                                        <input name="leccion_id" type="hidden" value="{{ $clase->id }}">
                                        <input name="curso_programado_id" type="hidden"
                                            value="{{ $curso_programado_id }}">
                                        <input name="inscripcion_id" type="hidden" value="{{ $inscrito->id }}">
                                    </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> --}}
            </div>
        </div>

        @if ($leccion->Medias->count())
        <div class="card" id="card-multimedia">
            <div class="card-body">
                <h4 class="card-title">Multimedia</h4>
                <div class="list-group">
                    @foreach ($leccion->Medias as $m)
                    @if ($m->tipo == 'liga')
                    <a class="list-group-item" href="{{ $m->ruta }}" target="_blank">Ir a la liga</a>
                    @elseif($m->tipo == 'imagen')
                    <a class="list-group-item btn-detalle" href="javascript:void(0)"
                        id="{{ route('alumnos.medias.show', $m->id) }}">Ver la imagen</a>
                    @elseif($m->tipo == 'archivo')
                    @if (!$m->downloadable)
                    <form action="{{ route('alumno.view.guias') }}" method="post">
                        @csrf
                        <input type="hidden" name="file"
                            value="{{ URL::route(Auth::user()->rol[0]->slug . '.medias.archivo', ['file' => $m->ruta]) }}">
                        <input type="hidden" name="titulo" value="{{ $leccion->Curso->titulo }}">
                        <button type="submit" class="list-group-item btn-block text-left">Ver
                            Documento</button>
                    </form>
                    @else
                    <a class="list-group-item my-2"
                        href="{{ URL::route(Auth::user()->rol[0]->slug . '.medias.archivo', ['file' => $m->ruta]) }}">Descargar
                        archivo</a>
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if ($curso_programado->category->name != 'Guias')
        <div class="card" id="card-tareas">
            <div class="card-body">
                <h4 class="card-title">Tareas</h4>
                <div class="list-group">
                    <a class="list-group-item" @if (isset($homework))
                        style="pointer-events: none; cursor: default; background-color: #e9ecef;" @endif
                        href="{{ route('alumno.lecciones.tarea', ['leccion_id' => $leccion->id, 'curso_programado_id' => $curso_programado_id]) }}">Enviar
                        tarea {{ strtolower($leccion->titulo) }} @if (isset($homework))
                        {{-- icono check --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green"
                            class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.001-1.05z" />
                        </svg>
                        @else
                        {{-- icono de pendiente con reloj --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="orange"
                            class="bi bi-clock-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0v5.25c0.3.243.2.432.5.432h3.25a.5.5 0 0 0 0-1H8V3.5z" />
                        </svg>
                        @endif
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if ($leccion->materialPdfs->count())
        <div class="card shadow-sm border-0 mb-3" id="card-material-pdfs">
            <div class="card-body">
                <h4 class="card-title text-primary"><i class="far fa-file-pdf mr-2"></i>Material Interactivo</h4>
                <p class="text-muted small">Haz clic en resolver para contestar las preguntas directamente en la pantalla.</p>
                <div class="list-group">
                    @foreach ($leccion->materialPdfs as $material)
                    <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-3 mb-2 shadow-xs" style="border-radius: 8px; background-color: #fff; border: 1px solid #e9ecef;">
                        <span class="font-weight-bold text-dark text-truncate mr-2" style="max-width: 60%;">{{ $material->titulo }}</span>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('alumno.material-pdfs.show', $material->id) }}" class="btn btn-xs btn-primary mr-1" style="font-size: 0.75rem; padding: 4px 8px;">
                                <i class="fas fa-edit mr-1"></i> Resolver
                            </a>
                            <a href="{{ route('alumno.material-pdfs.download-raw', $material->id) }}" class="btn btn-xs btn-outline-secondary" style="font-size: 0.75rem; padding: 4px 8px;" title="Descargar PDF Original">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if ($leccion->Pruebas->count())
        <div class="card examen">
            <div class="card-body">
                <h4 class="card-title">Pruebas</h4>
                <div class="list-group">
                    @foreach ($leccion->Pruebas as $item)
                    @if ($item->Preguntas->count())
                    <a href="javascript:void(0)" class="list-group-item btn-detalle"
                        id="{{ route('examen.previo', ['prueba_id' => $item->id, 'inscripcion_id' => $inscripcion_id]) }}">
                        {{ $item->titulo }}
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">Titulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelar">Cancelar</button>
                <button type="button" class="btn btn-primary" id="continuar">Continuar...</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
<script src="{{ asset('js/funciones.js') }}"></script>
@if (isset($video) || isset($videoext))
<script type="text/javascript">
    $(document).ready(function () {
        $("body").on("contextmenu", function (e) {
            return false;
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').bind('cut copy paste', function (e) {
            e.preventDefault();
        });
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            if (!window.driver || !window.driver.js || !window.driver.js.driver) {
                console.error('Driver.js is not loaded correctly.');
                return;
            }
            const driverConstructor = window.driver.js.driver;

            // Main Driver
            const driverObj = driverConstructor({
                showProgress: true,
                animate: true,
                doneBtnText: 'Entendido',
                nextBtnText: 'Siguiente',
                prevBtnText: 'Anterior',
                steps: [{
                    element: '.page-breadcrumb',
                    popover: {
                        title: 'Aula Virtual',
                        description: 'Estás en la vista de lección. Aquí consumirás el contenido de tu curso.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '.col-md-8 .card',
                    popover: {
                        title: 'Contenido Principal',
                        description: 'Aquí aparecerá el video de la clase o la imagen representativa.',
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
                },
                {
                    element: '#card-multimedia',
                    popover: {
                        title: 'Multimedia y Recursos',
                        description: 'Aquí encontrarás archivos descargables, enlaces y materiales extra para apoyar tu aprendizaje.',
                        side: "left",
                        align: 'start'
                    }
                },
                {
                    element: '#card-tareas',
                    popover: {
                        title: 'Sección de Tareas',
                        description: 'En este apartado podrás adjuntar tus archivos y enviar tus tareas para calificación.',
                        side: "left",
                        align: 'start'
                    }
                },
                {
                    element: '.card.examen',
                    popover: {
                        title: 'Exámenes y Resultados',
                        description: 'Aquí aparecerán tus exámenes disponibles.',
                        side: "left",
                        align: 'start'
                    }
                },
                {
                    element: '.card.examen .btn-detalle',
                    popover: {
                        title: 'Seleccionar Prueba',
                        description: 'Haz clic en el nombre de la prueba para ver las instrucciones previas.',
                        side: "left",
                        align: 'center'
                    }
                },
                {
                    element: '#myModal .modal-content',
                    popover: {
                        title: 'Instrucciones Previas',
                        description: 'Se abrirá esta ventana con información vital: tiempo límite, intentos disponibles y reglas de conducta (no copiar/pegar, no cambiar de pestaña).',
                        side: "top",
                        align: 'center'
                    },
                    onHighlightStarted: (element) => {
                         const btn = document.querySelector('.card.examen .btn-detalle');
                         if (btn && !document.querySelector('#myModal').classList.contains('show')) {
                             btn.click();
                         }
                    },
                    onDeselected: (element) => {
                        $('#myModal').modal('hide');
                    }
                }
                ]
            });

            window.startTutorial = function() {
                driverObj.drive();
            };

            @if (session('examen_finalizado'))
                const feedbackDriver = driverConstructor({
                    showProgress: true,
                    animate: true,
                    doneBtnText: 'Entendido',
                    nextBtnText: 'Siguiente',
                    prevBtnText: 'Anterior',
                    steps: [{
                        element: '.card.examen .btn-detalle',
                        popover: {
                            title: 'Resultados Disponibles',
                            description: 'Has finalizado tu examen. Haz clic aquí nuevamente para ver tus resultados.',
                            side: "left",
                            align: 'center'
                        }
                    },
                    {
                        element: '#myModal .modal-content',
                        popover: {
                            title: 'Retroalimentación',
                            description: 'Aquí verás tu puntaje obtenido y las opciones para revisar tus respuestas si están habilitadas.',
                            side: "top",
                            align: 'center'
                        },
                        onHighlightStarted: (element) => {
                            const btn = document.querySelector('.card.examen .btn-detalle');
                            if (btn && !document.querySelector('#myModal').classList.contains('show')) {
                                btn.click();
                            }
                        },
                        onDeselected: (element) => {
                            $('#myModal').modal('hide');
                        }
                    }
                    ]
                });

                setTimeout(() => {
                    feedbackDriver.drive();
                }, 1000);
            @else
                if (!localStorage.getItem('lesson_tutorial_seen')) {
                    setTimeout(() => {
                        window.startTutorial();
                        localStorage.setItem('lesson_tutorial_seen', 'true');
                    }, 1000);
                }
            @endif

        } catch (e) {
            console.error('Error initializing tutorial:', e);
        }
    });

    function toggleCompletion(leccionId, cursoProgramadoId) {
        var btn = $('#btn-complete');
        var btnText = $('#btn-complete-text');
        var icon = btn.find('i');

        $.ajax({
            url: "{{ route('leccion.toggleCompletion') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                leccion_id: leccionId,
                curso_programado_id: cursoProgramadoId
            },
            success: function (response) {
                // Update Button State
                if (response.status === 'marked') {
                    btn.removeClass('btn-outline-secondary').addClass('btn-success');
                    icon.removeClass('fa-check-circle').addClass('fa-check');
                    btnText.text('Completado');
                    // Update list icon to check
                    $('#icon-lesson-' + leccionId).removeClass('fa-circle text-muted').addClass('fa-check-circle text-success');
                } else {
                    btn.removeClass('btn-success').addClass('btn-outline-secondary');
                    icon.removeClass('fa-check').addClass('fa-check-circle');
                    btnText.text('Marcar');
                    // Update list icon to circle
                    $('#icon-lesson-' + leccionId).removeClass('fa-check-circle text-success').addClass('fa-circle text-muted');
                }

                // Update Global Progress
                $('#global-progress-text').text(response.globalProgress + '%');
                $('#global-progress-bar').css('width', response.globalProgress + '%').attr('aria-valuenow', response.globalProgress);

                // Update Module Progress
                var moduleId = response.moduleId;
                var modProgress = response.moduleProgress;
                var modCompleted = response.moduleCompleted;
                var modTotal = response.moduleTotal;

                $('#progress-text-' + moduleId).text(modProgress + '%');
                $('#progress-bar-' + moduleId).css('width', modProgress + '%').attr('aria-valuenow', modProgress);
                $('#progress-count-' + moduleId).text('Progreso: ' + modCompleted + '/' + modTotal);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Hubo un error al actualizar el estado de la lección.');
            }
        });
    }
</script>
@endsection