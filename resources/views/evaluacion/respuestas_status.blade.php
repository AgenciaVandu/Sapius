@php
    // Asegúrate de que $respuestas_json y $preguntasAll estén disponibles
    $respuestas = is_array($respuestas_json) ? $respuestas_json : [];
@endphp

@if (is_array($respuestas) && count($preguntasAll) > 0)
    @foreach ($preguntasAll as $item)
        @php
            $found = false;
            foreach ($respuestas as $respuesta) {
                if ($respuesta['name'] == $item->id) {
                    $found = true;
                    break;
                }
            }
        @endphp
        <div class="mb-2"
            style="display: inline-block; width: 32px; height: 32px; margin-right: 5px; border-radius: 4px; background-color: {{ $found ? '#28a745' : '#dc3545' }}; color: white; text-align: center; line-height: 32px; font-weight: bold;">
            {{ $loop->iteration }}
        </div>
    @endforeach
@else
    <p>No hay respuestas o el JSON es inválido.</p>
@endif
