@extends('layouts.adminmart.default')

@section('css')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <style>
        @charset "US-ASCII";
        @import "http://fonts.googleapis.com/css?family=Lato:300,400,700";

        * {
            color: #444;
            font-family: Lato;
            font-size: 16px;
            font-weight: 300;
        }

        ::-webkit-input-placeholder {
            font-style: italic;
        }

        :-moz-placeholder {
            font-style: italic;
        }

        ::-moz-placeholder {
            font-style: italic;
        }

        :-ms-input-placeholder {
            font-style: italic;
        }

        body {
            float: left;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        strong {
            font-weight: 700;
        }

        a {
            cursor: pointer;
            display: block;
            text-decoration: none;
        }

        a.button {
            border-radius: 5px 5px 5px 5px;
            -webkit-border-radius: 5px 5px 5px 5px;
            -moz-border-radius: 5px 5px 5px 5px;
            text-align: center;
            font-size: 21px;
            font-weight: 400;
            padding: 12px 0;
            width: 100%;
            display: table;
            background: #E51F04;
            background: -moz-linear-gradient(top, #E51F04 0%, #A60000 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #E51F04), color-stop(100%, #A60000));
            background: -webkit-linear-gradient(top, #E51F04 0%, #A60000 100%);
            background: -o-linear-gradient(top, #E51F04 0%, #A60000 100%);
            background: -ms-linear-gradient(top, #E51F04 0%, #A60000 100%);
            background: linear-gradient(top, #E51F04 0%, #A60000 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#E51F04', endColorstr='#A60000', GradientType=0);
        }

        a.button i {
            margin-right: 10px;
        }

        a.button.disabled {
            background: none repeat scroll 0 0 #ccc;
            cursor: default;
        }

        .bkng-tb-cntnt {
            float: left;
            width: 800px;
        }

        .bkng-tb-cntnt a.button {
            color: #fff;
            float: right;
            font-size: 18px;
            padding: 5px 20px;
            width: auto;
        }

        .bkng-tb-cntnt a.button.o {
            background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
            color: #e51f04;
            border: 1px solid #e51f04;
        }

        .bkng-tb-cntnt a.button i {
            color: #fff;
        }

        .bkng-tb-cntnt a.button.o i {
            color: #e51f04;
        }

        .bkng-tb-cntnt a.button.right i {
            float: right;
            margin: 2px 0 0 10px;
        }

        .bkng-tb-cntnt a.button.left {
            float: left;
        }

        .bkng-tb-cntnt a.button.disabled.o {
            border-color: #ccc;
            color: #ccc;
        }

        .bkng-tb-cntnt a.button.disabled.o i {
            color: #ccc;
        }

        .pymnts {
            float: left;
            width: 800px;
        }

        .pymnts * {
            float: left;
        }

        .sctn-row {
            margin-bottom: 35px;
            width: 800px;
        }

        .sctn-col {
            width: 375px;
        }

        .sctn-col.l {
            width: 425px;
        }

        .sctn-col input {
            border: 1px solid #ccc;
            font-size: 18px;
            line-height: 24px;
            padding: 10px 12px;
            width: 333px;
        }

        .sctn-col label {
            font-size: 24px;
            line-height: 24px;
            margin-bottom: 10px;
            width: 100%;
        }

        .sctn-col.x3 {
            width: 300px;
        }

        .sctn-col.x3.last {
            width: 200px;
        }

        .sctn-col.x3 input {
            width: 210px;
        }

        .sctn-col.x3 a {
            float: right;
        }

        .pymnts-sctn {
            width: 800px;
        }

        .pymnt-itm {
            margin: 0 0 3px;
            width: 800px;
        }

        .pymnt-itm h2 {
            background-color: #e9e9e9;
            font-size: 24px;
            line-height: 24px;
            margin: 0;
            padding: 28px 0 28px 20px;
            width: 100%;
        }

        .pymnt-itm.active h2 {
            cursor: default;
        }

        .pymnt-itm div.pymnt-cntnt {
            display: none;
        }

        .pymnt-itm.active div.pymnt-cntnt {
            background-color: #f7f7f7;
            display: block;
            padding: 0 0 30px;
            width: 100%;
        }

        .pymnt-cntnt div.sctn-row {
            margin: 20px 30px 0;
            width: 740px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col {
            width: 345px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col.l {
            width: 395px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col input {
            width: 303px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col.half {
            width: 155px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col.half.l {
            float: left;
            width: 190px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col.half input {
            width: 113px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col.cvv {
            background-image: url({{ asset('img/checkout/cvv.png') }});
            background-position: 156px center;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }

        .pymnt-cntnt div.sctn-row div.sctn-col.cvv div.sctn-col.half input {
            width: 110px;
        }

        .openpay {
            float: right;
            height: 60px;
            margin: 10px 30px 0 0;
            width: 435px;
        }

        .openpay div.logo {
            background-image: url({{ asset('img/checkout/openpay.png') }});
            background-position: left bottom;
            background-repeat: no-repeat;
            border-right: 1px solid #ccc;
            font-size: 12px;
            font-weight: 400;
            height: 69px;
            padding: 15px 20px 0 0;
        }

        .openpay div.shield {
            background-image: url({{ asset('img/checkout/security.png') }});
            background-position: left bottom;
            background-repeat: no-repeat;
            font-size: 12px;
            font-weight: 400;
            margin-left: 20px;
            padding: 20px 0 0 40px;
            width: 200px;
        }

        .card-expl {
            float: left;
            height: 80px;
            margin: 20px 0;
            width: 800px;
        }

        .card-expl div {
            background-position: left 45px;
            background-repeat: no-repeat;
            height: 70px;
            padding-top: 10px;
        }

        .card-expl div.debit {
            background-image: url({{ asset('img/checkout/cards2.png') }});
            margin-left: 20px;
            width: 540px;
        }

        .card-expl div.credit {
            background-image: url({{ asset('img/checkout/cards1.png') }});
            border-right: 1px solid #ccc;
            margin-left: 30px;
            width: 209px;
        }

        .card-expl h4 {
            font-weight: 400;
            margin: 0;
        }
    </style>
@endsection
@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    Pasarela de pagos</h2>
                {{-- <h3 class="page-title text-truncate text-dark font-weight-medium mb-1"></h3> --}}
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-6">
                <div class="bkng-tb-cntnt">
                    <div class="pymnts">
                        <form action="{{ route('checkout.processPayout') }}" method="POST" id="payment-form">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="token_id" id="token_id">
                            <div class="pymnt-itm card active">
                                <h2>Tarjeta de crédito o débito</h2>
                                <div class="pymnt-cntnt">
                                    <div class="card-expl">
                                        <div class="credit">
                                            <h4>Tarjetas de crédito</h4>
                                        </div>
                                        <div class="debit">
                                            <h4>Tarjetas de débito</h4>
                                        </div>
                                    </div>
                                    <div class="sctn-row">
                                        <div class="sctn-col l">
                                            <label>Nombre del titular</label><input type="text"
                                                placeholder="Como aparece en la tarjeta" autocomplete="off"
                                                data-openpay-card="holder_name" value="{{ $user->nombre . ' ' . $user->apellido }}">
                                        </div>
                                        <div class="sctn-col">
                                            <label>Número de tarjeta</label><input type="text" maxlength="16"
                                                minlength="16" autocomplete="off" placeholder="1234 5678 9012 3456"
                                                data-openpay-card="card_number">
                                        </div>
                                    </div>
                                    <div class="sctn-row">
                                        <div class="sctn-col l">
                                            <label>Fecha de expiración</label>
                                            <div class="sctn-col half l"><input type="text"
                                                    data-openpay-card="expiration_month" maxlength="2" placeholder="MM"
                                                    minlength="2"></div>
                                            <div class="sctn-col half l"><input type="text"
                                                    data-openpay-card="expiration_year" maxlength="2" minlength="2"
                                                    placeholder="YY"></div>
                                        </div>
                                        <div class="sctn-col cvv"><label>Código de seguridad</label>
                                            <div class="sctn-col half l"><input type="text" placeholder="3 dígitos"
                                                    autocomplete="off" data-openpay-card="cvv2"></div>
                                        </div>
                                        <div>
                                            <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                                            <input type="hidden" name="curso_precio" value="{{ $curso->precio }}">
                                            <input type="hidden" name="curso_descripcion"
                                                value="{{ $curso->identificador }}">
                                            <input type="hidden" name="user_name" value="{{ $user->nombre }}">
                                            <input type="hidden" name="user_lastname" value="{{ $user->apellido }}">
                                            <input type="hidden" name="user_email" value="{{ $user->email }}">
                                            <input type="hidden" name="user_phone" value="{{ $user->telefono }}">
                                        </div>
                                    </div>
                                    <div class="openpay">
                                        <div class="logo">Transacciones realizadas vía:</div>
                                        <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256
                                            bits
                                        </div>
                                    </div>
                                    <div class="sctn-row">
                                        <a class="button rght" id="pay-button">Pagar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                {{-- Informacion del curso --}}
                <div class="card ml-4">
                    {{-- <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                        id="img" alt="..." class="img-thumbnail" style="height: 120px"> --}}
                    <div class="card-body">
                        <h2 class="card-title">{{ $curso->curso->titulo }}</h2>
                        <p class="card-text">{!! $curso->curso->descripcion !!}</p>
                        <h2>Total: ${{ number_format($curso->precio, 2) }} MXN</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {

        OpenPay.setId('m4gx48zqyw8xs4en1z1u');
        OpenPay.setApiKey('pk_de55d471af484c4080a63e7463fc9cd4');
        OpenPay.setSandboxMode(true);
        //Se genera el id de dispositivo
        var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
        /* console.log(deviceSessionId); */

        $('#pay-button').on('click', function(event) {
            event.preventDefault();
            $("#pay-button").prop("disabled", true);
            OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
        });

        var sucess_callbak = function(response) {
            var token_id = response.data.id;
            $('#token_id').val(token_id);
            $('#payment-form').submit();
        };

        var error_callbak = function(response) {
            var desc = response.data.description != undefined ? response.data.description : response
                .message;
            alert("ERROR [" + response.status + "] " + desc);
            $("#pay-button").prop("disabled", false);
        };

    });
</script>
@endsection
