{{-- formulario para el index modulos --}}
@if(isset($curso))
<form method="POST" id="modulos-form"  action="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}">
    @csrf
    <input name="curso_id" type="hidden" value="{{ $curso->id}}">
    <input name="leccion_id" type="hidden" value="0">
</form>
@endif
{{-- formulario para el index clases --}}
@if(isset($modulo))
<form method="POST" id="clases-form"  action="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}">
    @csrf
    <input name="curso_id" type="hidden" value="{{ $modulo->curso_id}}">
    <input name="leccion_id" type="hidden" value="{{ $modulo->id }}">
</form>
@endif
{{-- formulario para el index pruebas --}}
@if(isset($clase))
<form method="POST" id="pruebas-form"  action="{{ route(Auth::user()->rol[0]->slug.'.pruebas.index') }}">
    @csrf
    <input name="leccion_id" type="hidden" value="{{ $clase->id }}">
</form>
<form method="POST" id="medias-form"  action="{{ route(Auth::user()->rol[0]->slug.'.medias.index') }}">
    @csrf
    <input name="leccion_id" type="hidden" value="{{ $clase->id }}">
</form>
@endif
{{-- formulario para el index preguntas --}}
@if(isset($prueba))
<form method="POST" id="preguntas-form"  action="{{ route(Auth::user()->rol[0]->slug.'.preguntas.index') }}">
    @csrf
    <input name="prueba_id" type="hidden" value="{{ $prueba->id }}">
</form>
@endif

{{-- formulario para el index respuestas --}}
@if(isset($pregunta))
<form method="POST" id="respuestas-form"  action="{{ route(Auth::user()->rol[0]->slug.'.respuestas.index') }}">
    @csrf
    <input name="pregunta_id" type="hidden" value="{{ $pregunta->id }}">
</form>
@endif

{{-- formulario para el index cursos programados --}}
@if(isset($curso_programado))
<form method="POST" id="schedule-form"  action="{{ route('schedule') }}">
    @csrf
    <input name="curso_id" type="hidden" value="{{ $curso_programado->curso_id }}">
</form>
@endif
{{-- formulario para el index descuentos --}}
@if(isset($curso_programado))
<form method="POST" id="descuento-form"  action="{{ route('descuento.index') }}">
    @csrf
    <input name="cp_id" type="hidden" value="{{ $curso_programado->id }}">
    <input name="curso_id" type="hidden" value="{{ $curso_programado->id }}">
</form>
@endif

<nav class="breadcrumb">
    @switch($route)
        @case('schedule.edit')
            <a class="breadcrumb-item active" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route('schedule') }}"
            onclick="event.preventDefault();
            document.getElementById('schedule-form').submit();">
            {{$curso->titulo}} - Programación de cursos
            </a>
            @break
        @case('schedule')
            <a class="breadcrumb-item active" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <span class="breadcrumb-item active">{{$curso->titulo}} - Programación de cursos</span>
            @break
        {{-- Descuentos --}}
        @case('descuento.index')
            <a class="breadcrumb-item active" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route('schedule') }}"
            onclick="event.preventDefault();
            document.getElementById('schedule-form').submit();">
            {{$curso_original->titulo}} - Programación de cursos
            </a>
            <span class="breadcrumb-item active">{{$curso->identificador}} - Descuento</span>
            @break
        @case('descuento.create')
            <a class="breadcrumb-item active" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route('schedule') }}"
            onclick="event.preventDefault();
            document.getElementById('schedule-form').submit();">
            {{$curso->titulo}} - Programación de cursos
            </a>
            <a class="breadcrumb-item" href="{{ route('descuento.edit') }}"
            onclick="event.preventDefault();
            document.getElementById('descuento-form').submit();">
            {{$curso_programado->identificador}} - Descuento
            </a>
            @break
        @case('descuento.edit')
            <a class="breadcrumb-item active" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route('schedule') }}"
            onclick="event.preventDefault();
            document.getElementById('schedule-form').submit();">
            {{$curso->titulo}} - Programación de cursos
            </a>
            <a class="breadcrumb-item" href="{{ route('descuento.edit') }}"
            onclick="event.preventDefault();
            document.getElementById('descuento-form').submit();">
            {{$curso_programado->identificador}} - Descuento
            </a>
            @break
        @case('contenido.index')
            <a class="breadcrumb-item active" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route('schedule') }}"
            onclick="event.preventDefault();
            document.getElementById('schedule-form').submit();">
            {{$curso_original->titulo}} - Programación de cursos
            </a>
            <span class="breadcrumb-item active">{{$curso->identificador}} - Programar contenido del curso</span>
            @break
        {{-- Lecciones --}}
        @case('lecciones.index')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            @if($leccion_id == 0)
            <span class="breadcrumb-item active">{{$curso->titulo}} - Módulos</span>
            @else
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            <span class="breadcrumb-item active">{{$modulo->titulo}} - Clases</span>
            @endif
            @break
        @case('lecciones.create')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if(isset($modulo))
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
            @endif
            @break
        @case('lecciones.edit')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if(isset($modulo) == false)
            <span class="breadcrumb-item active">{{$clase->titulo}} - Editar</span>
            @else
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <span class="breadcrumb-item active">{{$clase->titulo}} - Editar</span>
            @endif
            @break
        {{-- Pruebas --}}
        @case('pruebas.index')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if(isset($modulo) == false)
            <span class="breadcrumb-item active">{{$clase->titulo}} - Pruebas</span>
            @else
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <span class="breadcrumb-item active">{{$clase->titulo}} - Pruebas</span>
            @endif
            @break
        @case('pruebas.create')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if(isset($modulo) == false)
            <span class="breadcrumb-item active">{{$clase->titulo}} - Pruebas</span>
            @else
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('clases-form').submit();">
            {{$modulo->titulo}} - Clases
            </a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('pruebas-form').submit();">
            {{$clase->titulo}} - Pruebas
            </a>
            @endif
            @break
        @case('pruebas.edit')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if(isset($modulo) == false)
            <span class="breadcrumb-item active">{{$clase->titulo}} - Pruebas</span>
            @else
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('clases-form').submit();">
            {{$modulo->titulo}} - Clases
            </a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('pruebas-form').submit();">
            {{$clase->titulo}} - Pruebas
            </a>
            @endif
            @break
        {{-- Medias --}}
        @case('medias.index')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('clases-form').submit();">
            {{$modulo->titulo}} - Clases
            </a>
            <span class="breadcrumb-item active">{{$clase->titulo}} - Multimedias</span>
            @break
        @case('medias.create')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('clases-form').submit();">
            {{$modulo->titulo}} - Clases
            </a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('medias-form').submit();">
            {{$clase->titulo}} - Multimedias</a>
            @break
        @case('medias.edit')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('clases-form').submit();">
            {{$modulo->titulo}} - Clases
            </a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('medias-form').submit();">
            {{$clase->titulo}} - Multimedias</a>
            @break
        {{-- Preguntas --}}
        @case('preguntas.index')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if($leccion->leccion_id == 0)
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
            @else
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <span class="breadcrumb-item active">{{$prueba->titulo}} - Preguntas</span>
            @endif
            @break
        @case('preguntas.create')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if($leccion->leccion_id == 0)
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
            @else
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.preguntas.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{ $prueba->titulo }} - Preguntas
                </a>
            @endif
            @break
        @case('preguntas.edit')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            @if($leccion->leccion_id == 0)
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
            @else
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.preguntas.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{ $prueba->titulo }} - Preguntas
                </a>
            @endif
            @break
        {{-- Respuestas --}}
        @case('respuestas.index')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if($leccion->leccion_id == 0)
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
            @else
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
                <span class="breadcrumb-item active">{!!$pregunta->pregunta!!} - Respuestas</span>
            @endif
            @break
        @case('respuestas.create')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if($leccion->leccion_id == 0)
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.respuestas.index') }}"
                onclick="event.preventDefault();
                document.getElementById('respuestas-form').submit();">
                {!!$pregunta->pregunta!!} - Respuestas
                </a>
            @else
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.respuestas.index') }}"
                onclick="event.preventDefault();
                document.getElementById('respuestas-form').submit();">
                {!!$pregunta->pregunta!!} - Respuestas
                </a>
            @endif
            @break
        @case('respuestas.edit')
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
            <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
            onclick="event.preventDefault();
            document.getElementById('modulos-form').submit();">
            {{$curso->titulo}} - Módulos
            </a>
            @if($leccion->leccion_id == 0)
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.respuestas.index') }}"
                onclick="event.preventDefault();
                document.getElementById('respuestas-form').submit();">
                {!!$pregunta->pregunta!!} - Respuestas
                </a>
            @else
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('clases-form').submit();">
                {{$modulo->titulo}} - Clases
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('pruebas-form').submit();">
                {{$clase->titulo}} - Pruebas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
                onclick="event.preventDefault();
                document.getElementById('preguntas-form').submit();">
                {{$prueba->titulo}} - Preguntas
                </a>
                <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.respuestas.index') }}"
                onclick="event.preventDefault();
                document.getElementById('respuestas-form').submit();">
                {!!$pregunta->pregunta!!} - Respuestas
                </a>
            @endif
            @break
        @default

    @endswitch

  </nav>
