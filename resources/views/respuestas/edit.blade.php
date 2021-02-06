@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Editar respuesta de la pregunta {{ $pregunta->pregunta }}</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'respuestas.edit'])
                    {{-- Prueba {{ $prueba->titulo }} de la leccion {{ $leccion->titulo }} del curso {{ $curso->titulo }} --}}
                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.respuestas.update') }} " enctype="multipart/form-data">
                        @csrf

                        <input name="id" type="hidden" value="{{ $respuesta->id }}">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="respuesta" >Respuesta</label>
                                <textarea id="respuesta" class="form-control @error('nombre') is-invalid @enderror" name="respuesta" required autocomplete="respuesta" autofocus>{{ $respuesta->respuesta }}</textarea>

                                @error('respuesta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="descripcion" >Imagen</label>
                                @if ($respuesta->imagen)
                                <a href="#" id="btnEliminarImagen">Eliminar imagen</a>
                                <input name="imgEliminar" type="hidden" value="">
                                <img src="{{ route(Auth::user()->rol[0]->slug.'.respuestas.image',['file' => $respuesta->imagen]) }}" id="img" alt="..." class="img-thumbnail">
                                @endif

                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile02" accept="image/*">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Cambiar imagen</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="correcto" >Correcto</label>
                                <div class="custom-control custom-switch">
                                    {{-- input para el switch si esta check es 1 si no 0 --}}
                                    <input name="correcto" id="correcto" type="hidden">
                                    <input type="checkbox" id="correctoSwitch" class="custom-control-input" @if($respuesta->correcto == 1) checked @endif>
                                    <label id="labelcorrecto" class="custom-control-label" for="correctoSwitch">Correcta</label>
                                </div>
                                @error('correcto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="posicion" >Posicion</label>
                                <input id="posicion" type="number" class="form-control @error('posicion') is-invalid @enderror" name="posicion" value="{{ $respuesta->posicion }}" required autocomplete="posicion" autofocus>

                                @error('posicion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('vendor/summernote/summernote.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready( function () {
            //cambiar nombre de input importar
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                if (fileName) {
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    $('#img').hide();
                    $('#btnEliminarImagen').hide();
                    $('#imgEliminar').val('')
                }else{
                    $(this).siblings(".custom-file-label").addClass("selected").html("Selecciona Imagen");
                    $('#img').show();
                    $('#btnEliminarImagen').show();
                    $('#imgEliminar').val('')
                }
            });

            $("#btnEliminarImagen" ).click(function() {
                $('#img').hide();
                $('#btnEliminarImagen').hide();
                $('#imgEliminar').val('si')
            });

            $("#correctoSwitch" ).change(function() {
                checkSwitch();
            });

            function checkSwitch(){
                if($("#correctoSwitch").is(':checked')) {
                    $("#labelcorrecto").text("Correcta");
                    $("#correcto").val(1);
                } else {
                    $("#labelcorrecto").text("Incorrecta");
                    $("#correcto").val(0);
                }
            }
            checkSwitch();
        });

        $('#respuesta').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
    </script>
@endsection
