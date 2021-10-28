@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    {{ $curso_programado->Curso->titulo }}</h3>
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
        <div class="col-md-8">
            <div class="card">
                @if ($curso_programado->Curso->imagen !== null && $curso_programado->Curso->imagen !== '')
                    <img class="card-img-top img-fluid"
                        src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso_programado->Curso->imagen]) }}"
                        alt="Card image cap">
                @else
                    <img class="card-img-top img-fluid" src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}"
                        alt="Card image cap">
                @endif
                <div class="card-body">
                    <p class="card-text">{!! $curso_programado->Curso->descripcion !!}</p>
                    <p>
                    <h4 class="card-title">Módulos</h4>
                    <div class="list-group">
                        @foreach ($curso_programado->Curso->Lecciones as $item)
                            @if ($inscrito == null || ($inscrito != null && $inscrito->aceptado == 'no'))
                                <a href="javascript:void(0)" class="list-group-item disabled">
                                    {{ $item->titulo }}
                                </a>
                            @elseif($inscrito != null && $inscrito->aceptado == 'si')
                                @php
                                    $hoy = strtotime(date('m/d/Y'));
                                    $hora = date('H:m');
                                    $fecha_inicial = $fecha_final = null;
                                    if ($contenido_programado) {
                                        $contenido = collect($contenido_programado->contenido)
                                            ->where('id', $item->id)
                                            ->first();
                                        $fecha_inicial = $contenido['fecha_inicial'];
                                        $array_fecha_inicial = explode('/', $fecha_inicial);
                                        $fecha_inicial = $contenido['fecha_inicial'] ? $array_fecha_inicial[1] . '/' . $array_fecha_inicial[0] . '/' . $array_fecha_inicial[2] : null;
                                        $hora_inicial = $contenido['hora_inicial'] ? $contenido['hora_inicial'] : null;
                                        $date_start = new DateTime($fecha_inicial . ' ' . $hora_inicial);
                                        /* $fecha_inicial = ($contenido['fecha_inicial'])? strtotime(str_replace('/','-',$contenido['fecha_inicial'])) : null; */
                                        /* $fecha_final = ($contenido['fecha_final'])? strtotime(str_replace('/','-',$contenido['fecha_final'])) :null; */
                                        $fecha_final = $contenido['fecha_final'];
                                        $array_fecha_final = explode('/', $fecha_final);
                                        $fecha_final = $contenido['fecha_final'] ? $array_fecha_final[1] . '/' . $array_fecha_final[0] . '/' . $array_fecha_final[2] : null;
                                        $hora_final = $contenido['hora_final'] ? $contenido['hora_final'] : null;
                                        $date_end = new DateTime ($fecha_final . ' ' . $hora_final);
                                    }
                                    $verifica_fecha = $hoy >= $fecha_inicial && $hoy <= $fecha_final;
                                    $date_diff_start = $date_start->diff(date_create('now'));
                                    $date_diff_end = $date_end->diff(date_create('now'));
                                @endphp
                                {{-- {{ dd($date_diff_start) }} --}}
                                @if ($date_diff_end->invert == 1 && $date_diff_start->invert == 0)
                                    <a href="javascript:void(0)" class="list-group-item" onclick="event.preventDefault();
                                                        document.getElementById('form{{ $item->id }}').submit();">
                                        {{ $item->titulo }}
                                    </a>
                                    <form method="POST" action="{{ route('leccion.detallada') }}"
                                        id="form{{ $item->id }}">
                                        @csrf
                                        <input name="leccion_id" type="hidden" value="{{ $item->id }}">
                                        <input name="curso_programado_id" type="hidden"
                                            value="{{ $curso_programado->id }}">
                                        <input name="inscripcion_id" type="hidden" value="{{ $inscrito->id }}">
                                    </form>
                                @else
                                    <a href="javascript:void(0)" class="list-group-item disabled">
                                        {{ $item->titulo }}
                                    </a>
                                @endif
                            @endif
                        @endforeach
                    </div>
                    </p>
                </div>
                <div class="card-footer text-muted">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($inscrito == null)
                                <a href="javascript:void(0)" class="btn btn-block btn-dark btn-detalle"
                                    {{-- id="{{ route('inscripcion.form', ['curso_programado_id' => $curso_programado->id]) }}" --}}>Inscribir</a>
                            @elseif($inscrito->aceptado == 'no')
                                <div class="alert alert-warning bg-warning text-white border-0" role="alert">
                                    Aprobración <strong>Pendiente</strong>
                                </div>
                            @else
                                <div class="alert alert-success" role="alert">
                                    <strong>En Curso</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <small>Inicia: {{ date('d/m/Y', strtotime($curso_programado->fecha_inicio)) }}
                                <br>Finaliza: {{ date('d/m/Y', strtotime($curso_programado->fecha_fin)) }}</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="pago">Comprar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
@endsection
