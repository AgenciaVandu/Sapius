@component('emails.message')
#  El usuario {{ $datos['usuario'] }} tiene el siguiente comentario:

    {!! $datos['comentario'] !!}

@endcomponent
