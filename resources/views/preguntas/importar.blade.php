@extends('layouts.adminmart.detalle')
@section('content')

<div class="card">
    <div class="card-header">Importar Preguntas</div>
    <div class="card-body">
        <form ethod="POST" action="{{ route(Auth::user()->rol[0]->slug.'.preguntas.importar') }}" enctype="multipart/form-data"  class="dropzone">
            @csrf
            <input name="prueba_id" type="hidden" value="{{ $prueba->id }}">
            <div class="dz-message" data-dz-message><span>Adjuntar documento</span></div>
        </form>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.min.css') }}">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/dropzone/dropzone.min.js') }}"></script>

    <script>
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone",{
            maxFilesize: 10,  // 10 mb
            acceptedFiles: ".xls,.xlsx",
            uploadMultiple: false,
            dictDefaultMessage: "Adjuntado satisfactoriamente",
            dictFileTooBig: "Tamaño maximo del archivo es de 10 Mb",
            dictInvalidFileType: "Solo se permiten archivos tipo xls y xlsx",
            dictResponseError: "No se adjunto, debido a un error en el archivo",
        });

        myDropzone.on("success", function(x,id) {
            $('.dz-image').attr('style', 'background: #76b852 !important');
        });
        $(".modal-title").html("Importar Preguntas");

        myDropzone.on('error', function(file, response) {
            $(file.previewElement).find('.dz-error-message').text("No se adjunto, debido a un error en el archivo");
            $('.dz-image').attr('style', 'background: #e53935 !important');
        });
    </script>
@endsection
