
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Finalización imprevista.</h4>
        <h6 class="card-subtitle">Se ha detectado el uso indebido
de la plataforma y violación de las restricciones previstas en el contrato de servicios,
de los términos y condiciones. Por ello, no podrá continuar con el examen y se le
negará la retroalimentación correspondiente, nos reservamos el derecho de negar el
acceso permanente a la plataforma.
        </h6>
        <form method="POST" action="{{ route('examen.finalizar') }}" class="mt-4" id="form-finalizar">
            @csrf
            <input type="hidden" name="examen_id" value="{{$examen_id}}">
            <input type="hidden" name="leccion_id" value="{{$leccion_id}}">
            <input type="hidden" name="curso_programado_id" value="{{$curso_programado_id}}">
            <input type="hidden" name="inscripcion_id" value="{{$inscripcion_id}}">
            <button type="submit" class="btn btn-danger btn-block">Finalizar</button>
        </form>
    </div>
</div>
