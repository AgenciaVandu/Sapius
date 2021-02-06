@extends('layouts.adminmart.detalle')

@section('content')

<table class="table table-borderless table-striped">
    <tbody>
        <tr>
            <th scope="row">Pregunta:</th>
            <td>{!! $pregunta->pregunta !!}<td>
        </tr>
        <tr>
            <th scope="row">Imagen:</th>
            <td>
                @if($pregunta->imagen)
                    <img src="{{ route(Auth::user()->rol[0]->slug.'.preguntas.image',['file' => $pregunta->imagen]) }}" id="img" alt="..." class="img-thumbnail">
                    
                @endif
            <td>
        </tr>
        <tr>
            <th scope="row">Score:</th>
            <td>{{ $pregunta->score }}<td>
        </tr>
    </tbody>
</table>

@endsection
