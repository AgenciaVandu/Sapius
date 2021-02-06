@extends('layouts.adminmart.default')

@section('timer')

    <div>
        <h2 class="text-dark mb-1 font-weight-medium" id="timer" style="display:none"></h2>
        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate" style="display:none">Tiempo restante</h6>
        @php
            $str_time = $examen->Prueba->tiempo_vigencia;
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_minutes = isset($hours) ? $hours * 60 + $minutes:$minutes;
        @endphp
        <input type="hidden" id="tiempo" value="{{ $time_minutes }}}">
        <input type="hidden" id="tiempo-inicio" value="{{ date('Y-m-d H:i:s') }}">
    </div>
    <input type="text" value="Se ha detectado el uso indebido
de la plataforma y violación de las restricciones previstas en el contrato de servicios,
de los términos y condiciones. Por ello, no podrá continuar con el examen y se le
negará la retroalimentación correspondiente, nos reservamos el derecho de negar el
acceso permanente a la plataforma." id="myInput" style="display: none">
    <form method="GET" action="{{ route('alumno') }}" class="mt-4" id="form-redirect">
        @csrf
    </form>
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $examen->Prueba->titulo}}</h3>
                <div class="d-flex align-items-center">
                    Retrolaimentación.
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">

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
            if($pregunta == null) continue;
        @endphp
            <div class="card border border-dark" style="background-image: url('{{ asset('vendor/adminmart/assets/images/2.png') }}'); background-repeat: no-repeat; background-position: center;">
                <div class="card-body">
                    <h4 class="card-title">{!! $pregunta->pregunta !!}</h4>
                    @foreach ($pregunta->Respuestas as $item)
                        @php
                            $checked = ($item->id == $respuesta->value) ? 'checked':'';
                            $class = ($item->correcto == 1) ? 'alert-success':'';
                            $class = ($item->id == $respuesta->value) ? 'alert-danger':$class;
                        @endphp
                        <fieldset class="radio">
                            <label for="radio{{ $pregunta->id }}" class="{{ $class }}" >
                                <input type="radio" id="radio-{{ $pregunta->id }}-{{$item->id}}" name="{{ $pregunta->id }}" value="{{$item->id}}" {{ $checked }} disabled>
                                {!! $item->respuesta!!}
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
        classByClass('alert-success','alert-success1');
        classByClass('alert-danger','alert-danger1');
        $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').hide();

        $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').bind('mouseover',cardBlack);

        $('div.card').bind('mouseout',cardWhite);
        //alert("examenid " + id);

        $(document).keydown(function(event) {
            //var key = (event.keyCode ? event.keyCode : event.which);
            var key = event.key;
            var keyCode = event.keyCode;
            //alert('You pressed down a key ' + key);

            var examen_id = @json($examen->id, JSON_PRETTY_PRINT);
            var lugar = "feedback";
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

