@extends('layouts.adminmart.default')

@section('css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

    <style>
        @import url("https://fonts.googleapis.com/css?family=Lato:300,400,700");

        /*    * {
                font-family: 'Lato', sans-serif;
                font-weight: 300;
                color: #444;
            } */

        ::-webkit-input-placeholder,
        :-moz-placeholder,
        ::-moz-placeholder,
        :-ms-input-placeholder {
            font-style: italic;
        }

        .bg-primary2 {
            background-color: #001a45 !important;
            color: white !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-dark font-weight-medium mb-1">Pasarela de pagos</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-4">
        <div class="row">
            <!-- Sección del curso -->
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="card shadow border-0 w-100" style="max-width: 650px;">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3 class="mb-0 font-weight-bold">{{ $curso->curso->titulo }}</h3>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="text-secondary">{!! $curso->curso->descripcion !!}</p>
                        <hr>
                        @if (session()->has('descuento'))
                            @php
                                $descuento = session('descuento');
                                $precio_final = $curso->precio - $curso->precio * ($descuento / 100);
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span><del>Precio original</del></span>
                                <span><del>${{ number_format($curso->precio, 2) }} MXN</del></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Descuento ({{ $descuento }}%)</small>
                                <span class="text-success">- ${{ number_format($curso->precio * ($descuento / 100), 2) }}
                                    MXN</span>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <strong>Total a pagar:</strong>
                                <span class="h4">${{ number_format($precio_final, 2) }} MXN</span>
                            </div>
                        @else
                            <div class="d-flex justify-content-between mt-3">
                                <strong>Total a pagar:</strong>
                                <span class="h4">${{ number_format($curso->precio, 2) }} MXN</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Sección de pago -->
            <div class="col-12 col-md-6 mb-4 d-flex flex-column">
                <div class="card flex-grow-1">
                    <div class="card-header bg-primary2 text-white">
                        <h4 class="mb-0">Tarjeta de crédito o débito</h4>
                    </div>
                    <div class="card-body d-flex flex-column">

                        <form action="{{ route('checkout.processPayout') }}" method="POST" id="payment-form"
                            class="flex-grow-1 d-flex flex-column">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="token_id" id="token_id">

                            <div class="form-group">
                                <label for="holder_name">Nombre del titular</label>
                                <input id="holder_name" name="holder_name" type="text" class="form-control"
                                    placeholder="Como aparece en la tarjeta" autocomplete="off"
                                    data-openpay-card="holder_name" value="{{ $user->nombre . ' ' . $user->apellido }}">
                            </div>

                            <div class="form-group">
                                <label for="card_number">Número de tarjeta</label>
                                <input id="card_number" name="card_number" type="text" maxlength="16" minlength="16"
                                    autocomplete="off" class="form-control" placeholder="1234 5678 9012 3456"
                                    data-openpay-card="card_number">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="expiration_month">Mes expiración</label>
                                    <input id="expiration_month" name="expiration_month" type="text" class="form-control"
                                        data-openpay-card="expiration_month" maxlength="2" minlength="2" placeholder="MM">
                                </div>
                                <div class="form-group col-6">
                                    <label for="expiration_year">Año expiración</label>
                                    <input id="expiration_year" name="expiration_year" type="text" class="form-control"
                                        data-openpay-card="expiration_year" maxlength="2" minlength="2" placeholder="YY">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cvv2">Código de seguridad</label>
                                <input id="cvv2" name="cvv2" type="text" class="form-control"
                                    placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2" maxlength="3" minlength="3">
                            </div>

                            <!-- Campos ocultos -->
                            <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                            <input type="hidden" name="curso_precio"
                                value="{{ session()->has('descuento') ? $curso->precio - $curso->precio * (session('descuento') / 100) : $curso->precio }}">
                            <input type="hidden" name="curso_descripcion" value="{{ $curso->identificador }}">
                            <input type="hidden" name="user_name" value="{{ $user->nombre }}">
                            <input type="hidden" name="user_lastname" value="{{ $user->apellido }}">
                            <input type="hidden" name="user_email" value="{{ $user->email }}">
                            <input type="hidden" name="user_phone" value="{{ $user->telefono }}">
                            @if (session()->has('cupon_codigo'))
                                <input type="hidden" name="cupon" value="{{ session('cupon_codigo') }}">
                            @endif

                            <div class="mt-auto">
                                <button type="submit" id="pay-button" class="btn btn-danger btn-block">
                                    Pagar
                                </button>
                                <!-- Logos tarjetas con imágenes en HTML -->
                                <div class="d-flex justify-content-center my-3">
                                    <img src="{{ asset('img/checkout/cards1.png') }}" alt="Tarjetas de crédito"
                                        class="img-fluid mr-3" style="max-height: 60px;">
                                </div>
                                <div class="d-flex justify-content-center my-3">
                                    <img src="{{ asset('img/checkout/cards2.png') }}" alt="Tarjetas de débito"
                                        class="img-fluid" style="max-height: 60px;">
                                </div>
                                <!-- Logo OpenPay y escudo de seguridad -->
                                <div class="d-flex justify-content-end align-items-center mt-3" style="gap: 1rem;">
                                    <img src="{{ asset('img/checkout/openpay.png') }}" alt="OpenPay"
                                        style="height: 40px;">
                                    <span class="text-muted small">
                                        Tus pagos se realizan de forma segura con encriptación de 256 bits
                                    </span>
                                    <img src="{{ asset('img/checkout/security.png') }}" alt="Seguridad"
                                        style="height: 40px;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            const openpaySandbox = {{ env('OPENPAY_SANDBOX') ? 'true' : 'false' }};

            OpenPay.setId('{{ config('openpay.merchant_id') }}');
            OpenPay.setApiKey('{{ config('openpay.public_key') }}');
            OpenPay.setSandboxMode(openpaySandbox);

            OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

            $('#pay-button').on('click', function(event) {
                event.preventDefault();

                $(this).prop('disabled', true).text('Procesando...');

                OpenPay.token.extractFormAndCreate('payment-form', function(response) {
                    $('#token_id').val(response.data.id);
                    $('#payment-form').submit();
                }, function(response) {
                    let desc = response.data.description ? response.data.description : response
                        .message;
                    alert("ERROR [" + response.status + "] " + desc);
                    $('#pay-button').prop('disabled', false).text('Pagar');
                });
            });
        });
    </script>
@endsection
