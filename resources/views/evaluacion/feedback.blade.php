@extends('layouts.adminmart.default')

@section('timer')
    <div>
        <h2 class="text-dark mb-1 font-weight-medium" id="timer"></h2>
        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate" style="display:none">Tiempo restante</h6>
        @php
            $str_time = $examen->Prueba->tiempo_vigencia;
            sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
            $time_minutes = isset($hours) ? $hours * 60 + $minutes : $minutes;
        @endphp
        <input type="hidden" id="tiempo" value="{{ $time_minutes }}">
        <input type="hidden" id="tiempo-inicio" value="{{ date('Y-m-d H:i:s') }}">
    </div>
    <input type="text"
        value="Se ha detectado el uso indebido
de la plataforma y violación de las restricciones previstas en el contrato de servicios,
de los términos y condiciones. Por ello, no podrá continuar con el examen y se le
negará la retroalimentación correspondiente, nos reservamos el derecho de negar el
acceso permanente a la plataforma."
        id="myInput" style="display: none">
    <form method="GET" action="{{ route('alumno.home') }}" class="mt-4" id="form-redirect">
        @csrf
    </form>
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $examen->Prueba->titulo }}</h3>
                <div class="d-flex align-items-center">
                    Retrolaimentación.
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
        <input type="hidden" id="liga-finalizar" value="{{ route('examen.feedback-finalizar') }}">
        <div class="col-md-12" id="preguntas">
            @foreach ($feedback as $item1)
                @php
                    $pregunta = $item1[1]->Pregunta;
                    $respuesta = $item1[0];
                    if ($pregunta == null) {
                        continue;
                    }
                @endphp
                <div class="card border border-dark"
                    style="background-image: url('{{ asset('vendor/adminmart/assets/images/2.png') }}'); background-repeat: no-repeat; background-position: center;">
                    <div class="card-body">
                        <h4 class="card-title">{!! $pregunta->pregunta !!}</h4>
                        @foreach ($pregunta->Respuestas as $item)
                            @php
                                $checked = $item->id == $respuesta->value ? 'checked' : '';
                                $class = $item->correcto == 1 ? 'alert-success' : '';
                                $class = $item->id == $respuesta->value ? 'alert-danger' : $class;
                            @endphp
                            <fieldset class="radio">
                                <label for="radio{{ $pregunta->id }}" class="{{ $class }}">
                                    <input type="radio" id="radio-{{ $pregunta->id }}-{{ $item->id }}"
                                        name="{{ $pregunta->id }}" value="{{ $item->id }}" {{ $checked }}
                                        disabled>
                                    {!! $item->respuesta !!}
                                </label>
                            </fieldset>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        {!! $pregunta->opciones !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal aviso -->
    <div class="modal" tabindex="-1" role="dialog" id="mensaje">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aviso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-justify">El uso de SAPIUS trae consigo aceptar los derechos de autor y propiedad
                        intelectual de todo el contenido en el sitio.
                        Mismos que se encuentran reservados y protegidos de conformidad con la Ley Federal de Derechos de
                        Autor. Está extríctamente
                        prohibido copiar, replicar, tomar capturas de pantalla y grabaciones, así como el uso indebido del
                        material.
                        Será perseguido jurídicamente cualquier infractor a estas condiciones, junto con ello, se le negará
                        el acceso permanente a la plataforma.</p>
                    <p>Presione ESC para continuar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay mensaje de advertencia -->
    <div id="warning-overlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
           background-color:rgba(5, 36, 66,0.90); color:white; font-size:1.5rem;
           z-index:9999; text-align:center; justify-content:center; align-items:center; flex-direction:column;">
        <img src="https://sapius.com.mx/img/logo-sapius.png" alt="Logo Sapius">
        <p><strong>⚠️ Uso de teclas no permitido</strong></p>
        <p>
            Durante la revisión está prohibido el uso de teclas o combinaciones.<br>
            Tienes 3 advertencias; a la tercera se cerrará automáticamente el acceso.
        </p>
        <p id="contador-intentos" style="font-size:1.8rem; font-weight:bold; margin-top:10px;"></p>
    </div>

    <!-- Overlay mensaje de advertencia -->
    <div id="warning-overlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
           background-color:rgba(5, 36, 66,0.90); color:white; font-size:1.5rem;
           z-index:9999; text-align:center; justify-content:center; align-items:center; flex-direction:column;">
        <img src="https://sapius.com.mx/img/logo-sapius.png" alt="Logo Sapius">
        <p><strong>⚠️ Uso de teclas no permitido</strong></p>
        <p>
            Durante la revisión está prohibido el uso de teclas o combinaciones.<br>
            Tienes 3 advertencias; a la tercera se cerrará automáticamente el acceso.
        </p>
        <p id="contador-intentos" style="font-size:1.8rem; font-weight:bold; margin-top:10px;"></p>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
    <script>
        var timer = Object();
        // Timer elements might not be present or needed in feedback exactly like exam, but keeping existing non-breaking code
        if ($('#tiempo').length) {
            timer.minutes = $('#tiempo').val();
            timer.div_show = $('#timer');
            timer.form_redirect = $('#form-redirect');
            timer.start_at = $('#tiempo-inicio').val();
            // ShowTime(timer); // Timer might not be relevant for feedback view in same way
        }


        // --- NUEVO SISTEMA DE ADVERTENCIA CON CONTADOR ---
        let intentos = 0;
        const maxIntentos = 3;
        const overlay = document.getElementById('warning-overlay');
        const contador = document.getElementById('contador-intentos');

        function registerExamStrike(reason) {
            intentos++;
            const restantes = maxIntentos - intentos;

            if (contador) {
                contador.textContent =
                    `Intento ${intentos} de ${maxIntentos} — ${restantes > 0 ? `Te quedan ${restantes}` : '⚠️ Sin intentos restantes'}`;
            }
            if (overlay) overlay.style.display = 'flex';

            console.log("Strike: " + reason);

            // Ocultar después de 5 segundos
            setTimeout(() => {
                if (intentos < maxIntentos && overlay) overlay.style.display = 'none';
            }, 5000);

            // Si llega al tercer intento, finalizar (bloquear)
            if (intentos >= maxIntentos) {
                setTimeout(() => {
                    // Use the route that triggers the block/finalize logic
                    var url = "{{ route('examen.finalizar-imprevisto') }}";
                    var examen_id = @json($examen->id);
                    var token = "{{ csrf_token() }}";

                    $.post(url, {
                        _token: token,
                        examen_id: examen_id
                    }, function(data) {
                        document.open();
                        document.write(data);
                        document.close();
                    }).fail(function(xhr) {
                        console.error("Error finalizing:", xhr);
                        location.reload();
                    });
                }, 1000);
            }
        }

        $(window).on("load", function() {
            // override older handlers if necessary or let them coexist if non-conflicting
            // document.onkeydown = mostrarInformacionTecla; 
        });

        $(document).ready(function() {
            textColor('white');
            classByClass('alert-success', 'alert-success1');
            classByClass('alert-danger', 'alert-danger1');
            $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').hide();

            $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').bind('mouseover',
                cardBlack);

            $('div.card').bind('mouseout', cardWhite);

            // Event listener for keys
            $(window).keydown(function(event) {
                const e = event;

                // Allow ESC to close modals if needed, but forbidden keys must be blocked
                // Windows PrintScreen
                if (e.key === 'PrintScreen' || e.keyCode === 44) {
                    e.preventDefault();
                    registerExamStrike("PrintScreen");
                    return;
                }

                const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
                const isCtrlOfTheOS = isMac ? e.metaKey : e.ctrlKey;

                // Mac Screenshots: Cmd+Shift+3, 4, 5
                if (isMac && e.metaKey && e.shiftKey && ['3', '4', '5'].includes(e.key)) {
                    e.preventDefault();
                    registerExamStrike("Mac Screenshot");
                    return;
                }

                const restrictedKeys = ['F12', 'F11'];

                if (isCtrlOfTheOS || restrictedKeys.includes(e.key)) {
                    e.preventDefault();
                    registerExamStrike("Restricted Key / Modifier");
                    return;
                }

                // Keep logging logic if needed, but prioritize security
                var examen_id = @json($examen->id);
                // ... existing logging logic can remain if it doesn't conflict
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            //Disable full page context menu
            $("body").on("contextmenu", function(e) {
                return false;
            });
            // Disable cut copy paste
            $('body').bind('cut copy paste', function(e) {
                e.preventDefault();
                // Optionally warn on copy attempt?
                // registerExamStrike("Copy/Paste Attempt"); 
            });
        });
    </script>
    <script language="Javascript" type="text/javascript">
        function disableselect(e) {
            return false
        }

        function reEnable() {
            return true
        }
        document.onselectstart = new Function("return false")
        if (window.sidebar) {
            document.onmousedown = disableselect
            document.onclick = reEnable
        }
    </script>

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
                        title: 'Retroalimentación de Evaluación',
                        description: 'En esta sección podrás revisar tus respuestas y entender tus errores.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '.page-breadcrumb',
                    popover: {
                        title: '⚠️ REGLAS DE SEGURIDAD',
                        description: 'Al igual que en el examen, está PROHIBIDO copiar contenido o usar teclas restringidas. Si lo haces, se cerrará el acceso.',
                        side: "bottom",
                        align: 'center'
                    }
                },
                {
                    element: '.card:not(.border-dark)',
                    popover: {
                        title: 'Tarjeta de Pregunta',
                        description: 'Cada tarjeta muestra el planteamiento de la pregunta.',
                        side: "top",
                        align: 'start'
                    }
                },
                {
                    element: '.alert-success',
                    popover: {
                        title: 'Respuesta Correcta',
                        description: 'La opción resaltada en VERDE es la respuesta correcta.',
                        side: "left",
                        align: 'center'
                    }
                },
                {
                    element: '.alert-danger',
                    popover: {
                        title: 'Tu Respuesta Incorrecta',
                        description: 'Si ves una opción en ROJO, es la que seleccionaste y fue incorrecta.',
                        side: "left",
                        align: 'center'
                    }
                },
                {
                    element: '.card-footer',
                    popover: {
                        title: 'Justificación Didáctica',
                        description: 'Lee esta sección para comprender el porqué de la respuesta correcta.',
                        side: "top",
                        align: 'start'
                    }
                }
            ]
        });

        function startTutorial() {
            driverObj.drive();
        }

        if (!localStorage.getItem('exam_feedback_tutorial_seen')) {
            setTimeout(() => {
                startTutorial();
                localStorage.setItem('exam_feedback_tutorial_seen', 'true');
            }, 1000);
        }
    </script>
@endsection
