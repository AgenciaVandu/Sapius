@extends('layouts.adminmart.detalle')

@section('content')
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
                <th>Teclas Presionadas</th>
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
                    <td>
                        @php
                            // Agrupar los eventos por observacion y guardar las fechas
                            $teclasAgrupadas = collect($e->eventos ?? [])
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
                            $(function() {
                                $('[data-toggle="tooltip"]').tooltip({
                                    html: true, // permite saltos de línea en el tooltip
                                })
                            });
                        </script>
                    @endsection

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
