@extends('layouts.adminmart.default')

@section('content')
    @php
        $precio = $curso->precio;

        if (session('descuento')) {
            $precio = $curso->precio - session('descuento');
        }
    @endphp

    {{ session('descuento') }}
    <input type="hidden" id="curso" value="{{ $curso->Curso->titulo }}">
    <div class="card">
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
                        <a href="#profile" id="oxxo" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">Oxxo</span>
                        </a>
                    </li> --}}
                </ul>
                <div id="conektaIframeContainer" style="height: 700px;"></div>
            @endsection

            @section('javascript')
                <script type="text/javascript">
                    window.ConektaCheckoutComponents.Integration({
                        targetIFrame: "#conektaIframeContainer",
                        checkoutRequestId: "42a4c95e-0db2-4ae8-9bb3-ea681acc8281", // checkout request id
                        publicKey: "key_OKaHFsyf7d8dHe9fyKomsig",
                        options: {},
                        styles: {},
                        onFinalizePayment: function(event) {
                            console.log(event);
                        }
                    })
                </script>
                {{-- <script>
        $(document).ready(function() {
            $(".modal-title").html("Inscripción al curso " + $('#curso').val());
            $("#pago").click(function() {
            $("#form-pago").submit();
            event.preventDefault();
            var $form = $('#form-pago');
            $form = $(this);

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
    </script> --}}
            @endsection
