@component('mail::message')
# Hola {{ $student->nombre }},

Hemos notado que te has atrasado en el contenido de tu curso. Es importante que mantengas tu ritmo de estudio para completar tu formación con éxito.

Aquí tienes una lista de las lecciones que deberías haber completado:

@component('mail::table')
| Lección       | Fecha Límite   |
|:------------- |:-------------:|
@foreach ($overdueLessons as $lesson)
| {{ $lesson['titulo'] }} | {{ $lesson['fecha_final'] }} |
@endforeach
@endcomponent

Te animamos a retomar tus clases lo antes posible.

@component('mail::button', ['url' => route('alumno.home')])
Ir a mis cursos
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
