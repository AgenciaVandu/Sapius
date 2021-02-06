@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Agregar Multimedia</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'medias.create'])
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
                    <form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.medias.store') }}" enctype="multipart/form-data">
                        @csrf

                        <input name="leccion_id" type="hidden" value="{{ $leccion->id }}">

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">Tipo de multimedia</label>

                            <div class="col-md-6">
                                <select id="tipo" class="form-control @error('nombre') is-invalid @enderror" name="tipo" value="" required autocomplete="tipo" autofocus>
                                    <option value="imagen">Imagen</option>
                                    <option value="archivo">Archivo</option>
                                    <option value="liga" selected>Liga</option>
                                    @if($video == null &&  $videoext == null)
                                    <option value="video">Video</option>
                                    @endif
                                   <!-- @if($video == null &&  $videoext == null)
                                    <option value="videoext">Video Externo</option>
                                    @endif-->
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" id="rowRuta">
                            <label for="ruta" class="col-md-4 col-form-label text-md-right">Ruta</label>

                            <div class="col-md-6">
                                <input id="ruta" type="text" class="form-control @error('ruta') is-invalid @enderror" name="ruta" value="{{ old('ruta') }}" autocomplete="ruta" autofocus>

                                @error('ruta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" id="rowImagen">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Imagen</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile02" accept="image/*">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="rowArchivo">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Archivo</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Selecciona</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready( function () {
            //cambiar nombre de input importar
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                if (fileName) {
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                }else{
                    $(this).siblings(".custom-file-label").addClass("selected").html("Selecciona archivo");
                }
            });
            //cambios en el select de multimedia
            function setSelect(){
                var seleccion = $( "select#tipo option:checked" ).val();
                if(seleccion == "imagen"){
                    $( "#rowImagen" ).show();
                    $( "#rowRuta" ).hide();
                    $( "#rowArchivo" ).hide();
                }
                if(seleccion == "archivo"){
                    $( "#rowArchivo" ).show();
                    $( "#rowRuta" ).hide();
                    $( "#rowImagen" ).hide();
                }
                if(seleccion == "liga"){
                    $( "#rowRuta" ).show();
                    $( "#rowImagen" ).hide();
                    $( "#rowArchivo" ).hide();
                }
                if(seleccion == "video"){
                    $( "#rowRuta" ).show();
                    $( "#rowImagen" ).hide();
                    $( "#rowArchivo" ).hide();
                }
                if(seleccion == "videoext"){
                    $( "#rowRuta" ).show();
                    $( "#rowImagen" ).hide();
                    $( "#rowArchivo" ).hide();
                }
            }
            $( "#tipo" ).change(function() {
                setSelect();
            });
            setSelect();
        } );
    </script>

@endsection
