@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{-- {{ $curso_programado->Curso->titulo }} --}}
                </h3>
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
    <div>
        <table class="table table-striped table-md text-center" id="dataTable" style="table-layout: fixed; width: 100%;">
            <thead class="thead-light">
                <tr>
                    <th style="width:50%;">Examen</th>
                    <th style="width:25%;">Tipo</th>
                    <th style="width:25%;">Total Preguntas</th>
                    <th style="width:25%;">Correctas</th>
                    <th style="width:25%;">Puntaje final</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($lecciones as $leccion)
                    @foreach ($leccion->pruebas as $prueba)
                        @if ($prueba->activo === 'si')
                            @php
                                $examen = $examenes->firstWhere('prueba_id', $prueba->id);
                            @endphp
                            @if ($examen)
                                <tr
                                    style="
                                @if ($examen->score_total < 1200) background-color: #FFCCCC; color: #a94442;
                                @elseif($examen->score_total >= 1200)
                                    background-color: #D4EDDA; color: #155724; @endif
                            ">
                                    <td>{{ $examen->Prueba->titulo }}</td>
                                    <td>{{ $examen->Prueba->tipo }}</td>
                                    <td>{{ $examen->total_preguntas }}</td>
                                    <td>{{ $examen->total_correctas }}</td>
                                    <td>{{ $examen->score_total }}</td>
                                </tr>
                            @else
                                <tr style="background-color: #FFFF8A; color: #948503;">
                                    <td>{{ $prueba->titulo }}</td>
                                    <td>{{ $prueba->tipo }}</td>
                                    <td colspan="3">No Presentado</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @endforeach

            </tbody>

            <tfoot class="thead-light">
                <tr>
                    <th>Examen</th>
                    <th>Tipo</th>
                    <th>Total Preguntas</th>
                    <th>Correctas</th>
                    <th>Puntaje final</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/funciones.js') }}"></script>
@endsection
