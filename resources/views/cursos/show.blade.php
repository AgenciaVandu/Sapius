@extends('layouts.adminmart.detalle')

@section('content')

<table class="table table-borderless table-striped">
    <tbody>
        <tr>
            <th scope="row">Título:</th>
            <td>{{ $curso->titulo }}<td>
        </tr>
        <tr>
            <th scope="row">Slug:</th>
            <td>{{ $curso->slug }}<td>
        </tr>
        <tr>
            <th scope="row">Descripción:</th>
            <td>{!! $curso->descripcion !!}<td>
        </tr>
        <tr>
            <th scope="row">Imagen:</th>
            <td>
                @if($curso->imagen)
                    <img src="{{ route(Auth::user()->rol[0]->slug.'.cursos.image',['file' => $curso->imagen]) }}" id="img" alt="..." class="img-thumbnail">
                @endif
            <td>
        </tr>
    </tbody>
</table>

@endsection
