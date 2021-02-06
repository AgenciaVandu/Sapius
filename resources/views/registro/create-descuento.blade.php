@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ __('Descuentos') }}</h3>
                @if($descuento->id)
                @include('genericos.breadcrum',['route' => 'descuento.edit'])
                @else
                @include('genericos.breadcrum',['route' => 'descuento.create'])
                @endif
                <div class="d-flex align-items-center">
                    @if($descuento->id) {{ "Editar" }} @else {{ "Agregar" }} @endif
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
                    <form method="POST" action="@if($descuento->id) {{ route('descuento.update') }} @else {{ route('descuento.store') }} @endif">
                        @csrf
                        <input name="curso_programado_id" type="hidden" value="{{ $curso_programado_id}}">
                        <input name="descuento_id" type="hidden" value="{{ $descuento->id }}">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="clave">Clave</label>
                                <input id="clave" type="text" class="form-control @error('clave') is-invalid @enderror" name="clave" autofocus value="@if($descuento->clave == "") {{ uniqid() }} @else {{ $descuento->clave }} @endif">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="descuento">% de descuento (1 - 100)</label>
                            <input id="descuento" type="number" min="1" max="100" 
                                    class="form-control @error('descuento') is-invalid @enderror" 
                                    name="descuento" 
                                    required autocomplete="descuento" 
                                    autofocus 
                                    value="{{ $descuento->descuento }}">
                                @error('descuento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="limite">Límite</label>
                            <input id="limite" type="number" min="1" class="form-control @error('limite') is-invalid @enderror" name="limite" required autofocus step="1" value="{{ $descuento->limite}}">
                                @error('limite')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    @if($descuento->clave == "")
                                        Registrar
                                    @else
                                        Actualizar
                                    @endif
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
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/select2/select2-bootstrap4.min.css') }}" rel="stylesheet"/>
@endsection

@section('javascript')
    <script src="{{ asset('vendor/DatePicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/DatePicker/js/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#instructor').select2({
                theme: 'bootstrap4',
                width: 'style',
            });
        });

        $('#fecha_inicio,#fecha_fin').datepicker({language: "es",clearBtn: true,todayHighlight: true});
    </script>
@endsection
