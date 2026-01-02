@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $leccion->Curso->titulo }}</h3>
                <div class="d-flex align-items-center">
                    <div class="mr-3">{{ $leccion->titulo }}</div>
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
                    <div style="text-align: center">
                        <video style="width:100%" src="https://sapius.com.mx/storage/{{ $video->ruta }}" controls
                            controlsList="nodownload">
                            Tu navegador no soporta la etiqueta video.
                        </video>
                    </div>
                @else
                    <img class="card-img-top img-fluid"
                        src="{{ $leccion->imagen ? route(Auth::user()->rol[0]->slug . '.lecciones.image', ['file' => $leccion->imagen]) : asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                        alt="Card image cap">
                @endif

                <div class="card-body" id="clases">
                    <h4 class="card-title">{{ $leccion->titulo }}</h4>
                    <p class="card-text">{!! $leccion->contenido !!}</p>

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

                        <div class="list-group">
                            @foreach ($clases_ordenadas as $item)
                                @if ($item->curso_id == $leccion->Curso->id)
                                    @php
                                        $item_contenido = $contenido->firstWhere('id', $item->id);
                                        $fecha_inicial = isset($item_contenido['fecha_inicial'])
                                            ? strtotime(str_replace('/', '-', $item_contenido['fecha_inicial']))
                                            : null;
                                        $fecha_final = isset($item_contenido['fecha_final'])
                                            ? strtotime(str_replace('/', '-', $item_contenido['fecha_final']))
                                            : null;
                                        $verifica_fecha = $hoy >= $fecha_inicial && $hoy <= $fecha_final;
                                    @endphp

                                    @if ($verifica_fecha)
                                        <a href="javascript:void(0)" class="list-group-item"
                                            onclick="event.preventDefault(); document.getElementById('form{{ $item->id }}').submit();">
                                            {{ $item->titulo }}
                                        </a>
                                        <form method="POST" action="{{ route('leccion.detallada') }}"
                                            id="form{{ $item->id }}">
                                            @csrf
                                            <input name="leccion_id" type="hidden" value="{{ $item->id }}">
                                            <input name="curso_programado_id" type="hidden"
                                                value="{{ $curso_programado_id }}">
                                            <input name="inscripcion_id" type="hidden" value="{{ $inscrito->id }}">
                                        </form>
                                    @else
                                        <a href="javascript:void(0)"
                                            class="list-group-item disabled">{{ $item->titulo }}</a>
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
                            <a class="list-group-item"
                                @if (isset($homework)) style="pointer-events: none; cursor: default; background-color: #e9ecef;" @endif
                                href="{{ route('alumno.lecciones.tarea', ['leccion_id' => $leccion->id, 'curso_programado_id' => $curso_programado_id]) }}"
                                target="_blank">Enviar tarea {{ strtolower($leccion->titulo) }} @if (isset($homework))
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
    @if (isset($video))
        <script>
            $(document).ready(function() {
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob';

                xhr.onload = function() {
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        var byteCharacters = atob(reader.result.slice(reader.result.indexOf(',') + 1));
                        var byteNumbers = new Array(byteCharacters.length);
                        for (var i = 0; i < byteCharacters.length; i++) {
                            byteNumbers[i] = byteCharacters.charCodeAt(i);
                        }
                        var byteArray = new Uint8Array(byteNumbers);
                        var blob = new Blob([byteArray], {
                            type: 'video/mp4'
                        });
                        var url = URL.createObjectURL(blob);
                        document.getElementById('videoClase').src = url;
                    }
                    reader.readAsDataURL(xhr.response);
                };
                @if (auth()->user()->hasRole('alumno') == false)
                    xhr.open('GET',
                        '{{ route(Auth::user()->rol[0]->slug . '.medias.stream2', ['filename' => $video->ruta]) }}'
                    );
                @else
                    xhr.open('GET',
                        '{{ route(Auth::user()->rol[0]->slug . '.medias.stream', ['filename' => $video->ruta]) }}');
                @endif
                xhr.send();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                //Disable full page
                $("body").on("contextmenu", function(e) {
                    return false;
                });

            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                //Disable full page
                $('body').bind('cut copy paste', function(e) {
                    e.preventDefault();
                });
            });
        </script>
    @endif

    <script>
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
                    element: '#clases .list-group',
                    popover: {
                        title: 'Navegación de Clases',
                        description: 'Usa esta lista para moverte entre las diferentes clases de este módulo.',
                        side: "top",
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

        function startTutorial() {
            driverObj.drive();
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if (session('examen_finalizado'))
                const feedbackDriver = driver({
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
                                if (btn && !document.querySelector('#myModal').classList.contains(
                                        'show')) {
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
                        startTutorial();
                        localStorage.setItem('lesson_tutorial_seen', 'true');
                    }, 1000);
                }
            @endif
        });
    </script>
@endsection
