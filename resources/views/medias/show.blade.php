@extends('layouts.adminmart.detalle')

@section('content')

<table class="table table-borderless table-striped">
    <tbody>
        @if(auth()->user()->hasRole('alumno') == false)
        <tr>
            <th scope="row">Tipo:</th>
            <td>{{ $media->tipo }}<td>
        </tr>
        <tr>
            <th scope="row">Ruta:</th>
            <td>{{ $media->ruta }}<td>
        </tr>
        @endif
        @if($media->tipo == "imagen")
        <tr>
            <th scope="row">Imagen:</th>
            <td>
                @if($media->ruta)
                    <img src="{{ route(Auth::user()->rol[0]->slug.'.medias.image',['file' => $media->ruta]) }}" id="img" alt="..." class="img-thumbnail">
                @endif
            <td>
        </tr>
        @endif
    </tbody>
</table>

@if($media->tipo == "video")
@php
    $streamRoute = auth()->user()->hasRole('alumno') === false 
        ? route(Auth::user()->rol[0]->slug . '.medias.stream2', ['filename' => $media->ruta])
        : route(Auth::user()->rol[0]->slug . '.medias.stream', ['filename' => $media->ruta]);
@endphp
<div style="text-align: center">
    <video width="100%" src="{{ $streamRoute }}" controls preload="metadata" controlsList="nodownload">
        Your browser does not support the video tag.
    </video>
</div>
@endif

@endsection

@section('javascript')
<script>
    $(document).ready( function () {
        //Boton del modal que carga
        $("#continuar").hide();
    });
</script>
@endsection
