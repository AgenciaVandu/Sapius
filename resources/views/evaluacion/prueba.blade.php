@extends('layouts.adminmart.default')

@section('timer')

    <div>
        <h2 class="text-dark mb-1 font-weight-medium" id="timer"></h2>
        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Tiempo restante</h6>
        @php
            $str_time = $prueba->tiempo;
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_minutes = isset($hours) ? $hours * 60 + $minutes:$minutes;
        @endphp
        <input type="hidden" id="tiempo" value="{{ $time_minutes }}">
        <input type="hidden" id="tiempo-inicio" value="{{ $examen->created_at }}">
    </div>


    <input type="text" value="Se ha detectado el uso indebido
de la plataforma y violación de las restricciones previstas en el contrato de servicios,
de los términos y condiciones. Por ello, no podrá continuar con el examen y se le
negará la retroalimentación correspondiente, nos reservamos el derecho de negar el
acceso permanente a la plataforma." id="myInput" style="display: none">
    <form method="POST" action="{{ route('examen.finalizar') }}" class="mt-4" id="form-redirect">
        @csrf
        <input type="hidden" name="examen_id" id="examen_id" value="{{ $examen->id }}">
        <input type="hidden" name="leccion_id" value="{{ $prueba->Leccion->id }}">
        <input type="hidden" name="curso_programado_id" value="{{$examen->Inscripcion->curso_programado_id}}">
        <input type="hidden" name="inscripcion_id"  value="{{ $examen->inscripcion_id}}">
    </form>
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $prueba->Leccion->Curso->titulo}}</h3>
                <div class="d-flex align-items-center">
                    {{  $prueba->Leccion->titulo }} / {{  $prueba->titulo }}
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
    <input type="hidden" id="liga" value="{{ route('examen.presentar')}}">
    <input type="hidden" id="liga-finalizar" value="{{ route('examen.finalizar-imprevisto') }}">
    <input type="hidden" id="prueba_id"  value="{{ $prueba->id}}">
    <input type="hidden" id="inscripcion_id"  value="{{ $examen->inscripcion_id}}">
    <div id="preguntas">
        @include('evaluacion.preguntas',['preguntas' => $preguntas, 'examen' => $examen,'final' => $final])
    </div>

    <!-- Modal -->
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
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="finalizar">Finalizar</button>
                </div>
            </div>
        </div>
    </div>

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
                <p class="text-justify">El uso de SAPIUS trae consigo aceptar los derechos de autor y propiedad intelectual de todo el contenido en el sitio.
                    Mismos que se encuentran reservados y protegidos de conformidad con la Ley Federal de Derechos de Autor. Está extríctamente
                    prohibido copiar, replicar, tomar capturas de pantalla y grabaciones, así como el uso indebido del material.
                    Será perseguido jurídicamente cualquier infractor a estas condiciones, junto con ello, se le negará el acceso permanente a la plataforma.</p>
                <p>Presione ESC para continuar.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('javascript')
<script src="{{ asset('js/funciones.js') }}"></script>
<script>
    var timer = Object();
    timer.minutes = $('#tiempo').val();
    timer.div_show = $('#timer');
    timer.form_redirect = $('#form-redirect');
    timer.start_at = $('#tiempo-inicio').val();
    ShowTime(timer);

    $( window ).on( "load", function() {
        document.onkeydown = mostrarInformacionTecla;
        document.onkeypress = mostrarInformacionTecla;
        document.onkeyup = mostrarInformacionTecla;
    });

    $(document).ready( function () {
        textColor('white');
        $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').hide();

        $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').bind('mouseover',cardBlack);

        $('div.card').bind('mouseout',cardWhite);

        $(document).keydown(function(event) {
            //var key = (event.keyCode ? event.keyCode : event.which);
            var key = event.key;
            var keyCode = event.keyCode;
            //alert('You pressed down a key ' + key);

            var examen_id = @json($examen->id, JSON_PRETTY_PRINT);
            var lugar = "prueba";
            var tecla = keyCode;
            var observacion = key;
            var token =  "{{ csrf_token() }}";

            $.post("{{ route('examen.eventos') }}", { _token: token, examen_id: examen_id, lugar: lugar, tecla: tecla, observacion: observacion},function(){
            }).done(function(){
                //alert("evento ok");
            }).fail(function(){
                //alert("evento fail");
            });
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function () {
    //Disable full page
    $("body").on("contextmenu",function(e){
        return false;
    });
    
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    //Disable full page
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
});
</script>
<script language="Javascript" type="text/javascript">
    function disableselect(e){
        return false
    }
    function reEnable(){
        return true
    }
    document.onselectstart=new Function ("return false")
    if (window.sidebar){
    document.onmousedown=disableselect
    document.onclick=reEnable
    }
</script>
@endsection
