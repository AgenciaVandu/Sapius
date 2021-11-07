@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Agregar prueba</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'pruebas.create'])
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
                    <form method="POST" action="{{ route(Auth::user()->rol[0]->slug.'.pruebas.store') }}">
                        @csrf

                        <input name="curso_id" type="hidden" value="{{ $curso->id }}">
                        <input name="leccion_id" type="hidden" value="{{ $leccion->id }}">

                        <div class="form-group row">
                            <div class="col-md-12">
                            <label for="tipo">Tipo</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="EXANI">EXANI</option>
                                    <option value="EGEL">EGEL</option>
                                    <option value="ENARM">ENARM</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                            <label for="titulo">Título</label>
                            <input id="titulo" type="text" class="form-control @error('nombre') is-invalid @enderror" name="titulo" value="" required autocomplete="titulo" autofocus>

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" required autocomplete="descripcion" autofocus>{{ old('descripcion') }}</textarea>

                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="tiempo">Tiempo (Examen)</label>
                                <input id="tiempo" type="time" class="form-control @error('tiempo') is-invalid @enderror" name="tiempo" required autocomplete="tiempo" autofocus>

                                @error('tiempo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="tiempo_caducidad">Tiempo de caducidad (Días del examen)</label>
                                <input id="tiempo_caducidad" type="number" min="0" class="form-control @error('tiempo_caducidad') is-invalid @enderror" name="tiempo_caducidad"  required autocomplete="tiempo_caducidad" autofocus>

                                @error('tiempo_caducidad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="tiempo_vigencia">Tiempo de vigencia (Feedback o retroalimentación)</label>
                                <input id="tiempo_vigencia" type="time" class="form-control @error('tiempo_vigencia') is-invalid @enderror" name="tiempo_vigencia"  required autocomplete="tiempo_vigencia" autofocus>

                                @error('tiempo_vigencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
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

@section('css')
    <link href="{{ asset('vendor/summernote/summernote.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>

    <script>
        $(document).ready( function () {
            $('#descripcion').summernote({
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
        } );
    </script>
@endsection
