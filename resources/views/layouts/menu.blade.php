@if(Auth::user()->hasRole('admin'))
<a class="dropdown-item" href="{{ route('users.index') }}">
    {{ __('Users') }}
</a>
<a class="dropdown-item" href="{{ route('cursos.index') }}">
    {{ __('Cursos') }}
</a>
@else
@if(Auth::user()->hasRole('alumno'))

@else
@if(Auth::user()->hasRole('instructor'))

@endif
@endif
@endif

<a class="dropdown-item" href="{{ route('logout') }}"
   onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
