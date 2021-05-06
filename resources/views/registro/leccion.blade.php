@extends('layouts.adminmart.default')

@section('css')
    <style>
        @media screen and (max-width: 800px) {
            div {
                display: none;
            }
        }
        }

    </style>

@endsection

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $leccion->Curso->titulo }}</h3>
                <div class="d-flex align-items-center">
                    {{ $leccion->titulo }}
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
                @if (isset($video) || isset($videoext))
                    <!-- @if (isset($video)) -->
                            <div style="text-align: center">
                                <video style="width:100%" src="https://sapius.com.mx/storage/{{ $video->ruta }}" controls controlsList="nodownload">
                                    Tu navegador no soporta la etiqueta video.
                                </video>
                            </div>
                    <!--@elseif (isset($videoext))
                             <div style="text-align: center">
                                <iframe width="100%" height="360" src="{{ $videoext->ruta }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                               </div> @endif-->

                @else
                    @if ($leccion->imagen !== null && $leccion->imagen !== '')
                        <img class="card-img-top img-fluid"
                            src="{{ route(Auth::user()->rol[0]->slug . '.lecciones.image', ['file' => $leccion->imagen]) }}"
                            alt="Card image cap">
                    @else
                        <img class="card-img-top img-fluid"
                            src="{{ asset('vendor/adminmart/assets/images/big/cursos.png') }}" alt="Card image cap">
                    @endif
                @endif
                <div class="card-body" id="clases">
                    <h4 class="card-title">{{ $leccion->titulo }}</h4>
                    <p class="card-text">{!! $leccion->contenido !!}</p>
                    @if (count($leccion->Clases))
                        <p>
                        <h4 class="card-title">Clases</h4>
                        <div class="list-group">
                            @foreach ($leccion->Clases as $item)
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
                                        $date_end = new DateTime($fecha_final . ' ' . $hora_final);
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
                            @endforeach
                        </div>
                        </p>
                    @endif
                </div>
                <div class="card-footer text-muted">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if ($leccion->Medias->count())
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Multimedia</h4>
                        <div class="list-group">
                            @foreach ($leccion->Medias as $m)
                                {{-- {{ $m->tipo}} --}}
                                @if ($m->tipo == 'liga')
                                    <a class="list-group-item" href="{{ $m->ruta }}" target="blank">
                                        {{-- <i class="fas fa-eye"></i> --}}
                                        Ir a la liga
                                    </a>
                                @elseif($m->tipo == "imagen")
                                    <a class="list-group-item btn-detalle" href="javascript:void(0)"
                                        id="{{ route('alumnos.medias.show', $m->id) }}">
                                        {{-- <i class="fas fa-eye"></i> --}}
                                        Ver la imagen
                                    </a>
                                @elseif($m->tipo == "archivo")
                                    <a class="list-group-item"
                                        href="{{ URL::route(Auth::user()->rol[0]->slug . '.medias.archivo', ['file' => $m->ruta]) }}">
                                        {{-- <i class="fas fa-eye"></i> --}}
                                        Descargar archivo
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tareas</h4>
                    <div class="list-group">
                        <a class="list-group-item"
                            href="{{ route('alumno.lecciones.tarea', ['leccion_id' => $leccion->id, 'curso_programado_id' => $curso_programado_id]) }}"
                            target="_blank">
                            {{-- <i class="fas fa-eye"></i> --}}
                            Enviar tarea {{ strtolower($leccion->titulo) }}
                        </a>
                    </div>
                </div>
            </div>
            @if ($leccion->Pruebas->count())
                <div class="card examen">
                    <div class="card-body">
                        <h4 class="card-title">Pruebas</h4>
                        <div class="list-group">
                            @foreach ($leccion->Pruebas as $item)
                                @if ($item->Preguntas->count())
                                    <a href="javascript:void(0)" class="list-group-item btn-detalle"
                                        id="{{ route('examen.previo', ['prueba_id' => $item->id, 'inscripcion_id' => $inscripcion_id]) }}">
                                        {{ $item->titulo }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if ($leccion->Curso->Lecciones->count())
                <div class="card d-none" id="otrasclases">
                    <div class="card-body">
                        <h4 class="card-title">Otras Lecciones</h4>
                        <div class="list-group">
                            @foreach ($leccion->Curso->Lecciones as $item)
                                @php
                                    $hoy = strtotime(date('d-m-Y'));
                                    $fecha_inicial = $fecha_final = null;
                                    if ($contenido_programado) {
                                        if ($item->leccion_id > 0) {
                                            $contenido = collect($contenido_programado->contenido)
                                                ->where('id', $item->leccion_id)
                                                ->first();
                                        } else {
                                            $contenido = collect($contenido_programado->contenido)
                                                ->where('id', $item->id)
                                                ->first();
                                        }
                                        $fecha_inicial = $contenido['fecha_inicial'] ? strtotime(str_replace('/', '-', $contenido['fecha_inicial'])) : null;
                                        $fecha_final = $contenido['fecha_final'] ? strtotime(str_replace('/', '-', $contenido['fecha_final'])) : null;
                                    }
                                    $verifica_fecha = $hoy >= $fecha_inicial && $hoy <= $fecha_final;
                                @endphp
                                @if ($verifica_fecha)
                                    <a href="javascript:void(0)" class="list-group-item" onclick="event.preventDefault();
                                    document.getElementById('form{{ $item->id }}').submit();">
                                        {{ $item->titulo }}
                                    </a>
                                    <form method="POST" action="{{ route('leccion.detallada') }}"
                                        id="form{{ $item->id }}">
                                        @csrf
                                        <input name="leccion_id" type="hidden" value="{{ $item->id }}">
                                        <input name="curso_programado_id" type="hidden"
                                            value="{{ $curso_programado_id }}">
                                        <input name="inscripcion_id" type="hidden" value="{{ $inscripcion_id }}">
                                    </form>
                                @else
                                    <a href="javascript:void(0)" class="list-group-item disabled" onclick="event.preventDefault();
                                    document.getElementById('form{{ $item->id }}').submit();">
                                        {{ $item->titulo }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
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
                    <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelar">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="continuar">Continuar...</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
    @if (isset($video))
        <script>
            $(document).ready(function() {
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob';

                xhr.onload = function() {
                    var reader = new FileReader();
                    reader.onloadend = function() {
                        var byteCharacters = atob(reader.result.slice(reader.result.indexOf(',') + 1));
                        var byteNumbers = new Array(byteCharacters.length);
                        for (var i = 0; i < byteCharacters.length; i++) {
                            byteNumbers[i] = byteCharacters.charCodeAt(i);
                        }
                        var byteArray = new Uint8Array(byteNumbers);
                        var blob = new Blob([byteArray], {
                            type: 'video/mp4'
                        });
                        var url = URL.createObjectURL(blob);
                        document.getElementById('videoClase').src = url;
                    }
                    reader.readAsDataURL(xhr.response);
                };
                @if (auth()->user()->hasRole('alumno') == false)
                    xhr.open('GET', '{{ route(Auth::user()->rol[0]->slug . '.medias.stream2', ['filename' => $video->ruta]) }}');
                @else
                    xhr.open('GET', '{{ route(Auth::user()->rol[0]->slug . '.medias.stream', ['filename' => $video->ruta]) }}');
                @endif
                xhr.send();
            });

        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                //Disable full page
                $("body").on("contextmenu", function(e) {
                    return false;
                });

            });

        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                //Disable full page
                $('body').bind('cut copy paste', function(e) {
                    e.preventDefault();
                });
            });

        </script>

    @endif
@endsection
