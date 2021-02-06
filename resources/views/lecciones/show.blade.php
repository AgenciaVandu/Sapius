@extends('layouts.adminmart.detalle')

@section('content')

<table class="table table-borderless table-striped">
    <tbody>
        <tr>
            <th scope="row">Título:</th>
            <td>{{ $leccion->titulo }}<td>
        </tr>
        <tr>
            <th scope="row">Slug:</th>
            <td>{{ $leccion->slug }}<td>
        </tr>
        <tr>
            <th scope="row">Imagen:</th>
            <td>
                @if($leccion->imagen)
                    <img src="{{ route(Auth::user()->rol[0]->slug.'.lecciones.image',['file' => $leccion->imagen]) }}" id="img" alt="..." class="img-thumbnail">
                @endif
            <td>
        </tr>
        <tr>
            <th scope="row">Contenido:</th>
            <td>{!! $leccion->contenido !!}<td>
        </tr>
        <tr>
            <th scope="row">Resumen:</th>
            <td>{{ $leccion->resumen }}<td>
        </tr>
    </tbody>
</table>

@endsection
