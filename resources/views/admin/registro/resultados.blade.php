@extends('layouts.adminmart.detalle')

@section('content')
{{-- {{ $inscripcion->User }} --}}

{{-- boton para exportar a pdf --}}
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.exportCalificaciones', $inscripcion->id) }}" class="btn btn-primary">
        Exportar a PDF
    </a>
</div>
<table class="table table-striped table-xl text-center" id="dataTable">
    <thead class="thead-light">
        <tr>
            <th>Examen</th>
            <th>Tipo</th>
            <th>Total Preguntas</th>
            <th>Correctas</th>
            <th>Puntaje final</th>
            <th>¿Finalizado?</th>
            <th>¿Retroalimentación?</th>
            <th>Reiniciar</th>
            <th>Teclas Presionadas</th>
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
        <tr style="
                                @if($examen->score_total < 1200)
                                    background-color: #FFCCCC; color: #a94442;
                                @elseif($examen->score_total >= 1200)
                                    background-color: #D4EDDA; color: #155724;
                                @endif
                            ">
            <td>{{ $examen->Prueba->titulo }}</td>
            <td>{{ $examen->Prueba->tipo }}</td>
            <td>{{ $examen->total_preguntas }}</td>
            <td>{{ $examen->total_correctas }}</td>
            <td>{{ $examen->score_total }}</td>
            <td>
                {{-- Botón para cambiar estado Finalizado --}}
                <button id="finalizar-{{ $examen->id }}"
                    class="btn btn-{{ $examen->finalizado == 'si' ? 'success' : 'danger' }}"
                    data-id="{{ $examen->id }}">
                    {{ $examen->finalizado == 'si' ? 'Reanudar' : 'Finalizar' }}
                </button>
            </td>
            <td>
                {{-- Botón para cambiar estado Retroalimentación --}}
                <button id="retro-{{ $examen->id }}"
                    class="btn btn-{{ $examen->retro_visualizado == 'si' ? 'success' : 'danger' }}"
                    data-id="{{ $examen->id }}">
                    {{ $examen->retro_visualizado == 'si' ? 'Reanudar' : 'Finalizar' }}
                </button>
            </td>
            <td>
                {{-- Botón para Reiniciar Examen --}}
                <button id="reiniciar-{{ $examen->id }}" class="btn btn-danger" data-id="{{ $examen->id }}">
                    Reiniciar
                </button>
            </td>
            <td>
                @php
                // Agrupar los eventos por observacion y guardar las fechas
                $teclasAgrupadas = collect($examen->eventos ?? [])
                ->groupBy('observacion')
                ->map(function ($items) {
                return [
                'count' => $items->count(),
                'fechas' => $items->pluck('fecha_hora')->implode("\n -"),
                ];
                });
                @endphp

                <div class="d-flex flex-wrap align-items-center">
                    @foreach ($teclasAgrupadas as $tecla => $data)
                    <span class="badge badge-secondary mr-1" data-toggle="tooltip" data-placement="top"
                        title="{{ $data['fechas'] }}">
                        {{ $tecla }} ({{ $data['count'] }})
                    </span>
                    @if (!$loop->last)
                    <span class="mx-1">-</span>
                    @endif
                    @endforeach

                    @if ($teclasAgrupadas->isEmpty())
                    <span class="text-muted">—</span>
                    @endif
                </div>
            </td>

            @section('javascript')
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip({
                        html: true, // permite saltos de línea en el tooltip
                    })
                });
            </script>
            @endsection

        </tr>
        @else
        <tr style="background-color: #FFFF8A; color: #948503;">
            {{--
        <tr class="bg-danger text-white"> --}}
            <td>{{ $prueba->titulo }}</td>
            <td>{{ $prueba->tipo }}</td>
            <td colspan="7">No Presentado</td>
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
            <th>Finalizado</th>
            <th>Retroalimentación</th>
            <th>Reiniciar</th>
            <th>Teclas Presionadas</th>
        </tr>
    </tfoot>
</table>
@endsection

@section('javascript')
<script>
    $(".modal-title").html("Resultados del curso");
</script>
@endsection