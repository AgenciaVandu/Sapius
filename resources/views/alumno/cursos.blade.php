@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Hola
                    {{ Auth::user()->nombre_completo }}</h2>
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Cursos disponibles</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-columns">
                @foreach ($cursos as $curso)
                    @if ($curso->curso->activo == 'si')
                        <div class="card shadow">
                            <a href="javscript:void(0)"
                                onclick="event.preventDefault(); document.getElementById('curso-{{ $curso->id }}').submit();">
                                @if ($curso->Curso->imagen)
                                    <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                                        id="img" alt="..." class="img-thumbnail">
                                @else
                                    <img class="card-img-top img-fluid"
                                        src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                                        alt="Card image cap">
                                @endif
                            </a>
                            <form method="POST" action="{{ route('cursos.detallado') }}" id="curso-{{ $curso->id }}">
                                @csrf
                                <input name="curso_programado_id" type="hidden" value="{{ $curso->id }}">
                            </form>
                            <div class="card-body">
                                <h4 class="card-title">{{ $curso->Curso->titulo }} <span
                                        class="badge badge-primary">{{ $curso->identificador }}</span></h4>
                                <p class="card-text">{!! $curso->Curso->descripcion !!}</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4> ${{ $curso->precio_en_moneda }} MxN</h4>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <a href="javascript:void(0)" class="btn btn-block btn-dark rounded-10 btn-detalle" id="{{ route('inscripcion.form',$curso->id) }}">Comprar</a> --}}
                                        <a href="{{ route('inscripcion.form', $curso->id) }} }}"
                                            class="btn btn-block btn-dark rounded-10 btn-detalle">Comprar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    {{-- <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">Titulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="pago">Comprar</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
    <script type="text/javascript">
        // Conekta Public Key
        Conekta.setPublishableKey('key_sqDsFRvLBF3xEPZiYYJjtA');
        // ...
    </script>
@endsection
