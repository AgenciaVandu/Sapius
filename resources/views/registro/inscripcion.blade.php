@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <div class="d-flex align-items-center">
                    <h2 class="page-title text-truncate text-dark font-weight-medium mb-1 mr-3">Pasarela de pagos</h2>
                    <button class="btn btn-sm btn-outline-info rounded-pill btn-tutorial-animate" onclick="startTutorial()">
                        <i class="far fa-question-circle"></i> Ver Tutorial
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        $precio = $curso->precio;
        $descuento = session('descuento');
        $cupon = session('cupon');
        if ($descuento) {
            $precio = $curso->precio - ($descuento / 100) * $curso->precio;
        }
    @endphp

    <input type="hidden" id="curso" value="{{ $curso->Curso->titulo }}">

    <div class="card shadow-lg border-0 rounded-4 my-4">
        <div class="row no-gutters px-3 px-md-5 py-4">

            {{-- Vista móvil y tablet --}}
            <div class="col-12 d-block d-md-none mb-4 text-center">
                <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                    id="img" alt="Imagen del curso" class="img-fluid img-thumbnail mb-3" style="max-width: 280px;">
                <h4 class="text-primary font-weight-bold mb-2">{{ $curso->Curso->titulo }}</h4>
                <p class="text-muted">{!! $curso->Curso->descripcion !!}</p>
            </div>

            {{-- Vista de escritorio --}}
            <div class="col-md-5 d-none d-md-flex flex-column align-items-center px-4 text-center">
                <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                    id="img" alt="Imagen del curso" class="img-thumbnail mb-3" style="max-width: 320px;">
                <h2 class="fw-bold text-primary mb-2">{{ $curso->Curso->titulo }}</h2>
                <small class="text-muted">{!! $curso->Curso->descripcion !!}</small>
            </div>

            {{-- Detalles de pago --}}
            <div class="col-12 col-md-7 px-2 px-md-4">
                <div class="card-body p-0">
                    <h2 class="mb-4">
                        @if ($descuento)
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">Precio original:</span>
                                    <span><strike>${{ number_format($curso->precio, 2) }} MXN</strike></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">Descuento aplicado</span>
                                    <span class="text-success">
                                        ({{ $descuento }}%) - ${{ number_format($curso->precio - $precio, 2) }} MXN
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center font-weight-bold">
                                    <span class="text-dark">Total a pagar:</span>
                                    <span class="text-primary font-weight-bold h4">${{ number_format($precio, 2) }}
                                        MXN</span>
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="text-dark">Total a pagar:</span>
                                <span class="text-primary font-weight-bold h4">${{ number_format($curso->precio, 2) }}
                                    MXN</span>
                            </div>
                        @endif
                    </h2>

                    @if ($descuento)
                        <div class="alert alert-success d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <strong>¡Descuento aplicado!</strong><br>
                                <span>Cupón usado: <span
                                        class="badge badge-info text-dark">{{ $cupon }}</span></span><br>
                                <small>El precio mostrado ya incluye tu descuento.</small>
                            </div>
                            <form action="{{ route('descuentos.cancel') }}" method="POST" class="ml-3">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Quitar descuento">
                                    <i class="fas fa-times"></i> Cancelar cupón
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('descuentos.check') }}" method="POST" class="mb-4">
                            @csrf
                            @if (session('error'))
                                <div class="alert alert-danger mb-2">No se encontró la clave o ya expiró.</div>
                            @endif
                            @if (session('limit'))
                                <div class="alert alert-warning mb-2">Descuento agotado.</div>
                            @endif
                            <div class="input-group">
                                <input type="text" class="form-control" name="clave" id="input-cupon"
                                    placeholder="Código de descuento">
                                <input type="hidden" name="curso_programado_id" value="{{ $curso->id }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Agregar descuento</button>
                                </div>
                            </div>
                        </form>
                    @endif

                    <div class="mt-4">
                        @if ($descuento == 100)
                            <a href="{{ route('inscripcion.pago', $curso) }}"
                                class="btn btn-primary btn-lg w-100 shadow-sm d-flex align-items-center justify-content-center py-3">
                                <span>Redimir Cupón</span>
                            </a>
                        @else
                            <a href="{{ route('alumno.checkout', $curso) }}"
                                class="btn btn-primary btn-lg w-100 shadow-sm d-flex align-items-center justify-content-center py-3">
                                <i class="fas fa-credit-card mr-2"></i>
                                <span>Ir al pago</span>
                            </a>
                        @endif
                    </div>

                    <div class="mt-4 alert alert-primary border-left pl-3" style="background-color: #eef2ff;">
                        <p class="mb-1 font-weight-bold text-primary">Aviso importante sobre pagos:</p>
                        <p class="mb-0 text-dark">
                            Todos los pagos se procesan de forma segura mediante <strong>Openpay</strong>.
                            Al realizar una compra, aceptas sus términos y condiciones y autorizas su uso para procesar la
                            transacción.
                        </p>
                    </div>
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
                        title: 'Inscripción al Curso',
                        description: 'En esta pantalla podrás revisar los detalles finales antes de proceder al pago.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '.col-md-5',
                    popover: {
                        title: 'Resumen del Curso',
                        description: 'Confirma que estás inscribiéndote al curso correcto.',
                        side: "right",
                        align: 'center'
                    }
                },
                {
                    element: '.card-body h2',
                    popover: {
                        title: 'Total a Pagar',
                        description: 'Aquí se muestra el monto final. Si tienes un descuento, se verá reflejado aquí.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '#input-cupon',
                    popover: {
                        title: 'Cupón de Descuento',
                        description: '¿Tienes un código? Ingrésalo aquí y haz clic en "Agregar descuento" para aplicarlo.',
                        side: "top",
                        align: 'start'
                    }
                },
                {
                    element: '.mt-4.alert.alert-primary',
                    popover: {
                        title: 'Seguridad',
                        description: 'Recuerda que todos los pagos son procesados de forma segura por Openpay.',
                        side: "top",
                        align: 'start'
                    }
                },
                {
                    element: '.btn-primary.btn-lg',
                    popover: {
                        title: 'Proceder al Pago',
                        description: 'Haz clic aquí para ir a la plataforma de pago seguro y finalizar tu inscripción.',
                        side: "top",
                        align: 'center'
                    }
                }
            ]
        });

        function startTutorial() {
            driverObj.drive();
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (!localStorage.getItem('inscription_tutorial_seen')) {
                setTimeout(() => {
                    startTutorial();
                    localStorage.setItem('inscription_tutorial_seen', 'true');
                }, 1000);
            }
        });
    </script>
@endsection
