@extends('layouts.adminmart.detalle')

@section('content')
    <input type="hidden" id="curso" value="">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Para terminar</h4>
            <h6 class="card-subtitle">Acepta que todas las preguntas fueron respondidas
            </h6>
            <form method="POST" action="{{ route('examen.finalizar') }}" class="mt-4" id="form-finalizar">
                @csrf
                <input type="hidden" name="examen_id" value="{{$examen_id}}">
                <input type="hidden" name="leccion_id" value="{{$leccion_id}}">
                <input type="hidden" name="curso_programado_id" value="{{$curso_programado_id}}">
                <input type="hidden" name="inscripcion_id" value="{{$inscripcion_id}}">
            </form>
        </div>
    </div>
@endsection

@section('javascript')
   <script>
        $(document).ready( function () {
            $(".modal-title").html("Finalizar examen");
            $("#finalizar").click(function(){
                $("#form-finalizar").submit();
            });
        });
    </script>
@endsection
