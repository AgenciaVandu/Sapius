@extends('layouts.adminmart.detalle')

@section('content')
    <table class="table table-striped table-sm" id="dataTable">
        <thead class="thead-light">
            <tr>
                <th>Examen</th>
                <th>Tipo</th>
                <th>Total Preguntas</th>
                <th>Correctas</th>
                <th>Puntaje final</th>
            </tr>
        </thead>
        <body>
            @foreach ($examenes as $e)
            <tr>
                <td>{{ $e->Prueba->titulo}}</td>
                <td>{{ $e->Prueba->tipo}}</td>
                <td>{{ $e->total_preguntas }}</td>
                <td>{{ $e->total_correctas }}</td>
                <td>{{ $e->score_total }}</td>
            </tr>
            @endforeach
        </body>
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
@endsection

@section('javascript')
   <script>
        $(document).ready( function () {
            $(".modal-title").html("Resultados del curso");
        });
    </script>
@endsection
