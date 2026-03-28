@component('mail::message')
# Hola {{ $student->nombre }},

Hemos notado que te has atrasado en el contenido de tu curso. Es importante que mantengas tu ritmo de estudio para completar tu formación con éxito.

Aquí tienes una lista de las lecciones que deberías haber completado:

<div style="overflow-x: auto;">
<table style="width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 20px; font-size: 15px;">
    <thead>
        <tr>
            <th style="border-bottom: 2px solid #edeff2; padding: 8px 5px; width: 60%;">Módulo y Lección</th>
            <th style="border-bottom: 2px solid #edeff2; padding: 8px 5px; width: 20%; white-space: nowrap;">Fecha Límite</th>
            <th style="border-bottom: 2px solid #edeff2; padding: 8px 5px; width: 20%; white-space: nowrap;">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($overdueLessons as $lesson)
        <tr>
            <td style="border-bottom: 1px solid #edeff2; padding: 10px 5px;">
                <strong>{{ $lesson['modulo'] }}</strong><br>
                <span style="color:#74787e;">{{ $lesson['titulo'] }}</span>
            </td>
            <td style="border-bottom: 1px solid #edeff2; padding: 10px 5px; color:#74787e; white-space: nowrap;">
                {{ $lesson['fecha_final'] }}
            </td>
            <td style="border-bottom: 1px solid #edeff2; padding: 10px 5px; white-space: nowrap;">
                @if($lesson['is_expired'] ?? false)
                    <span style="color:red"><strong>[Cerrada]</strong></span>
                @else
                    <span style="color:#e6a23c"><strong>[Atrasada]</strong></span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

Te animamos a retomar tus clases lo antes posible.

@component('mail::button', ['url' => route('alumno.home')])
Ir a mis cursos
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
