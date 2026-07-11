@extends('layouts.adminmart.default')

@section('timer')
    <div>
        <h2 class="text-dark mb-1 font-weight-medium" id="timer"></h2>
        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Tiempo restante</h6>
        @php
            $str_time = $prueba->tiempo;
            sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
            $duration_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;

            $start_time = \Carbon\Carbon::parse($examen->created_at);
            $now = \Carbon\Carbon::now();
            $elapsed_seconds = $now->diffInSeconds($start_time);
            $remaining_seconds = $duration_seconds - $elapsed_seconds;

            // Ensure we don't pass negative time if it's already over
            $remaining_seconds = $remaining_seconds > 0 ? $remaining_seconds : 0;

            $time_minutes = isset($hours) ? $hours * 60 + $minutes : $minutes;
        @endphp
        <input type="hidden" id="tiempo" value="{{ $time_minutes }}">
        <input type="hidden" id="tiempo_segundos" value="{{ $remaining_seconds }}">
        <input type="hidden" id="tiempo-inicio" value="{{ $examen->created_at }}">
    </div>

    <input type="text"
        value="Se ha detectado el uso indebido
de la plataforma y violación de las restricciones previstas en el contrato de servicios,
de los términos y condiciones. Por ello, no podrá continuar con el examen y se le
negará la retroalimentación correspondiente, nos reservamos el derecho de negar el
acceso permanente a la plataforma."
        id="myInput" style="display: none">
    <form method="POST" action="{{ route('examen.finalizar') }}" class="mt-4" id="form-redirect">
        @csrf
        <input type="hidden" name="examen_id" id="examen_id" value="{{ $examen->id }}">
        <input type="hidden" name="leccion_id" value="{{ $prueba->Leccion->id }}">
        <input type="hidden" name="curso_programado_id" value="{{ $examen->Inscripcion->curso_programado_id }}">
        <input type="hidden" name="inscripcion_id" value="{{ $examen->inscripcion_id }}">
    </form>
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $prueba->Leccion->Curso->titulo }}
                </h3>
                <div class="d-flex align-items-center">
                    {{ $prueba->Leccion->titulo }} / {{ $prueba->titulo }}
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right text-right">
                    <button class="btn btn-sm btn-outline-info rounded-pill mb-2 btn-tutorial-animate"
                        onclick="startTutorial()">
                        <i class="far fa-question-circle"></i> Ver Tutorial
                    </button>
                    <h3>Resueltas: <strong id="total_resueltas">0</strong>/<strong id="total_preguntas">0</strong></h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @csrf
    <input type="hidden" id="liga" value="{{ route('examen.presentar') }}">
    <input type="hidden" id="liga-finalizar" value="{{ route('examen.finalizar-imprevisto') }}">
    <input type="hidden" id="prueba_id" value="{{ $prueba->id }}">
    <input type="hidden" id="inscripcion_id" value="{{ $examen->inscripcion_id }}">

    <div id="preguntas">
        @include('evaluacion.preguntas', [
            'preguntas' => $preguntas,
            'examen' => $examen,
            'final' => $final,
        ])
    </div>
    <div id="respuestas_status" class="mt-4">
        @include('evaluacion.respuestas_status', [
            'preguntasAll' => $preguntasAll,
            'respuestas_json' => json_decode($examen->respuestas_json, true),
        ])
    </div>

    <!-- Modal original -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">Titulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="finalizar">Finalizar</button>
                </div>
            </div>
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
                    <p class="text-justify">
                        El uso de SAPIUS trae consigo aceptar los derechos de autor y propiedad intelectual de todo el
                        contenido en el sitio.
                        Mismos que se encuentran reservados y protegidos de conformidad con la Ley Federal de Derechos de
                        Autor.
                        Está estrictamente prohibido copiar, replicar, tomar capturas de pantalla y grabaciones,
                        así como el uso indebido del material. Será perseguido jurídicamente cualquier infractor a estas
                        condiciones, junto con ello, se le negará el acceso permanente a la plataforma.
                    </p>
                    <p>Presione ESC para continuar.</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; justify-content:center; align-items:center;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>

    <script>
        // Timer del examen
        var timer = Object();
        timer.minutes = $('#tiempo').val();
        timer.seconds = $('#tiempo_segundos').val();
        timer.div_show = $('#timer');
        timer.form_redirect = $('#form-redirect');
        timer.start_at = $('#tiempo-inicio').val();
        ShowTime(timer);

        // Registro de teclas presionadas - Optimizado con throttle para evitar saturar el servidor
        $(document).ready(function() {
            textColor('white');
            $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').hide();

            $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').bind('mouseover',
                cardBlack);
            $('div.card').bind('mouseout', cardWhite);

            let lastEventTime = 0;
            const EVENT_THROTTLE = 2000; // 2 segundos entre envíos de eventos genéricos

            $(document).keydown(function(event) {
                var now = Date.now();
                if (now - lastEventTime < EVENT_THROTTLE) return; // Ignorar si es muy pronto

                var key = event.key;
                var keyCode = event.keyCode;
                var examen_id = @json($examen->id);
                var token = "{{ csrf_token() }}";

                lastEventTime = now;

                $.post("{{ route('examen.eventos') }}", {
                    _token: token,
                    examen_id: examen_id,
                    lugar: "prueba",
                    tecla: keyCode,
                    observacion: key
                });
            });
        });

        // Bloquear clic derecho, cortar, copiar y pegar
        $(document).ready(function() {
            $('body').on("contextmenu", function(e) {
                return false;
            });
            $('body').bind('cut copy paste', function(e) {
                e.preventDefault();
            });
        });

        // Evitar selección de texto
        function disableselect(e) {
            return false;
        }

        function reEnable() {
            return true;
        }
        document.onselectstart = new Function("return false");
        if (window.sidebar) {
            document.onmousedown = disableselect;
            document.onclick = reEnable;
        }

        // --- NUEVO SISTEMA DE ADVERTENCIA CON CONTADOR (Conectado al Backend) ---
        const overlay = document.getElementById('warning-overlay');
        const contador = document.getElementById('contador-intentos');
        const registerStrikeEndpoint = "{{ route('alumno.register-strike') }}"; // Use global route
        let isFinalizing = false;

        function registerExamStrike(reason) {
            if (isFinalizing) return;

            // Call backend to register strike and get weighted score
            fetch(registerStrikeEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        action: reason,
                        details: 'Exam Mode'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const currentScore = Math.min(data.strikes || 0, 100);
                    const maxStrikes = 100;

                    // Update UI
                    if (contador) {
                        contador.textContent =
                            `Nivel de Riesgo: ${currentScore}% — ${currentScore < 100 ? 'Evite acciones indebidas' : '⚠️ Cuenta Bloqueada'}`;
                    }
                    if (overlay) overlay.style.display = 'flex';

                    console.log(`Exam Strike: ${reason} (Risk: ${currentScore}%)`);

                    // If blocked or limit reached
                    if (data.status === 'blocked' || currentScore >= maxStrikes) {
                        isFinalizing = true;
                        setTimeout(() => {
                            finalizeExamDueToStrike();
                        }, 2000);
                    } else {
                        // Hide overlay after delay if not blocked
                        setTimeout(() => {
                            if (!isFinalizing && overlay) overlay.style.display = 'none';
                        }, 4000);
                    }
                })
                .catch(err => {
                    console.error("Error registering strike:", err);
                    // Fallback purely local if network fails? 
                    // For now, simpler to do nothing or warn.
                });
        }

        function finalizeExamDueToStrike() {
            var url = $('#liga-finalizar').val();
            var examen_id = $('#examen_id').val() || "{{ $examen->id }}";
            var token = $('input[name="_token"]').val();

            $.post(url, {
                _token: token,
                examen_id: examen_id
            }, function(data) {
                document.open();
                document.write(data);
                document.close();
                // Optionally redirect to locked page explicitly if the response doesn't do it
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            }).fail(function(xhr) {
                console.error("Error finalizando examen:", xhr);
                location.reload();
            });
        }

        window.addEventListener('keydown', function(event) {
            const e = event; // Alias

            // Volume Keys - Handled as Low Severity
            if (['AudioVolumeUp', 'AudioVolumeDown', 'AudioVolumeMute'].includes(e.key)) {
                e.preventDefault();
                registerExamStrike('Volume Key');
                return;
            }

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

            // Windows Snipping Tool (Win + Shift + S)
            if (!isMac && e.metaKey && e.shiftKey && (e.key === 's' || e.key === 'S')) {
                e.preventDefault();
                registerExamStrike("Snipping Tool");
                return;
            }

            // Block Ctrl/Cmd + P (Print), S (Save), C (Copy)
            // In exam, we might want to be strict about ANY Ctrl/Cmd combo except maybe specialized ones?
            // Existing code just said: event.ctrlKey || restrictedKeys.includes(event.key);
            // Which blocks ALL Ctrl combos. We can keep that strictness or use the specific list.
            // The user asked for "validar que las combinaciones ... se incluyan igual ... windows y mac".
            // So I will apply the same strictness to Mac (Cmd key).

            const restrictedKeys = ['F12', 'F11'];

            if (isCtrlOfTheOS || restrictedKeys.includes(e.key)) {
                // Allow some helpful shortcuts? usually no in exams.
                // Maybe allow Ctrl+R (Refresh)? No, usually blocked.
                // So blocking all Cmd/Ctrl is fine for exams.
                e.preventDefault();
                registerExamStrike("Restricted Key / Modifier");
            }
        });
        // Navegación personalizada por recuadros
        let isNavigating = false;
        $(document).on('click', '.recuadro-paginacion', function() {
            if (isNavigating) return;

            var page = $(this).data('page');
            var prueba_id = $('#prueba_id').val();
            var inscripcion_id = $('#inscripcion_id').val();
            var url = $('#liga').val();

            // Collect current answers to save
            var respuestas = [];
            $('#preguntas input[type=radio]:checked').each(function() {
                respuestas.push({
                    name: $(this).attr('name'),
                    value: $(this).val()
                });
            });

            if (page) {
                isNavigating = true;
                $('#loading-overlay').css('display', 'flex');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        page: page,
                        prueba_id: prueba_id,
                        inscripcion_id: inscripcion_id,
                        respuestas: JSON.stringify(respuestas)
                    },
                    success: function(response) {
                        if (!response || typeof response.preguntas === 'undefined') {
                            var redirectUrl = "{{ route('login') }}?expired=1&type=exam";
                            if (response && response.redirect) {
                                redirectUrl = response.redirect;
                            }
                            window.location.href = redirectUrl;
                            return;
                        }
                        $('#preguntas').html(response.preguntas);
                        $('#respuestas_status').html(response.respuestas_status);
                        $('html, body').animate({
                            scrollTop: 0
                        }, 'fast');
                        $('#loading-overlay').hide();
                        isNavigating = false;
                    },
                    error: function(xhr) {
                        console.log('Error navigating:', xhr);
                        $('#loading-overlay').hide();
                        if (xhr.status === 419 || xhr.status === 401 || xhr.status === 403) {
                            var redirectUrl = "{{ route('login') }}?expired=1&type=exam";
                            if (xhr.responseJSON && xhr.responseJSON.redirect) {
                                redirectUrl = xhr.responseJSON.redirect;
                            }
                            window.location.href = redirectUrl;
                        } else {
                            alert('Error al cargar la pregunta. Por favor, intente de nuevo.');
                            isNavigating = false;
                        }
                    }
                });
            }
        });
 
        // Monitoreo en segundo plano de sesión activa (Heartbeat)
        setInterval(function() {
            if (isFinalizing) return;

            fetch(window.location.href, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log("Heartbeat check - Status:", response.status, "Redirected:", response.redirected, "URL:", response.url);
                if (response.status === 401 || response.status === 419 || response.status === 403 || (response.redirected && response.url.includes('login'))) {
                    isFinalizing = true;
                    
                    // Bloquear pantalla con overlay
                    if (overlay) {
                        if (contador) {
                            contador.innerHTML = "⚠️ ACCESO DENEGADO<br><span style='font-size: 1.3rem; color: #ffeb3b;'>Se inició sesión en otro dispositivo. Cerrando examen...</span>";
                        }
                        overlay.style.display = 'flex';
                    }

                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}?expired=1&type=exam";
                    }, 3000);
                } else if (response.redirected && response.url.includes('locked')) {
                    isFinalizing = true;
                    window.location.reload();
                }
            })
            .catch(err => {
                console.error("Error verificando sesión en segundo plano:", err);
            });
        }, 10000);

        // Tutorial Logic
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
                        title: 'Modo Examen',
                        description: 'Estás a punto de comenzar tu evaluación. Lee atentamente las siguientes instrucciones.',
                        side: "bottom",
                        align: 'start'
                    }
                },
                {
                    element: '#timer',
                    popover: {
                        title: 'Tiempo Restante',
                        description: 'Aquí verás el tiempo disponible. Si llega a cero, el examen se enviará automáticamente.',
                        side: "bottom",
                        align: 'center'
                    }
                },
                {
                    element: '#preguntas',
                    popover: {
                        title: 'Área de Preguntas',
                        description: 'Aquí aparecerá la pregunta y sus opciones de respuesta. Selecciona la que consideres correcta.',
                        side: "top",
                        align: 'start'
                    }
                },
                {
                    element: '#respuestas_status',
                    popover: {
                        title: 'Navegación',
                        description: 'Usa este panel para ver qué preguntas has contestado y saltar entre ellas.',
                        side: "top",
                        align: 'start'
                    }
                },
                {
                    element: '#myInput',
                    popover: {
                        title: '⚠️ REGLAS IMPORTANTES',
                        description: 'No intentes copiar texto, usar capturas de pantalla o cambiar de pestaña. El sistema detectará estas acciones.',
                        side: "top",
                        align: 'center'
                    }
                },
                {
                    element: '.page-breadcrumb',
                    popover: {
                        title: 'Advertencias',
                        description: 'Tendrás 3 oportunidades si cometes una falta (como presionar teclas prohibidas). A la tercera, el examen se cerrará.',
                        side: "bottom",
                        align: 'center'
                    }
                }
            ]
        });

        function startTutorial() {
            driverObj.drive();
        }

        if (!localStorage.getItem('exam_taking_tutorial_seen')) {
            setTimeout(() => {
                startTutorial();
                localStorage.setItem('exam_taking_tutorial_seen', 'true');
            }, 1000);
        }
    </script>
@endsection
