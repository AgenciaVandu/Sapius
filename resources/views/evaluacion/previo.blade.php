@extends('layouts.adminmart.detalle')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Antes continuar</h4>
                    @php
                    echo  $desPrueba;
                    @endphp
                    <br>
            <h6 class="card-subtitle">Para esta prueba has finalizado {{ $examen->examenes_count}} intentos de {{ $examen->oportunidades}} oportunidades
            </h6>
            <form method="POST" action="{{ route('examen.presentar') }}" class="mt-4" id="form-continuar">
                @csrf
                <input name="prueba_id" type="hidden" value="{{ $prueba_id}}">
                <input name="inscripcion_id" type="hidden" value="{{ $inscripcion_id}}">
            </form>
        </div>
    </div>
@endsection

@section('javascript')
   <script>
        $(document).ready( function () {
            $(".modal-title").html("Antes de presentar");
            $("#cancelar").html("Cancelar");
            $("#continuar").show();
            $("#continuar").click(function(){
                $("#form-continuar").submit();
            });
        });
    </script>
@endsection
