@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Sorpote Técnico</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['alumno.soporte-enviar']]) }}
                        @method('POST')
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="nombre">{{ __('Asunto') }}</label>
                                <input type="text" name="asunto" id="asunto" class="form-control" required>
                                @if ($errors->has('asunto'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('asunto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="apellido">{{ __('Comentario') }}</label>
                                <textarea name="comentario" id="comentario" rows="10" class="form-control" required></textarea>
                                @if ($errors->has('comentario'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('comentario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                            {{ Form::submit('Enviar',['class'=>'btn btn-primary btn-block']) }}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
