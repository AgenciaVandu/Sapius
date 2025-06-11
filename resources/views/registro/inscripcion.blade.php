@extends('layouts.adminmart.default')

@section('content')
    @php
        $precio = $curso->precio;

        if (session('descuento')) {
            $precio = $curso->precio - session('descuento');
        }
    @endphp

    {{-- {{ session('descuento') }} --}}
    <input type="hidden" id="curso" value="{{ $curso->Curso->titulo }}">
    <div class="card">
        <div class="row justify-content-center px-5">
            <div class="col-5 px-5">
                <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                    id="img" alt="..." class="img-thumbnail">
            </div>
            <div class="col-5">
                <div class="card-body text-center">
                    <h1>
                        {{ $curso->Curso->titulo }}
                    </h1>

                    <small>
                        {!! $curso->Curso->descripcion !!}
                    </small>
                    <h3>
                        ${{ number_format($precio, 2) }}
                    </h3>
                    <h4 class="card-title">Metodos de pago</h4>
                    <h6 class="card-subtitle">A continuación selecciona tu método de pago e introduce los datos solicitados.
                    </h6>
                    {{--             <form action="{{ route('descuentos.check') }}" method="POST" class="px-5 py-2">
                    @csrf
                    @if (session('descuento'))
                    <div class="alert alert-success">Descuento aplicado</div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">No se encontro la clave o ya expiro</div>
                    @endif
                    @if (session('limit'))
                    <div class="alert alert-warning">Descuento agotado</div>
                    @endif
                    <div class="form-group">
                        <input type="text" class="form-control" name="clave"
                            placeholder="Código de descuento">
                        <input type="hidden" name="curso_programado_id" value="{{ $curso->id }}">
                        <button type="submit" class="btn btn-primary mt-2">Agregar descuento</button>
                    </div>
                </form> --}}
                </div>
            </div>
        </div>
        <div>
            {{-- Boton para ir al pago --}}
            <a href="{{ route('alumno.checkout', $curso) }}" class="btn btn-primary btn-block">Ir al pago</a>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            /*  $(".modal-title").html("Inscripción al curso " + $('#curso').val());
             $("#pago").click(function() { */
            //$("#form-pago").submit();
            //event.preventDefault();
            /* var $form = $('#form-pago'); */
            //$form = $(this);

            /* Previene hacer submit más de una vez */
            /* $("#pago").prop("disabled", true);
            Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler); */
            /* Previene que la información de la forma sea enviada al servidor */
            /*     return false;
            }); */
            //Codigo para el tipo de transaccion
            /* $("#tarjeta").click(function() {
                $("#tipo_cobro").val("tarjeta");
            }); */
            /* $("#oxxo").click(function() {
                $("#tipo_cobro").val("oxxo");
            }); */
            //Codigo para el descuento
            $("#descuento").click(function() {
                var precio = $("#precioh").val();
                var clave = $("#clave").val();
                var curso_programado_id = $("#curso_programado_id").val();
                var token = "{{ csrf_token() }}";
                $.post("{{ route('descuentos.check') }}", {
                    _token: token,
                    clave: clave,
                    curso_programado_id: curso_programado_id
                }, function() {}).done(function(data) {
                    descuento = JSON.parse(data);
                    if (descuento.descuento > 0) {
                        $("#descuento").hide();
                        $("#clave").hide();
                        $("#precio").val('$ ' + (precio - ((descuento.descuento / 100) * precio)) +
                            ' MxN');
                        $("#precioh").val((precio - ((descuento.descuento / 100) * precio)));
                        $("#text_descuento").html(', descuento aplicado <strike>$ ' + precio +
                            ' MxN</strike>');
                        $("#divAlerts").html(
                            '<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>¡Correcto!</strong> Descuento aplicado </div>'
                        );
                        console.log('pase por aqui');
                    } else {
                        $("#divAlerts").html(
                            '<div class="alert alert-warning alert-dismissible bg-warning text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>Advertencia !</strong> ' +
                            descuento.mensaje + ' </div>');
                    }
                }).fail(function() {
                    $("#rowValidar").show();
                    $("#rowValidarOk").hide();
                    $("#divAlerts").html(
                        '<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>Error !</strong> No se aplicaron los cambios </div>'
                    );
                });
            });
        });
    </script>
@endsection
