@extends('layouts.adminmart.detalle')

@section('content')
{{-- boton para exportar a pdf --}}
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.exportCalificaciones', $inscripcion->id) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-file-pdf"></i> Exportar a PDF
    </a>
</div>

<div class="table-responsive" style="overflow-x: auto; width: 100%;">
    <table class="table table-striped table-bordered table-sm text-center align-middle" id="dataTable" style="min-width: 950px;">
        <thead class="thead-light">
            <tr>
                <th style="min-width: 160px;">Examen</th>
                <th style="min-width: 100px;">Tipo</th>
                <th style="min-width: 110px;">Total Preguntas</th>
                <th style="min-width: 90px;">Correctas</th>
                <th style="min-width: 110px;">Puntaje final</th>
                <th style="min-width: 110px;">¿Finalizado?</th>
                <th style="min-width: 140px;">¿Retroalimentación?</th>
                <th style="min-width: 100px;">Reiniciar</th>
                <th style="min-width: 180px;">Teclas Presionadas</th>
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
                                <td class="font-weight-bold text-left px-2">{{ $examen->Prueba->titulo }}</td>
                                <td>{{ $examen->Prueba->tipo }}</td>
                                <td>{{ $examen->total_preguntas }}</td>
                                <td>{{ $examen->total_correctas }}</td>
                                <td><strong>{{ $examen->score_total }}</strong></td>
                                <td>
                                    {{-- Botón para cambiar estado Finalizado --}}
                                    <button id="finalizar-{{ $examen->id }}"
                                        class="btn btn-sm btn-{{ $examen->finalizado == 'si' ? 'success' : 'danger' }}"
                                        data-id="{{ $examen->id }}">
                                        {{ $examen->finalizado == 'si' ? 'Reanudar' : 'Finalizar' }}
                                    </button>
                                </td>
                                <td>
                                    {{-- Botón para cambiar estado Retroalimentación --}}
                                    <button id="retro-{{ $examen->id }}"
                                        class="btn btn-sm btn-{{ $examen->retro_visualizado == 'si' ? 'success' : 'danger' }}"
                                        data-id="{{ $examen->id }}">
                                        {{ $examen->retro_visualizado == 'si' ? 'Reanudar' : 'Finalizar' }}
                                    </button>
                                </td>
                                <td>
                                    {{-- Botón para Reiniciar Examen --}}
                                    <button id="reiniciar-{{ $examen->id }}" class="btn btn-sm btn-danger" data-id="{{ $examen->id }}">
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

                                    <div class="d-flex flex-wrap align-items-center justify-content-center" style="max-width: 220px; margin: 0 auto;">
                                        @foreach ($teclasAgrupadas as $tecla => $data)
                                            <span class="badge badge-secondary m-1" data-toggle="tooltip" data-placement="top"
                                                title="{{ $data['fechas'] }}">
                                                {{ $tecla }} ({{ $data['count'] }})
                                            </span>
                                        @endforeach

                                        @if ($teclasAgrupadas->isEmpty())
                                            <span class="text-muted">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr style="background-color: #FFFF8A; color: #948503;">
                                <td class="font-weight-bold text-left px-2">{{ $prueba->titulo }}</td>
                                <td>{{ $prueba->tipo }}</td>
                                <td colspan="7" class="text-center font-weight-bold">No Presentado</td>
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
</div>
@endsection

@section('javascript')
<script>
    $(".modal-title").html("Resultados del curso");
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            html: true,
        });
    });
</script>
@endsection