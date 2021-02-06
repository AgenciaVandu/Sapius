@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Token Conekta</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.menu',['form' => 'Lecciones'])
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('cursos.paymentOxxo') }}" method="POST" id="card-form" role="form">
                        @csrf
                        <span class="card-errors"></span>
                        <div class="form-group">
                            <label for="nombretarjetahabiente">Nombre del tarjetahabiente</label>
                            <input type="text" class="form-control" id="nombretarjetahabiente"
                                    value="Oscar Robles Torres"
                                    placeholder="Ej. Oscar Robles Torres" size="20" data-conekta="card[name]" />
                        </div>
                        <div class="form-group">
                            <label for="tarjeta">Número de la tarjeta de crédito</label>
                            <input type="text" class="form-control" id="tarjeta"
                                    value="4242424242424242"
                                    placeholder="Ej. 87129873" size="20" data-conekta="card[number]" />
                        </div>
                        <div class="form-row">
                            <label>
                                <span>CVC</span>
                                <input type="text" size="4"
                                        value="123" data-conekta="card[cvc]"/>
                            </label>
                        </div>
                        <div class="form-row">
                            <label>
                                <span>Fecha de expiración (MM/AAAA)</span>
                                <input type="text" size="2"
                                        value="01" data-conekta="card[exp_month]"/>
                            </label>
                            <span>/</span>
                            <label>
                                <input type="text" size="4"
                                        value="2022" data-conekta="card[exp_year]"/>
                            </label>
                        </div>
                        <button id="processPayment" class="btn btn-success" type="submit">Procesar pago</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
    <script type="text/javascript">
        // Conekta Public Key
        Conekta.setPublishableKey('key_eYvWV7gSDkNYXsmr');
        // ...
    </script>
    <script>
        $(document).ready( function () {
            var conektaSuccessResponseHandler;
            conektaSuccessResponseHandler = function(token) {
                var $form;
                $form = $("#card-form");

                /* Inserta el token_id en la forma para que se envíe al servidor */
                $form.append($("<input type=\"hidden\" name=\"conektaTokenId\" />").val(token.id));

                /* and submit */
                $form.get(0).submit();
            };

            conektaErrorResponseHandler = function(token) {
                console.log(token);
            };

            $("#card-form").submit(function(event) {
                event.preventDefault();
                var $form;
                $form = $(this);

                /* Previene hacer submit más de una vez */
                $form.find("button").prop("disabled", true);
                Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
                /* Previene que la información de la forma sea enviada al servidor */
                return false;
            });
        } );
    </script>
@endsection
