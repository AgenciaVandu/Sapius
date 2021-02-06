@component('emails.message')

¡Bienvenido a la familia SAPIUS!

{{ $datos['nombre'] }} {{ $datos['apellido'] }}

@endcomponent



@section('css')
<link href="{{ asset('vendor/oxxopay-payment-stub/demo/styles.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
@endsection