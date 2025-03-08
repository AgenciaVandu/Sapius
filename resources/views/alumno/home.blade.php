@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Hola
                    {{ Auth::user()->nombre_completo }}</h2>
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Tus cursos</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-columns">
                @foreach ($cursos as $inscripcion)
                    @foreach ($inscripcion->CursoProgramado()->get() as $cursop)
                        @foreach ($cursop->Curso()->get() as $curso)
                            <div class="card shadow">
                                @if ($curso->imagen)
                                    <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->imagen]) }}"
                                        id="img" alt="..." class="img-thumbnail">
                                @else
                                    <img class="card-img-top img-fluid"
                                        src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                                        alt="Card image cap">
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title">
                                        {{ $curso->titulo }}
                                        <span class="badge badge-primary">{{ $cursop->identificador }}</span>
                                    </h4>
                                    <p class="card-text">{!! $curso->descripcion !!}</p>
                                    <form method="POST" action="{{ route('cursos.detallado') }}">
                                        @csrf
                                        <input name="curso_programado_id" type="hidden" value="{{ $cursop->id }}">
                                        @if ($inscripcion->aceptado == 'no')
                                            <button type="submit" class="btn btn-warning btn-block rounded-10">
                                                Aprobración Pendiente
                                            </button>
                                        @elseif($inscripcion->aceptado == 'si')
                                            <button type="submit" class="btn btn-success btn-block rounded-10">
                                                En Curso
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
