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
                <th>¿Finalizado?</th>
                <th>¿Retroalimentación?</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($examenes as $e)
                <tr>
                    <td>{{ $e->Prueba->titulo }}</td>
                    <td>{{ $e->Prueba->tipo }}</td>
                    <td>{{ $e->total_preguntas }}</td>
                    <td>{{ $e->total_correctas }}</td>
                    <td>{{ $e->score_total }}</td>
                    <td>
                        {{-- Botón para cambiar estado Finalizado --}}
                        <button id="finalizar-{{ $e->id }}"
                            class="btn btn-{{ $e->finalizado == 'si' ? 'success' : 'danger' }}" data-id="{{ $e->id }}">
                            {{ $e->finalizado == 'si' ? 'Reanudar' : 'Finalizar' }}
                        </button>
                    </td>
                    <td>
                        {{-- Botón para cambiar estado Retroalimentación --}}
                        <button id="retro-{{ $e->id }}"
                            class="btn btn-{{ $e->retro_visualizado == 'si' ? 'success' : 'danger' }}"
                            data-id="{{ $e->id }}">
                            {{ $e->retro_visualizado == 'si' ? 'Reanudar' : 'Finalizar' }}
                        </button>
                    </td>
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
                <th>Finalizado</th>
                <th>Retroalimentación</th>
            </tr>
        </tfoot>
    </table>
@endsection

@section('javascript')
    <script>
        $(".modal-title").html("Resultados del curso");
    </script>

@endsection
