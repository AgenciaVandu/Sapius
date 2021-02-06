@component('emails.message')
#  Bienvenido(a) al curso:

    ¡Gracias! por tu compra:

    Monto: {{ $datos['monto'] }}
    Referencia: {{ $datos['referencia'] }}

    {{-- Ha solicitado la ficha de pago por concepto de "Inscripción de Nuevo Ingreso" adjunto a este correo. --}}

@endcomponent
