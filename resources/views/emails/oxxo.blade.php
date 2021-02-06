@component('emails.message')
#  Bienvenido(a) al curso:

 ¡Gracias! por tu compra:

    {{-- Ha solicitado la ficha de pago por concepto de "Inscripción de Nuevo Ingreso" adjunto a este correo. --}}

@endcomponent

<div class="opps">
    <div class="opps-header">
        <div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
        <div class="opps-info">
            <div class="opps-brand"><img src="{{ asset('vendor/oxxopay-payment-stub/demo/oxxopay_brand.png') }}" alt="OXXOPay"></div>
            <div class="opps-ammount">
                <h3>Monto a pagar</h3>
                <h2>$ {{ number_format($datos['monto']/100, 2) }} <sup>MXN</sup></h2>
                <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
            </div>
        </div>
        <div class="opps-reference">
            <h3>Referencia</h3>
        <h1>{{ join("-", str_split($datos['referencia'], 4)) }}</h1>
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

@section('css')
<link href="{{ asset('vendor/oxxopay-payment-stub/demo/styles.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
@endsection
