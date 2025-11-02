@extends('layouts.adminmart.default')

@section('timer')
    <div>
        <h2 class="text-dark mb-1 font-weight-medium" id="timer"></h2>
        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Tiempo restante</h6>
        @php
            $str_time = $prueba->tiempo;
            sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
            $time_minutes = isset($hours) ? $hours * 60 + $minutes : $minutes;
        @endphp
        <input type="hidden" id="tiempo" value="{{ $time_minutes }}">
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
                <div class="customize-input float-right">
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
            Durante el examen está prohibido el uso de teclas o combinaciones.<br>
            Tienes 3 advertencias; a la tercera se finalizará automáticamente el examen.
        </p>
        <p id="contador-intentos" style="font-size:1.8rem; font-weight:bold; margin-top:10px;"></p>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>

    <script>
        // Timer del examen
        var timer = Object();
        timer.minutes = $('#tiempo').val();
        timer.div_show = $('#timer');
        timer.form_redirect = $('#form-redirect');
        timer.start_at = $('#tiempo-inicio').val();
        ShowTime(timer);

        // Registro de teclas presionadas
        $(document).ready(function() {
            textColor('white');
            $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').hide();

            $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').bind('mouseover',
                cardBlack);
            $('div.card').bind('mouseout', cardWhite);

            $(document).keydown(function(event) {
                var key = event.key;
                var keyCode = event.keyCode;

                var examen_id = @json($examen->id);
                var token = "{{ csrf_token() }}";

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

        // --- NUEVO SISTEMA DE ADVERTENCIA CON CONTADOR ---
        let intentos = 0;
        const overlay = document.getElementById('warning-overlay');
        const contador = document.getElementById('contador-intentos');

        window.addEventListener('keydown', function(event) {
            const restrictedKeys = ['PrintScreen', 'F12', 'F11'];
            const isRestricted = event.ctrlKey || restrictedKeys.includes(event.key);

            if (!isRestricted) return; // Solo si presiona algo prohibido

            event.preventDefault();
            intentos++;

            const restantes = 3 - intentos;

            // Mostrar mensaje actualizado con recuento
            contador.textContent =
                `Intento ${intentos} de 3 — ${restantes > 0 ? `Te quedan ${restantes}` : '⚠️ Sin intentos restantes'}`;
            overlay.style.display = 'flex';

            // Ocultar después de 5 segundos
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 5000);

            // Si llega al tercer intento, finalizar examen
            if (intentos >= 3) {
                setTimeout(() => {
                    document.getElementById('form-redirect').submit();
                }, 1000);
            }
        });
    </script>
@endsection
