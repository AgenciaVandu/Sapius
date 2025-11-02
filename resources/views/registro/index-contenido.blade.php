@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    Programar contenido del curso
                </h3>
                <div class="d-flex align-items-center">
                    @include('genericos.breadcrum', ['route' => 'contenido.index'])
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

                    <form action="{{ route('contenido.store') }}" method="POST" id="contenido-form">
                        @csrf
                        <input type="hidden" name="curso_id" value="{{ $cp['curso']->id }}">
                        <input type="hidden" name="curso_programado_id" value="{{ $cp->id }}">

                        <div class="accordion" id="accordionLecciones">
                            @foreach ($cp['Curso']['Lecciones'] as $modulo)
                                @if ($modulo->leccion_id == 0)
                                    @php
                                        $fecha_inicial = $fecha_final = null;
                                        $hora_inicial = $hora_final = null;

                                        if ($contenido_programado) {
                                            $contenido = collect($contenido_programado->contenido)
                                                ->where('id', $modulo->id)
                                                ->first();
                                            $fecha_inicial = $contenido['fecha_inicial'] ?? null;
                                            $fecha_final = $contenido['fecha_final'] ?? null;
                                            $hora_inicial = $contenido['hora_inicial'] ?? '00:00';
                                            $hora_final = $contenido['hora_final'] ?? '23:59';
                                        }
                                    @endphp

                                    {{-- MÓDULO PRINCIPAL --}}
                                    <div class="card mb-3 module" data-id="{{ $modulo->id }}">
                                        <div class="card-header bg-dark text-white" id="heading{{ $modulo->id }}">
                                            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-link text-white" type="button"
                                                    data-toggle="collapse" data-target="#collapse{{ $modulo->id }}"
                                                    aria-expanded="false" aria-controls="collapse{{ $modulo->id }}">
                                                    {{ $modulo->titulo }}
                                                </button>
                                                <div>
                                                    <input type="hidden" name="leccion_id_{{ $modulo->id }}"
                                                        value="{{ $modulo->id }}">
                                                    <input type="text" class="calendar"
                                                        name="fecha_inicial_{{ $modulo->id }}" required
                                                        placeholder="Fecha inicial" value="{{ $fecha_inicial }}">
                                                    <input type="text" class="calendar"
                                                        name="fecha_final_{{ $modulo->id }}" required
                                                        placeholder="Fecha final" value="{{ $fecha_final }}">
                                                    <input type="time" name="hora_inicial_{{ $modulo->id }}" required
                                                        value="{{ substr($hora_inicial, 0, 5) }}">
                                                    <input type="time" name="hora_final_{{ $modulo->id }}" required
                                                        value="{{ substr($hora_final, 0, 5) }}">
                                                </div>
                                            </h5>
                                        </div>

                                        {{-- CLASES HIJAS DEL MÓDULO --}}
                                        <div id="collapse{{ $modulo->id }}" class="collapse"
                                            aria-labelledby="heading{{ $modulo->id }}" data-parent="#accordionLecciones">
                                            <div class="card-body p-2">
                                                @if ($modulo->Clases->count() > 0)
                                                    <table class="table table-bordered table-sm mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Clase</th>
                                                                <th>Fecha Inicial</th>
                                                                <th>Fecha Final</th>
                                                                <th>Hora Inicial</th>
                                                                <th>Hora Final</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($modulo->Clases as $clase)
                                                                @if ($clase->curso_id == $curso_original->id)
                                                                    @php
                                                                        $fecha_inicial = $fecha_final = null;
                                                                        $hora_inicial = $hora_final = null;

                                                                        if ($contenido_programado) {
                                                                            $contenido = collect(
                                                                                $contenido_programado->contenido,
                                                                            )
                                                                                ->where('id', $clase->id)
                                                                                ->first();
                                                                            $fecha_inicial =
                                                                                $contenido['fecha_inicial'] ?? null;
                                                                            $fecha_final =
                                                                                $contenido['fecha_final'] ?? null;
                                                                            $hora_inicial =
                                                                                $contenido['hora_inicial'] ?? '00:00';
                                                                            $hora_final =
                                                                                $contenido['hora_final'] ?? '23:59';
                                                                        }
                                                                    @endphp
                                                                    <tr class="class" data-id="{{ $clase->id }}"
                                                                        data-parent="{{ $modulo->id }}">
                                                                        <td>{{ $clase->titulo }}
                                                                            <input type="hidden"
                                                                                name="leccion_id_{{ $clase->id }}"
                                                                                value="{{ $clase->id }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="calendar"
                                                                                name="fecha_inicial_{{ $clase->id }}"
                                                                                required value="{{ $fecha_inicial }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="calendar"
                                                                                name="fecha_final_{{ $clase->id }}"
                                                                                required value="{{ $fecha_final }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="time"
                                                                                name="hora_inicial_{{ $clase->id }}"
                                                                                required
                                                                                value="{{ substr($hora_inicial, 0, 5) }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="time"
                                                                                name="hora_final_{{ $clase->id }}"
                                                                                required
                                                                                value="{{ substr($hora_final, 0, 5) }}">
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div class="alert alert-light mb-0">
                                                        No hay clases asignadas a este módulo.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">
                            {{ __('Guardar programación') }}
                        </button>
                    </form>

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
