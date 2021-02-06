@extends('layouts.adminmart.detalle')

@section('content')

<table class="table table-borderless table-striped">
    <tbody>
        <tr>
            <th scope="row">Respuesta:</th>
            <td>{{ $respuesta->respuesta }}<td>
        </tr>
        <tr>
            <th scope="row">Imagen:</th>
            <td>
                @if($respuesta->imagen)
                    <img src="{{ route(Auth::user()->rol[0]->slug.'.respuestas.image',['file' => $respuesta->imagen]) }}" id="img" alt="..." class="img-thumbnail">
                @endif
            <td>
        </tr>
        <tr>
            <th scope="row">Correcto:</th>
            <td>
                <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" disabled id="customSwitch2" @if($respuesta->correcto == 1) checked @endif >
                    <label class="custom-control-label" for="customSwitch2">@if($respuesta->correcto == 1) Correcto @else Incorrecto @endif</label>
                </div>
            <td>
        </tr>
        <tr>
            <th scope="row">Posicion:</th>
            <td>{{ $respuesta->posicion }}<td>
        </tr>

    </tbody>
</table>

@endsection
