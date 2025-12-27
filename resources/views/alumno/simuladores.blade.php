@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb mb-4">
        <div class="row">
            <div class="col-7">
                <h2 class="page-title font-weight-bold text-dark mb-0">{{ Auth::user()->nombre_completo }}</h2>
                <p class="text-muted h5">Simuladores disponibles</p>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">
                    <button class="btn btn-sm btn-outline-info rounded-pill" onclick="startTutorial()">
                        <i class="far fa-question-circle"></i> Ver Tutorial
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach ($cursos as $curso)
            @if ($curso->curso->activo === 'si' && $curso->category_id === $category->id)
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card shadow-sm border-0 rounded-lg w-100 d-flex flex-column">
                        <a href="javascript:void(0)"
                            onclick="event.preventDefault(); document.getElementById('curso-{{ $curso->id }}').submit();">
                            @if ($curso->Curso->imagen)
                                <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                                    alt="Imagen del curso" class="card-img-top rounded-top img-fluid"
                                    style="height: auto; object-fit: cover;">
                            @else
                                <img src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}" alt="Curso"
                                    class="card-img-top rounded-top img-fluid" style="height: 200px; object-fit: cover;">
                            @endif
                        </a>

                        <form method="POST" action="{{ route('cursos.detallado') }}" id="curso-{{ $curso->id }}">
                            @csrf
                            <input type="hidden" name="curso_programado_id" value="{{ $curso->id }}">
                        </form>

                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title font-weight-bold text-dark mb-2">
                                {{ $curso->Curso->titulo }}
                                <span class="badge badge-primary ml-1">{{ $curso->identificador }}</span>
                            </h3>

                            <p class="mb-2 text-success small">
                                <i class="fas fa-clock mr-1"></i>
                                Quedan {{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($curso->fecha_fin_venta), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                                para cerrar inscripciones
                            </p>

                            <div class="mb-2 text-muted small" style="min-height: 100px;">
                                {!! $curso->Curso->descripcion !!}
                            </div>

                            <p class="text-dark mb-2">
                                <strong>Inicio:</strong>
                                {{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }} -
                                <strong>Fin:</strong> {{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}
                            </p>

                            <h5 class="mt-2 font-weight-bold text-primary">
                                ${{ $curso->precio_en_moneda }} MXN
                            </h5>

                            <div class="mt-auto">
                                <a href="{{ route('inscripcion.form', ['curso_programado_id' => $curso->id]) }}"
                                    class="btn btn-block btn-sm mt-3 text-white" style="background-color: #1c2d41;">
                                    <i class="fas fa-check-circle mr-1"></i> Inscribirme
                                </a>

                                <a href="javascript:void(0)" class="btn btn-block btn-sm mt-2 text-white"
                                    style="background-color: #ed6a5a;"
                                    onclick="event.preventDefault(); document.getElementById('curso-{{ $curso->id }}').submit();">
                                    <i class="fas fa-info-circle mr-1"></i> Más detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('cursoid')
            document.querySelector(".modal-footer form input").setAttribute("value", id)
        })

        const driver = window.driver.js.driver;
        const driverObj = driver({
            showProgress: true,
            animate: true,
            doneBtnText: 'Entendido',
            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
            steps: [
                { 
                    element: '.page-breadcrumb', 
                    popover: { 
                        title: 'Simuladores de Examen', 
                        description: 'Practica con exámenes similares a los reales en esta sección.',
                        side: "bottom", 
                        align: 'start' 
                    } 
                },
                { 
                    element: '.card:first-child', 
                    popover: { 
                        title: 'Tarjeta de Simulador', 
                        description: 'Aquí verás los detalles del simulador, incluyendo su vigencia y costo.',
                        side: "right", 
                        align: 'start' 
                    } 
                },
                { 
                    element: '.card:first-child a[href*="inscripcion"]', 
                    popover: { 
                        title: 'Inscribir Simulador', 
                        description: 'Usa este botón para adquirir acceso al simulador.',
                        side: "top", 
                        align: 'center' 
                    } 
                },
                { 
                    element: '.card:first-child a[onclick*="submit"]', 
                    popover: { 
                        title: 'Más Detalles', 
                        description: 'Revisa la información completa del simulador antes de inscribirte.',
                        side: "top", 
                        align: 'center' 
                    } 
                }
            ]
        });

        function startTutorial() {
            driverObj.drive();
        }

        if (!localStorage.getItem('simulators_tutorial_seen')) {
            setTimeout(() => {
                startTutorial();
                localStorage.setItem('simulators_tutorial_seen', 'true');
            }, 1000);
        }
    </script>
@endsection
