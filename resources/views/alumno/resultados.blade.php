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
@foreach ($lecciones as $leccion)
    @foreach ($leccion->pruebas as $pruebas)
        Examen ID: {{ $pruebas->id }}
       <br> {{ $pruebas->titulo }}
    @endforeach
    <br>------- <br>
@endforeach
    <div>
        <table class="table table-striped table-xl text-center" id="dataTable">
            <thead class="thead-light">
                <tr>
                    <th>Examen</th>
                    <th>Tipo</th>
                    <th>Total Preguntas</th>
                    <th>Correctas</th>
                    <th>Puntaje final</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($examenes as $e)
                    <tr>
                        <td>{{ $e->prueba_id }}{{ $e->Prueba->titulo }}</td>
                        <td>{{ $e->Prueba->tipo }}</td>
                        <td>{{ $e->total_preguntas }}</td>
                        <td>{{ $e->total_correctas }}</td>
                        <td>{{ $e->score_total }}</td>
                    </tr>
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
