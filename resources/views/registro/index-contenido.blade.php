@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Programar contenido del curso</h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum',['route' => 'contenido.index'])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body ">
                    <table class="table table-striped table-sm" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Módulos - Clases</th>
                                <th>Fecha inicial</th>
                                <th>Hora inicial</th>
                                <th>Fecha final</th>
                                <th>Hora final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('contenido.store') }}" method="POST">
                                @csrf
                                <input id="curso_id" type="hidden" name="curso_id" value="{{ $cp['curso']->id }}">
                                <input id="curso_programado_id" type="hidden" name="curso_programado_id"
                                    value="{{ $cp->id }}">
                                @foreach ($cp['Curso']['Lecciones'] as $leccion)
                                    @php
                                        //dd($cp['Curso']['Lecciones']);
                                        $fecha_inicial = $fecha_final = null;
                                        if ($contenido_programado) {
                                            $contenido = collect($contenido_programado->contenido)
                                                ->where('id', $leccion->id)
                                                ->first();
                                            $fecha_inicial = $contenido['fecha_inicial'] ? $contenido['fecha_inicial'] : null;
                                            $hora_inicial = $contenido['hora_inicial'] ? $contenido['hora_inicial'] : null;
                                            $fecha_final = $contenido['fecha_final'] ? $contenido['fecha_final'] : null;
                                            $hora_final = $contenido['hora_final'] ? $contenido['hora_final'] : null;
                                        }
                                    @endphp
                                    <tr style="border-block-start: medium solid blue;">
                                        <td>
                                            {{ $leccion->titulo }}
                                            <input id="leccion_id_{{ $leccion->id }}" type="hidden"
                                                name="leccion_id_{{ $leccion->id }}" value="{{ $leccion->id }}">
                                        </td>
                                        <td>
                                            <input id="fecha_inicial_{{ $leccion->id }}" type="text" class="calendar"
                                                name="fecha_inicial_{{ $leccion->id }}" required
                                                autocomplete="fecha_inicial_{{ $leccion->id }}" autofocus
                                                value="@if ($fecha_inicial) {{ $fecha_inicial }} @endif">
                                        </td>
                                        <td>
                                            <input id="fecha_final_{{ $leccion->id }}" type="text" class="calendar"
                                                name="fecha_final_{{ $leccion->id }}" required
                                                autocomplete="fecha_final_{{ $leccion->id }}" autofocus
                                                value="@if ($fecha_final) {{ $fecha_final }} @endif">
                                        </td>
                                        <td>
                                            <input type="time" name="hora_inicial_{{ $leccion->id }}" required
                                            autocomplete="hora_inicial_{{ $leccion->id }}" autofocus
                                            value="{{ $hora_inicial }}">
                                        </td>
                                        <td>
                                            <input type="time" name="hora_final_{{ $leccion->id }}" required
                                            autocomplete="hora_final_{{ $leccion->id }}" autofocus
                                            value="{{ $hora_final }}">
                                        </td>
                                    </tr>
                                    @foreach ($leccion['Clases'] as $clase)
                                        @php
                                            //dd($cp['Curso']['Lecciones']);
                                            $fecha_inicial = $fecha_final = null;
                                            if ($contenido_programado) {
                                                $contenido = collect($contenido_programado->contenido)
                                                    ->where('id', $clase->id)
                                                    ->first();
                                                $fecha_inicial = $contenido['fecha_inicial'] ? $contenido['fecha_inicial'] : null;
                                                $hora_inicial = $contenido['hora_inicial'] ? $contenido['hora_inicial'] : null;
                                                $fecha_final = $contenido['fecha_final'] ? $contenido['fecha_final'] : null;
                                                $hora_final = $contenido['hora_final'] ? $contenido['hora_final'] : null;
                                            }
                                        @endphp
                                        <tr>
                                            <td >
                                                {{ $clase->titulo }}
                                                <input id="leccion_id_{{ $clase->id }}" type="hidden"
                                                    name="leccion_id_{{ $clase->id }}" value="{{ $clase->id }}">
                                            </td>
                                            <td>
                                                <input id="fecha_inicial_{{ $clase->id }}" type="text"
                                                    class="calendar" name="fecha_inicial_{{ $clase->id }}" required
                                                    autocomplete="fecha_inicial_{{ $clase->id }}" autofocus
                                                    value="@if ($fecha_inicial) {{ $fecha_inicial }} @endif">
                                            </td>
                                            <td>
                                                <input id="fecha_final_{{ $clase->id }}" type="text"
                                                    class="calendar" name="fecha_final_{{ $clase->id }}" required
                                                    autocomplete="fecha_final_{{ $clase->id }}" autofocus
                                                    value="@if ($fecha_final) {{ $fecha_final }} @endif">
                                            </td>
                                            <td>
                                                <input type="time" name="hora_inicial_{{ $clase->id }}" required
                                                autocomplete="hora_inicial_{{ $clase->id }}" autofocus
                                                value="{{ $hora_inicial }}">
                                            </td>
                                            <td>
                                                <input type="time" name="hora_final_{{ $clase->id }}" required
                                                autocomplete="hora_final_{{ $clase->id }}" autofocus
                                                value="{{ $hora_final }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td colspan="5">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Register') }}
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
    <link href="{{ asset('vendor/DatePicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('vendor/DatePicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/DatePicker/js/bootstrap-datepicker.es.min.js') }}"></script>

    <script>
        $('.calendar').datepicker({
            language: "es",
            clearBtn: true,
            todayHighlight: true
        });

    </script>
@endsection
