@component('emails.message')
#  Alumno: {{ $datos['nombre'] }}

#  Leccion: {{ $datos['leccion'] }}

#  Tarea: {{ $datos['tarea'] }}

@endcomponent



@section('css')
<link href="{{ asset('vendor/oxxopay-payment-stub/demo/styles.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
@endsection
