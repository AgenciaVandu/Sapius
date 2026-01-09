@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Cursos</h3>
                <div class="d-flex align-items-center">

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
            <div class="row">
                @foreach ($cursos as $curso)
                    @if ($curso->curso->activo == 'si')
                        <div class="col-md-4 d-flex align-items-stretch">
                            <div class="card w-100 shadow">
                                @if ($curso->Curso->imagen)
                                    <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                                        id="img" alt="..." class="card-img-top img-fluid"
                                        style="height: 200px; object-fit: contain; width: 100%; background-color: #f8f9fa;">
                                @else
                                    <img class="card-img-top img-fluid"
                                        src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                                        alt="Card image cap"
                                        style="height: 200px; object-fit: contain; width: 100%; background-color: #f8f9fa;">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title">{{ $curso->Curso->titulo }} <span
                                            class="badge badge-primary">{{ $curso->identificador }}</span></h4>
                                    <p class="card-text flex-grow-1">{!! $curso->Curso->descripcion !!}</p>
                                    <form method="POST"
                                        action="{{ route(Auth::user()->rol[0]->slug . '.cursos.lista-inscritos') }}"
                                        class="mt-3">
                                        @csrf
                                        <input name="curso_programado_id" type="hidden" value="{{ $curso->id }}">
                                        <button type="submit" class="btn btn-dark btn-block">Detalles</button>
                                    </form>
                                </div>
                                <div class="card-footer text-muted">
                                    <small>Inicio: {{ date('d/m/Y', strtotime($curso->fecha_inicio)) }}
                                        <br>Finaliza: {{ date('d/m/Y', strtotime($curso->fecha_fin)) }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
