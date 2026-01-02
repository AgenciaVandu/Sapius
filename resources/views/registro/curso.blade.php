@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $curso_programado->Curso->titulo }}
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
                                    ? strtotime(str_replace('/', '-', $item_contenido['fecha_final']))
                                    : null;
                                $verifica_fecha = $hoy >= $fecha_inicial && $hoy <= $fecha_final;
                            @endphp

                            @if ($inscrito == null || ($inscrito != null && $inscrito->aceptado == 'no'))
                                <a href="javascript:void(0)" class="list-group-item disabled">{{ $modulo->titulo }}</a>
                            @elseif($inscrito != null && $inscrito->aceptado == 'si')
                                @if ($verifica_fecha)
                                    <a href="javascript:void(0)" class="list-group-item"
                                        onclick="event.preventDefault(); document.getElementById('form{{ $modulo->id }}').submit();">
                                        {{ $modulo->titulo }}
                                    </a>
                                    <form method="POST" action="{{ route('leccion.detallada') }}"
                                        id="form{{ $modulo->id }}">
                                        @csrf
                                        <input name="leccion_id" type="hidden" value="{{ $modulo->id }}">
                                        <input name="curso_programado_id" type="hidden"
                                            value="{{ $curso_programado->id }}">
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
                    element: '.card-title',
                    popover: {
                        title: 'Estructura del Curso',
                        description: 'Esta lista muestra los módulos o lecciones que componen este curso.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '.list-group:first-of-type',
                    popover: {
                        title: 'Temario',
                        description: 'Aquí verás el contenido desglosado. Si ya estás inscrito, podrás acceder desde aquí.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '.col-md-4 .card',
                    popover: {
                        title: 'Panel de Acción',
                        description: 'Desde aquí puedes inscribirte, ver tu estado o acceder a tus calificaciones.',
                        side: "left",
                        align: 'start'
                    }
                },
                {
                    element: '.btn-detalle',
                    popover: {
                        title: 'Inscripción',
                        description: 'Si aún no estás inscrito, usa este botón para comenzar.',
                        side: "left",
                        align: 'start'
                    }
                }
            ]
        });

        function startTutorial() {
            driverObj.drive();
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (!localStorage.getItem('course_details_tutorial_seen')) {
                setTimeout(() => {
                    startTutorial();
                    localStorage.setItem('course_details_tutorial_seen', 'true');
                }, 1000);
            }
        });
    </script>
@endsection
