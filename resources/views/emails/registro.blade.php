@component('emails.message')
<style>
    .h1{
        color:red;
        text-align: center;
    }
</style>


<h1 class="h1">¡Bienvenido a la familia SAPIUS!</h1>

<h1 class="h1">{{ $datos['nombre'] }} {{ $datos['apellido'] }}</h1>




@endcomponent







@section('css')
{{-- <link href="{{ asset('vendor/oxxopay-payment-stub/demo/styles.css') }}" media="all" rel="stylesheet" type="text/css" />

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet"> --}}

@endsection