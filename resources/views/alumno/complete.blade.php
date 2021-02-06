@extends('layouts.adminmart.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{ __('Completar datos de: ') }} {{ $user->nombre." ".$user->apellido }}</h4>
                    {{ Form::open(['route' => [Auth::user()->rol[0]->slug.'.updateComplete',$user->id], 'files' => true]) }}
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                {{ Form::text('nombre',$user->nombre,['class' => 'form-control','required' => true])}}

                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apellido" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

                            <div class="col-md-6">
                                {{ Form::text('apellido',$user->apellido,['class' => 'form-control','required' => true])}}

                                @if ($errors->has('apellido'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apellido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>

                            <div class="col-md-6">
                                {{ Form::number('telefono',$user->telefono,['class' => 'form-control','required' => true])}}

                                @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="folio" class="col-md-4 col-form-label text-md-right">{{ __('Folio') }}</label>

                            <div class="col-md-6">
                            {{ Form::text('folio',$user->folio,['class' => 'form-control','required' => true])}}

                                @if ($errors->has('folio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('folio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_sustentacion" class="col-md-4 col-form-label text-md-right">{{ __('Fecha sustentación') }}</label>

                            <div class="col-md-6">
                            {{ Form::input('dateTime-local','fecha_sustentacion',($user->fecha_sustentacion) ? date('Y-m-d\TH:i', strtotime($user->fecha_sustentacion)): date('Y-m-d\TH:i'),['class' => 'form-control','required' => true])}}

                                @if ($errors->has('fecha_sustentacion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fecha_sustentacion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="universidad_procedencia" class="col-md-4 col-form-label text-md-right">{{ __('Universidad de procedencia') }}</label>

                            <div class="col-md-6">
                            {{ Form::text('universidad_procedencia',$user->universidad_procedencia,['class' => 'form-control','required' => true])}}

                                @if ($errors->has('universidad_procedencia'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apeluniversidad_procedencialido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="especialidad" class="col-md-4 col-form-label text-md-right">{{ __('Especialidad') }}</label>

                            <div class="col-md-6">
                            {{ Form::text('especialidad',$user->especialidad,['class' => 'form-control','required' => true])}}

                                @if ($errors->has('especialidad'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apelespecialidadlido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="rowImagen">
                            <label for="foto" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                            <div class="col-md-6">
                                @if($user->foto !== null && $user->foto !== "")
                                    <input name="imgEliminar" type="hidden" value="">
                                    <img id="img"
                                         src="{{ route(Auth::user()->rol[0]->slug.'.image',['file' => $user->foto]) }}" alt="image"
                                         class="img-thumbnail" width="150" style="margin: 0 auto">
                                     <a href="#" id="btnEliminarImagen" class="btn btn-danger btn-circle-lg"><i class="fa fa-times"></i> </a>
                                    <hr>
                                    @endif
                                <div class="custom-file">
                                    <input type="file" name="foto" class="custom-file-input" id="inputGroupFile02" accept="image/*">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                                        @if($user->foto !== null && $user->foto !== "")
                                        Cambiar imagen
                                        @else
                                        Selecciona foto
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->rol[0]->slug == 'admin' || Auth::user()->rol[0]->slug == 'alumno')
                        <div class="form-group row" id="rowImagen">
                            <label for="documento_identificacion" class="col-md-4 col-form-label text-md-right">{{ __('Documento de identificación') }}</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" name="documento_identificacion" class="custom-file-input" id="inputGroupFile02" accept="application/pdf">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                                        @if($user->documento_identificacion !== null && $user->documento_identificacion !== "")
                                        Cambiar documento
                                        @else
                                        Selecciona identificación
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @if($user->documento_identificacion !== null && $user->documento_identificacion !== "")
                            <a href="{{ URL::route(Auth::user()->rol[0]->slug.'.documento',['file' => $user->documento_identificacion]) }}" class="btn btn-secondary"><i class="fas fa-download"></i>
                            </a>
                            @endif
                        </div>

                        <div class="form-group row" id="rowImagen">
                            <label for="pase_ingreso" class="col-md-4 col-form-label text-md-right">{{ __('Pase de ingreso') }}</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" name="pase_ingreso" class="custom-file-input" id="inputGroupFile02" accept="application/pdf">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                                        @if($user->pase_ingreso !== null && $user->pase_ingreso !== "")
                                        Cambiar documento
                                        @else
                                        Selecciona pase
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @if($user->pase_ingreso !== null && $user->pase_ingreso !== "")
                                <a href="{{ URL::route(Auth::user()->rol[0]->slug.'.pase',['file' => $user->pase_ingreso]) }}" class="btn btn-secondary"><i class="fas fa-download"></i>
                                </a>
                            @endif
                        </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            {{ Form::submit('Actualizar',['class'=>'btn btn-primary btn-block']) }}
                            </div>
                        </div>
                    {{ Form::close() }}
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

            $( "#btnEliminarImagen" ).click(function() {
                $('#img').hide();
                $('#btnEliminarImagen').hide();
                $('#imgEliminar').val('si')
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
            }
            $( "#tipo" ).change(function() {
                setSelect();
            });
            setSelect();
        } );
    </script>
@endsection
