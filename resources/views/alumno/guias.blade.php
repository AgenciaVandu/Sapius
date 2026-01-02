@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    {{ Auth::user()->nombre_completo }}</h2>
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Guias disponibles</h3>
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
        <div class="col-md-12">
            <div class="card-columns">
                @foreach ($cursos as $curso)
                    @if ($curso->curso->activo == 'si' && $curso->category_id == $category->id)
                        <div class="card shadow">
                            <a href="javscript:void(0)"
                                onclick="event.preventDefault(); document.getElementById('curso-{{ $curso->id }}').submit();">
                                @if ($curso->Curso->imagen)
                                    <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                                        id="img" alt="..." class="img-thumbnail">
                                @else
                                    <img class="card-img-top img-fluid"
                                        src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                                        alt="Card image cap">
                                @endif
                            </a>
                            <form method="POST" action="{{ route('cursos.detallado') }}" id="curso-{{ $curso->id }}">
                                @csrf
                                <input name="curso_programado_id" type="hidden" value="{{ $curso->id }}">
                            </form>
                            <div class="card-body">
                                <h3 class="card-title">{{ $curso->Curso->titulo }} <span
                                        class="badge badge-primary">{{ $curso->identificador }}</span></h3>
                                <h3 class="card-text"><span
                                        class="badge badge-success shadow-sm">{{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($curso->fecha_fin_venta), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                                        para cerrar inscripciones</span></h3>
                                <p class="card-text">{!! $curso->Curso->descripcion !!}</p>
                                <p class="card-text"><strong>Inicia:</strong>
                                    {{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }} -
                                    <strong>Fin:</strong> {{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3> ${{ $curso->precio_en_moneda }} MxN</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="{{ route('inscripcion.form', ['curso_programado_id' => $curso->id]) }}"
                                            class="btn btn-block btn-dark btn-detalle">Inscribir</a>
                                        <a href="javscript:void(0)" class="btn btn-primary btn btn-block mt-2"
                                            onclick="event.preventDefault(); document.getElementById('curso-{{ $curso->id }}').submit();">
                                            Mas detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('cursoid') // Extract info from data-* attributes
            console.log(id)
            //var id = button.getAttribute('data-cursoid');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            //var modal = $(this)
            //console.log(id)
            var b = document.querySelector(".modal-footer form input")
            console.log(b)
            //modal.find('.modal-footer form button').setAttribute('value',''+recipient);
            //var buttonid = console.log(modal.find('.modal-footer form button'))
            b.setAttribute("value", id)
        })

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
                        title: 'Guías de Estudio',
                        description: 'Aquí encontrarás todas las guías disponibles para tu preparación.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '.card.shadow:first-child',
                    popover: {
                        title: 'Tarjeta de Guía',
                        description: 'Cada tarjeta representa una guía. Contiene información clave como título, fechas y precio.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '.card.shadow:first-child .btn-detalle',
                    popover: {
                        title: 'Inscribir Guía',
                        description: 'Haz clic aquí para iniciar el proceso de compra e inscripción.',
                        side: "top",
                        align: 'center'
                    }
                },
                {
                    element: '.card.shadow:first-child .btn-primary',
                    popover: {
                        title: 'Más Detalles',
                        description: 'Consulta el temario completo y la descripción detallada de la guía antes de inscribirte.',
                        side: "top",
                        align: 'center'
                    }
                }
            ]
        });

        function startTutorial() {
            driverObj.drive();
        }

        if (!localStorage.getItem('guides_tutorial_seen')) {
            setTimeout(() => {
                startTutorial();
                localStorage.setItem('guides_tutorial_seen', 'true');
            }, 1000);
        }
    </script>
@endsection
