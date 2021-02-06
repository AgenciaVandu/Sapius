@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Editar Pregunta: {{ $pregunta->pregunta }}</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'preguntas.edit'])
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
                    <form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.preguntas.update') }} " enctype="multipart/form-data">
                        @csrf

                        <input name="id" type="hidden" value="{{ $pregunta->id }}">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="pregunta" >Pregunta</label>
                                <textarea id="pregunta" class="form-control @error('nombre') is-invalid @enderror" name="pregunta" required autocomplete="pregunta" autofocus>{!! $pregunta->pregunta !!}</textarea>

                                @error('pregunta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                           <div class="col-md-12">
                               <label for="slug" >Slug</label>
                                <input id="slug" type="text" class="form-control @error('nombre') is-invalid @enderror" name="slug" value="{{ $pregunta->slug }}" required autocomplete="slug" autofocus>

                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="opciones" >Retroalimentación</label>
                                <textarea id="opciones" class="form-control @error('nombre') is-invalid @enderror" name="opciones" required autocomplete="opciones" autofocus>{{ $pregunta->opciones }}</textarea>

                                @error('opciones')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="descripcion" >Imagen</label>

                                <label for="descripcion" >Imagen</label>
                                @if ($leccion->imagen)
                                <a href="#" id="btnEliminarImagen">Eliminar imagen</a>
                                <input name="imgEliminar" type="hidden" value="">
                                <img src="{{ route(Auth::user()->rol[0]->slug.'.preguntas.image',['file' => $pregunta->imagen]) }}" id="img" alt="..." class="img-thumbnail">
                                @endif

                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile02" accept="image/*">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Cambiar imagen</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="score" >Score</label>

                                <input id="score" type="number" step="0.01" class="form-control @error('score') is-invalid @enderror" name="score" value="{{ $pregunta->score }}" required autocomplete="score" autofocus>

                                @error('score')
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

            $( "#btnEliminarImagen" ).click(function() {
                $('#img').hide();
                $('#btnEliminarImagen').hide();
                $('#imgEliminar').val('si')
            });
        });

        $('#pregunta, #opciones').summernote({
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
