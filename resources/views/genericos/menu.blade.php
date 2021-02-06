{{-- formulario para el link lecciones --}}
@if(isset($leccion))
<form method="POST" id="lecciones-form"  action="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}">
    @csrf
    <input name="curso_id" type="hidden" value="{{ $curso->id }}">
</form>
@endif
{{-- formulario para el link pruebas --}}
@if(isset($prueba))
<form method="POST" id="pruebas-form"  action="{{ route(Auth::user()->rol[0]->slug.'.pruebas.index') }}">
    @csrf
    <input name="leccion_id" type="hidden" value="{{ $leccion->id }}">
</form>
@endif
{{-- formulario para el link preguntas --}}
@if(isset($pregunta))
<form method="POST" id="preguntas-form"  action="{{ route(Auth::user()->rol[0]->slug.'.preguntas.index') }}">
    @csrf
    <input name="prueba_id" type="hidden" value="{{ $prueba->id }}">
</form>
@endif

<nav class="breadcrumb">
    {{-- 0 --}}
    @if(!isset($curso))
    <a class="breadcrumb-item active" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
    @endif

    {{-- 1 --}}
    @if(isset($curso) and !isset($leccion))
    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>
        @if(!isset($edit))
        <span class="breadcrumb-item active">{{$curso->titulo}} - Clases</span>
        @endif
    @endif

    {{-- 2 --}}
    @if(isset($curso) and isset($leccion) and !isset($prueba))
    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>

    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
    onclick="event.preventDefault();
    document.getElementById('lecciones-form').submit();">
    {{$curso->titulo}} - Clases
    </a>
        @if(!isset($edit))
        <span class="breadcrumb-item active">{{ $leccion->titulo }} - @if(isset($viewMultimedia)) Multimedia @else Pruebas @endif</span>
        @endif
    @endif

    {{-- 3 --}}
    @if(isset($curso) and isset($leccion) and isset($prueba) and !isset($pregunta))
    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>

    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
    onclick="event.preventDefault();
    document.getElementById('lecciones-form').submit();">
    {{$curso->titulo}} - Clases
    </a>

    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.pruebas.index') }}"
    onclick="event.preventDefault();
    document.getElementById('pruebas-form').submit();">
    {{ $leccion->titulo }} - Pruebas
    </a>
        @if(!isset($edit))
        <span class="breadcrumb-item active">{{ $prueba->titulo }} - Preguntas</span>
        @endif

    @endif
    {{-- 4 --}}
    @if(isset($curso) and isset($leccion) and isset($prueba) and isset($pregunta) and !isset($respuesta))
    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.cursos.index') }}">Cursos</a>

    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.lecciones.index') }}"
    onclick="event.preventDefault();
    document.getElementById('lecciones-form').submit();">
    {{$curso->titulo}} - Clases
    </a>

    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.pruebas.index') }}"
    onclick="event.preventDefault();
    document.getElementById('pruebas-form').submit();">
    {{ $leccion->titulo }} - Pruebas
    </a>

    <a class="breadcrumb-item" href="{{ route(Auth::user()->rol[0]->slug.'.preguntas.index') }}"
    onclick="event.preventDefault();
    document.getElementById('preguntas-form').submit();">
    {{ $prueba->titulo }} - Preguntas
    </a>

        @if(!isset($edit))
        <span id="spanRespuesta" class="breadcrumb-item active">{{ $pregunta->pregunta }} - Respuestas</span>

        @endif
    @endif

  </nav>
