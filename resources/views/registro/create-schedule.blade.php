@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    {{ __('Curso programado: ' . $curso->titulo) }}</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum', ['route' => 'schedule.edit'])
                </div>
                <div class="d-flex align-items-center">
                    @if ($curso_programado->id)
                        {{ 'Editar' }}
                    @else
                        {{ 'Agregar' }}
                    @endif
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
                    <form method="POST"
                        action="@if ($curso_programado->id) {{ route('schedule.update') }} @else {{ route('schedule.store') }} @endif"
                        enctype="multipart/form-data">
                        @csrf
                        <input name="curso_id" type="hidden" value="{{ $curso->id }}">
                        <input name="curso_programado_id" type="hidden" value="{{ $curso_programado->id }}">

                        <div class="form-group row">
                            <label for="identificador" class="col-md-4 col-form-label text-md-right">Identificador</label>

                            <div class="col-md-6">
                                <input id="identificador" type="text"
                                    class="form-control @error('identificador') is-invalid @enderror" name="identificador"
                                    required autocomplete="identificador" autofocus
                                    value="@if ($curso_programado->identificador) {{ $curso_programado->identificador }} @endif">
                                @error('identificador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="instructor" class="col-md-4 col-form-label text-md-right">Instructor</label>
                            <div class="col-md-6">
                                <select name="instructor" id="instructor" class="form-control">

                                    @foreach ($instructores as $i)
                                        <option value="{{ $i['id'] }}"
                                            @if ($curso_programado->user_id == $i['id']) selected @endif)>
                                            {{ $i['nombre_completo'] }}</option>
                                    @endforeach
                                </select>

                                @error('instructor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_inicio" class="col-md-4 col-form-label text-md-right">Fecha Inicial</label>
                            <div class="col-md-6">
                                <input id="fecha_inicio" type="text"
                                    class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio"
                                    required autocomplete="fecha_inicio" autofocus
                                    value="@if ($curso_programado->id) {{ date('d/m/Y', strtotime($curso_programado->fecha_inicio)) }} @endif">
                                @error('fecha_inicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_fin" class="col-md-4 col-form-label text-md-right">Fecha Final</label>
                            <div class="col-md-6">
                                <input id="fecha_fin" type="text"
                                    class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin" required
                                    autocomplete="fecha_fin" autofocus
                                    value="@if ($curso_programado->id) {{ date('d/m/Y', strtotime($curso_programado->fecha_fin)) }} @endif">
                                @error('fecha_fin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_inicio" class="col-md-4 col-form-label text-md-right">Fecha Inicial Venta</label>
                            <div class="col-md-6">
                                <input id="fecha_inicio_venta" type="text"
                                    class="form-control @error('fecha_inicio_venta') is-invalid @enderror" name="fecha_inicio_venta"
                                    required autocomplete="fecha_inicio_venta" autofocus
                                    value="@if ($curso_programado->id) {{ date('d/m/Y', strtotime($curso_programado->fecha_inicio_venta)) }} @endif">
                                @error('fecha_inicio_venta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_fin" class="col-md-4 col-form-label text-md-right">Fecha Final Venta</label>
                            <div class="col-md-6">
                                <input id="fecha_fin_venta" type="text"
                                    class="form-control @error('fecha_fin_venta') is-invalid @enderror" name="fecha_fin_venta" required
                                    autocomplete="fecha_fin_venta" autofocus
                                    value="@if ($curso_programado->id) {{ date('d/m/Y', strtotime($curso_programado->fecha_fin_venta)) }} @endif">
                                @error('fecha_fin_venta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="precio" class="col-md-4 col-form-label text-md-right">Precio</label>

                            <div class="col-md-6">
                                <input id="precio" type="number"
                                    class="form-control @error('precio') is-invalid @enderror" name="precio" required
                                    autofocus step="0.01" value="{{ $curso_programado->precio }}">
                                @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="instructor" class="col-md-4 col-form-label text-md-right">Categoria</label>
                            <div class="col-md-6">
                                <select name="category_id" id="category" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" data-name="{{ $category->name }}"
                                            @if ($curso_programado->category_id == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Input file oculto inicialmente --}}
                        <div class="form-group row d-none" id="file-upload-group">
                            <label class="col-md-4 col-form-label text-md-right">Subir Archivo</label>
                            <div class="col-md-6">
                                <input type="file" name="guia_file" class="form-control-file">
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="clave_descuento" class="col-md-4 col-form-label text-md-right">Clave de descuento</label>

                            <div class="col-md-6">
                                <input id="clave_descuento" type="text" class="form-control @error('clave_descuento') is-invalid @enderror" name="clave_descuento" autofocus value="{{ $curso_programado->clace_descuento}}">
                            </div>
                        </div> --}}

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

@section('css')
    <link href="{{ asset('vendor/DatePicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/select2/select2-bootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('javascript')
    <script src="{{ asset('vendor/DatePicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/DatePicker/js/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('#instructor').select2({
                theme: 'bootstrap4',
                width: 'style',
            });

            $('#category').select2({
                theme: 'bootstrap4',
                width: 'style',
            });

            // Función para mostrar/ocultar input file si la categoría es "Guias"
            function toggleFileInput() {
                const selectedOption = $('#category').find(':selected');
                const selectedName = selectedOption.data('name'); // obtiene el data-name

                if (selectedName === 'Guias') {
                    $('#file-upload-group').removeClass('d-none');
                } else {
                    $('#file-upload-group').addClass('d-none');
                }
            }

            // Llamar al cargar la página por si ya está seleccionada "Guias"
            toggleFileInput();

            // Escuchar el evento select de Select2
            $('#category').on('select2:select', function() {
                toggleFileInput();
            });

            // Inicializar datepickers
            $('#fecha_inicio,#fecha_fin').datepicker({
                language: "es",
                clearBtn: true,
                todayHighlight: true
            });
            // Inicializar datepickers
            $('#fecha_inicio_venta,#fecha_fin_venta').datepicker({
                language: "es",
                clearBtn: true,
                todayHighlight: true
            });
        });
    </script>
@endsection
