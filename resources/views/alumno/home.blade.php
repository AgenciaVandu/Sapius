@extends('layouts.adminmart.default')

@section('css')
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    {{ Auth::user()->nombre_completo }}</h2>
                <div class="d-flex align-items-center">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1 mr-3">Tus cursos</h3>
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
        <div class="col-md-12">
            <div class="card-columns">
                @if (!count($cursos))
                    <div class="card shadow">
                        <div class="card-body content">
                            <h4 class="card-title">
                                No cuentas con ningun curso adquirido
                            </h4>
                        </div>
                    </div>
                @else
                    @foreach ($cursos as $inscripcion)
                        @foreach ($inscripcion->CursoProgramado()->get() as $cursop)
                            @if ($cursop->category->name == 'Guias')
                                @foreach ($cursop->Curso()->get() as $curso)
                                    <div class="card shadow">
                                        @if ($curso->imagen)
                                            <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->imagen]) }}"
                                                id="img" alt="..." class="img-thumbnail">
                                        @else
                                            <img class="card-img-top img-fluid"
                                                src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                                                alt="Card image cap">
                                        @endif
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                {{ $curso->titulo }}
                                                <span class="badge badge-primary">{{ $cursop->identificador }}</span>
                                            </h4>
                                            <p class="card-text">{!! $curso->descripcion !!}</p>
                                            <form method="POST" action="{{ route('alumno.view.guias') }}">
                                                @csrf
                                                <input name="curso_programado_id" type="hidden"
                                                    value="{{ $cursop->id }}">
                                                @if ($inscripcion->aceptado == 'no')
                                                    <button type="submit" disabled
                                                        class="btn btn-warning btn-block rounded-10">
                                                        Aprobración Pendiente
                                                    </button>
                                                @elseif($inscripcion->aceptado == 'si')
                                                    @if ($cursop->fecha_inicio > date('Y-m-d H:i:s'))
                                                        <button type="submit" disabled
                                                            class="btn btn-success btn-block rounded-10">
                                                            Disponbible el
                                                            {{ \Carbon\Carbon::parse($cursop->fecha_inicio)->format('d/m/Y') }}
                                                        </button>
                                                    @else
                                                        <button type="submit" class="btn btn-success btn-block rounded-10">
                                                            Ver Guía
                                                        </button>
                                                    @endif
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($cursop->Curso()->get() as $curso)
                                    <div class="card shadow">
                                        @if ($curso->imagen)
                                            <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->imagen]) }}"
                                                id="img" alt="..." class="img-thumbnail">
                                        @else
                                            <img class="card-img-top img-fluid"
                                                src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                                                alt="Card image cap">
                                        @endif
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                {{ $curso->titulo }}
                                                <span class="badge badge-primary">{{ $cursop->identificador }}</span>
                                            </h4>
                                            <p class="card-text">{!! $curso->descripcion !!}</p>
                                            <form method="POST" action="{{ route('cursos.detallado') }}">
                                                @csrf
                                                <input name="curso_programado_id" type="hidden"
                                                    value="{{ $cursop->id }}">
                                                @if ($inscripcion->aceptado == 'no')
                                                    <button type="submit" class="btn btn-warning btn-block rounded-10">
                                                        Aprobración Pendiente
                                                    </button>
                                                @elseif($inscripcion->aceptado == 'si')
                                                    <button type="submit" class="btn btn-success btn-block rounded-10">
                                                        En Curso
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                @endif
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
                        title: 'Bienvenido a tu Panel',
                        description: 'Aquí encontrarás todos tus cursos inscritos y podrás acceder a su contenido.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '#menu-tus-cursos',
                    popover: {
                        title: 'Tus Cursos',
                        description: 'En esta sección (Inicio) encontrarás todos los cursos en los que estás inscrito actualmente.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '#menu-calendario',
                    popover: {
                        title: 'Mi Calendario',
                        description: 'Consulta tus fechas importantes y cronograma de actividades.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '#menu-cursos-disponibles',
                    popover: {
                        title: 'Cursos Disponibles',
                        description: 'Explora el catálogo de cursos en los que te puedes inscribir.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '#menu-guias-disponibles',
                    popover: {
                        title: 'Guías',
                        description: 'Accede a guías y material de apoyo adicional.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '#menu-simuladores-disponibles',
                    popover: {
                        title: 'Simuladores',
                        description: 'Practica tus conocimientos con nuestros simuladores interactivos.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '#menu-soporte',
                    popover: {
                        title: 'Soporte Técnico',
                        description: '¿Tienes algún problema? Contacta con nuestro equipo de soporte aquí.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: '#statusIconWrapper',
                    popover: {
                        title: 'Estado de Cuenta',
                        description: 'Este ícono te indica si tu documentación y estado de cuenta están completos y validados.',
                        side: "bottom",
                        align: 'end'
                    }
                },
                {
                    element: '#userDropdownWrapper',
                    popover: {
                        title: 'Menú de Usuario',
                        description: 'Aquí puedes gestionar tu cuenta. Haz clic para ver más opciones.',
                        side: "bottom",
                        align: 'end'
                    }
                },
                {
                    element: '#userProfileBtn',
                    popover: {
                        title: 'Mi Perfil',
                        description: 'Actualiza tu foto, contraseña y datos personales.',
                        side: "left",
                        align: 'center'
                    },
                    onHighlightStarted: (element) => {
                        if (!document.getElementById('userDropdownWrapper').classList.contains('show')) {
                            document.getElementById('userDropdownTrigger').click();
                        }
                    }
                },
                {
                    element: '#userCompleteDataBtn',
                    popover: {
                        title: 'Completar Datos',
                        description: 'Es importante tener tu información al día para certificados y validaciones.',
                        side: "left",
                        align: 'center'
                    }
                },
                {
                    element: '#userLogoutBtn',
                    popover: {
                        title: 'Cerrar Sesión',
                        description: 'Haz clic aquí para salir de la plataforma de forma segura.',
                        side: "left",
                        align: 'center'
                    },
                    onDeselected: (element) => {
                        if (document.getElementById('userDropdownWrapper').classList.contains('show')) {
                            document.getElementById('userDropdownTrigger').click();
                        }
                    }
                },
                {
                    element: '.card.shadow:first-child',
                    popover: {
                        title: 'Tus Cursos',
                        description: 'Cada tarjeta representa un curso. Aquí verás la imagen, título y estado del mismo.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '.card.shadow:first-child button[type="submit"]',
                    popover: {
                        title: 'Acceder al Curso',
                        description: 'Haz clic en este botón para entrar al contenido del curso, ver guías o examenes.',
                        side: "top",
                        align: 'start'
                    }
                }
            ]
        });

        function startTutorial() {
            driverObj.drive();
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (!localStorage.getItem('student_panel_tutorial_seen')) {
                // Pequeño delay para asegurar que los elementos estén renderizados y visibles
                setTimeout(() => {
                    startTutorial();
                    localStorage.setItem('student_panel_tutorial_seen', 'true');
                }, 1000);
            }
        });
    </script>
@endsection
