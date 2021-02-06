@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Payment Conekta</h3>
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

                    <div class="opps">
                        <div class="opps-header">
                            <div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
                            <div class="opps-info">
                                <div class="opps-brand"><img src="{{ asset('vendor/oxxopay-payment-stub/demo/oxxopay_brand.png') }}" alt="OXXOPay"></div>
                                <div class="opps-ammount">
                                    <h3>Monto a pagar</h3>
                                    <h2>$ {{ number_format($order->amount/100, 2) }} <sup>MXN</sup></h2>
                                    <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                                </div>
                            </div>
                            <div class="opps-reference">
                                <h3>Referencia</h3>
                            <h1>{{ join("-", str_split($order->charges[0]->payment_method->reference, 4)) }}</h1>
                            </div>
                        </div>
                        <div class="opps-instructions">
                            <h3>Instrucciones</h3>
                            <ol>
                                <li>Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
                                <li>Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                                <li>Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
                                <li>Realiza el pago correspondiente con dinero en efectivo.</li>
                                <li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
                            </ol>
                            <div class="opps-footnote">Al completar estos pasos recibirás un correo de <strong>Nombre del negocio</strong> confirmando tu pago.</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link href="{{ asset('vendor/oxxopay-payment-stub/demo/styles.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
@endsection
