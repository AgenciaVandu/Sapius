@extends('layouts.adminmart.detalle')

@section('content')
    {{-- <input type="hidden" id="curso" value="{{ $curso->Curso->titulo }}">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Metodos de pago</h4>
            <h6 class="card-subtitle">A continuación selecciona tu método de pago e introduce los datos solicitados.
            </h6>
            <form method="POST" action="{{ route('inscripcion.pago') }}" class="mt-4" id="form-pago">
                @csrf
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#home" id="tarjeta" data-toggle="tab" aria-expanded="true" class="nav-link active">
                            <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">Tarjeta Credito/Debito</span>
                            <img src="{{ asset('img/logo_conekta_color.svg') }}" class="img-fluid" alt="conekta">
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#profile" id="oxxo" data-toggle="tab" aria-expanded="false"
                            class="nav-link">
                            <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">Oxxo</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="home">
                        <div class="form-group">
                            <label for="nombretarjetahabiente">Nombre del tarjetahabiente</label>
                            <input type="text" class="form-control" id="nombretarjetahabiente"

                                    placeholder="Ej. Oscar Robles Torres" size="20" data-conekta="card[name]" />
                        </div>
                        <div class="form-group">
                            <label for="tarjeta">Número de la tarjeta de crédito</label>
                            <input type="text" class="form-control" id="tarjeta"

                                    placeholder="Ej. 87129873" size="20" data-conekta="card[number]" />
                        </div>
                        <div class="form-row">
                            <label>
                                <span>CVC</span>
                                <input type="text" size="4"
                                         data-conekta="card[cvc]"/>
                            </label>
                        </div>
                        <div class="form-row">
                            <label>
                                <span>Fecha de expiración (MM/AAAA)</span>
                                <input type="text" size="2"
                                         data-conekta="card[exp_month]"/>
                            </label>
                            <span>/</span>
                            <label>
                                <input type="text" size="4"
                                         data-conekta="card[exp_year]"/>
                            </label>
                        </div>
                    </div>
                    {{-- <div class="tab-pane" id="profile">
                        A continuacion se generara una ficha para pagar a travez de Oxxo pay.
                    </div> --
                </div>
                <hr>
                <input type="hidden" id="tipo_cobro" name="tipo_cobro" value="tarjeta">
                <input type="hidden" id="curso_programado_id" name="curso_programado_id" value="{{ $curso->id }}">
                <div class="form-group">
                    <div id="divAlerts"></div>
                    <label for="">Precio</label>
                    <label id="text_descuento"></label>
                    <input type="text" class="form-control" id="precio" value="${{ $curso->precio_en_moneda }} MxN" disabled>
                    <input type="hidden" id="precioh" name="precio" value="{{ str_replace(",","",$curso->precio_en_moneda) }}">
                    <!---<input type="hidden" id="authName" name="authName" value="{{ auth()->user()->nombre.''.auth()->user()->apellido }}">
                    <input type="hidden" id="authEmail" name="authEmail" value="{{ auth()->user()->email }}">
                    <input type="hidden" id="authPhone" name="authPhone" value="{{ auth()->user()->telefono }}">-->

                </div>
                <div class="form-group">
                    <input type="text" id="clave" class="form-control" name="clave" placeholder="Código de descuento">
                    <button type="button" class="btn btn-primary" id="descuento">Agregar descuento</button>
                </div>
            </form>
        </div>
    </div> --}}


@endsection

@section('javascript')

    <script>
        $(document).ready(function() {
            $(".modal-title").html("Inscripción al curso " + $('#curso').val());
            $("#pago").click(function() {
                //$("#form-pago").submit();
                //event.preventDefault();
                var $form = $('#form-pago');
                //$form = $(this);

                /* Previene hacer submit más de una vez */
                $("#pago").prop("disabled", true);
                Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
                /* Previene que la información de la forma sea enviada al servidor */
                return false;
            });
            //Codigo para el tipo de transaccion
            $("#tarjeta").click(function() {
                $("#tipo_cobro").val("tarjeta");
            });
            $("#oxxo").click(function() {
                $("#tipo_cobro").val("oxxo");
            });
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
            //Codigo para conekta........
            var conektaSuccessResponseHandler;
            conektaSuccessResponseHandler = function(token) {
                var $form;
                $form = $('#form-pago');

                /* Inserta el token_id en la forma para que se envíe al servidor */
                $form.append($("<input type=\"hidden\" name=\"conektaTokenId\" />").val(token.id));

                /* and submit */
                $form.get(0).submit();
            };

            conektaErrorResponseHandler = function(token) {
                console.log(token);
            };
        });

    </script>
@endsection
