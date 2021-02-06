@component('emails.message')
#  Has finalizado la prueba con el siguiente puntaje:

@component('mail::table')
| total preguntas       | Respuestas correctas    | Puntaje final  |
| :-------------------: |:-----------------------:| :-------------:|
| {{ $examen->total_preguntas}}      | {{ $examen->total_correctas}}      | {{ $examen->score_total}}     |
@endcomponent

@endcomponent
