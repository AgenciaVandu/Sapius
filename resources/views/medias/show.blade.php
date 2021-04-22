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
<div style="text-align: center">
    <video width="100%" src="https://sapius.com.mx/storage/{{ $media->ruta }}" controls controlsList="nodownload">
        {{-- <video id="video" width="600" controls controlsList="nodownload"> --}}
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
        var xhr = new XMLHttpRequest();
        xhr.responseType = 'blob';

        xhr.onload = function() {
        var reader = new FileReader();
            reader.onloadend = function() {
                var byteCharacters = atob(reader.result.slice(reader.result.indexOf(',') + 1));
                var byteNumbers = new Array(byteCharacters.length);
                for (var i = 0; i < byteCharacters.length; i++) {
                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                }
                var byteArray = new Uint8Array(byteNumbers);
                var blob = new Blob([byteArray], {type: 'video/mp4'});
                var url = URL.createObjectURL(blob);
                document.getElementById('video').src = url;
            }
            reader.readAsDataURL(xhr.response);
        };
        @if(auth()->user()->hasRole('alumno') == false)
        xhr.open('GET', '{{ route(Auth::user()->rol[0]->slug.'.medias.stream2',['filename'=>$media->ruta]) }}');
        @else
        xhr.open('GET', '{{ route(Auth::user()->rol[0]->slug.'.medias.stream',['filename'=>$media->ruta]) }}');
        @endif
        xhr.send();
    });
</script>
@endsection
