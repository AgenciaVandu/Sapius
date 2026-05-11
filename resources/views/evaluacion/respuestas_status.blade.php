@php
    $respuestas = is_array($respuestas_json) ? $respuestas_json : [];
    // Optimización: Crear un set (array con llaves) de IDs respondidos para búsqueda O(1)
    $respondidasSet = [];
    foreach ($respuestas as $r) {
        if (isset($r->name)) {
            $respondidasSet[(string) $r->name] = true;
        } elseif (isset($r['name'])) {
            $respondidasSet[(string) $r['name']] = true;
        }
    }
    
    $contadorGlobal = 1; // contador global para numeración
    $currentPage = request()->get('page', 1); // página actual
@endphp

@if ($preguntasAll->count() > 0)
    @foreach ($preguntasAll as $index => $grupo)
        @php
            $preguntasDelGrupo = $grupo->GrupoPreguntas ?? collect();
            $esAgrupado = $preguntasDelGrupo->count() > 1;

            // Determinar si se pinta el recuadro exterior
            if ($esAgrupado) {
                $todasRespondidas = $preguntasDelGrupo->pluck('id')->every(function ($id) use ($respondidasSet) {
                    return isset($respondidasSet[(string) $id]);
                });
                $colorExterior = $todasRespondidas ? '#002146' : '#e0e0e0';
            } else {
                $tieneRespuesta = isset($respondidasSet[(string) ($preguntasDelGrupo->first()->id ?? '')]);
                $colorExterior = $tieneRespuesta ? '#002146' : '#e0e0e0';
            }

            $colorTextoExterior =
                ($esAgrupado && isset($todasRespondidas) && $todasRespondidas) || (!$esAgrupado && $tieneRespuesta)
                    ? 'white'
                    : '#b0b0b0';
            $anchoMin = $esAgrupado ? 40 * $preguntasDelGrupo->count() : 32;

            // Estilo de borde para página actual
            $bordeActual = $currentPage == $index + 1 ? '2px solid #ed6a5a' : 'none';
        @endphp

        {{-- Recuadro exterior con borde para resaltar página actual --}}
        <div class="recuadro-paginacion mb-2 d-inline-block p-2" data-page="{{ $index + 1 }}"
            style="min-width: {{ $anchoMin }}px;
                   border-radius:6px;
                   border: {{ $bordeActual }};
                   background-color: {{ $colorExterior }};
                   color: {{ $colorTextoExterior }};
                   text-align:center; font-weight:bold; cursor:pointer;">

            {{-- Mini-cuadritos internos --}}
            @foreach ($preguntasDelGrupo as $subIndex => $item)
                @php
                    $tieneRespuesta = isset($respondidasSet[(string) $item->id]);
                    $colorFondo = $tieneRespuesta ? '#002146' : '#e0e0e0';
                    $colorTexto = $tieneRespuesta ? 'white' : '#b0b0b0';

                    // Numeración: grupos tipo 25.1, 25.2
                    $numero = $esAgrupado ? $contadorGlobal . '.' . ($subIndex + 1) : $contadorGlobal;
                @endphp

                <span
                    style="display:inline-block; width:32px; height:32px; margin:2px;
                           border-radius:4px; background-color:{{ $colorFondo }};
                           color:{{ $colorTexto }}; line-height:32px; font-size:12px;">
                    {{ $numero }}
                </span>
            @endforeach
        </div>

        @php $contadorGlobal++; @endphp
    @endforeach
@else
    <p>No hay respuestas o el JSON es inválido.</p>
@endif
