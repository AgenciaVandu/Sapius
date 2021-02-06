<div class="row">
    <div class="col-md-12">
        {!! $preguntas->links() !!}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @foreach ($preguntas[0]->GrupoPreguntas as $pregunta)
            <div class="card border border-dark" style="background-image: url('{{ asset('vendor/adminmart/assets/images/2.png') }}'); background-repeat: no-repeat; background-position: center;">
                <div class="card-body">
                    <h4 class="card-title">{!! $pregunta->pregunta !!}</h4>
                    @foreach ($pregunta->Respuestas as $item)
                        @php
                            $v = $respuestas->search(function ($item1, $key) use($item,$pregunta){
                                    return ($item1->name == $pregunta->id) && ($item1->value == $item->id);
                                });
                                $checked = ($v !== false)? "checked":"";
                        @endphp
                        <fieldset class="radio">
                            <label for="radio{{ $pregunta->id }}">
                                <input type="radio" id="radio-{{ $pregunta->id }}-{{$item->id}}" name="{{ $pregunta->id }}" value="{{$item->id}}" {{ $checked }}>
                                {!! $item->respuesta !!}
                            </label>
                        </fieldset>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@if($final)
<div class="row">
    <div class="col-md-12">
        <a  href="javascript:void(0)" class="btn btn-danger btn-block btn-detalle final" id="{{ route('examen.finalizar-form',['examen_id' => $examen->id]) }}">Finalizar</a>
    </div>
</div>
@endif
<script type="text/javascript">
    var respuestas_json = @json($examen->respuestas_json, JSON_PRETTY_PRINT);
    //console.log("Respuestas",respuestas_json);
    var total_preguntas = @json($examen->total_preguntas, JSON_PRETTY_PRINT);
    respuestas_json = (respuestas_json == null  || respuestas_json == "") ?  0 : JSON.parse(respuestas_json).length;
    document.getElementById("total_preguntas").innerHTML = total_preguntas;
    document.getElementById("total_resueltas").innerHTML = respuestas_json;

    $( window ).on( "load", function() {
        document.onkeydown = mostrarInformacionTecla;
        document.onkeypress = mostrarInformacionTecla;
        document.onkeyup = mostrarInformacionTecla;
    });

    jQuery(document).ready(function($) {

        textColor('white');
        $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').hide();

        $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').bind('mouseover',cardBlack);

        $('div.card').bind('mouseout',cardWhite);
    });
</script>

