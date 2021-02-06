<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/'.Auth::user()->rol[0]->slug) }}"
                    aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                        class="hide-menu">Bienvenido</span></a></li>

                <li class="list-divider"></li>

                @if(Auth::user()->hasRole('admin'))
                    <!-- Adminisración de usuarios-->
                    <li class="nav-small-cap"><span class="hide-menu">Usuarios</span></li>

                    <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('users.index') }}"
                            aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span
                                class="hide-menu">Lista
                            </span></a>
                    </li>

                    <li class="list-divider"></li>
                    <!-- Adminisración de Cursos-->
                    <li class="nav-small-cap"><span class="hide-menu">Cursos</span></li>

                    <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('admin.cursos.index') }}"
                            aria-expanded="false"><i data-feather="list" class="feather-icon"></i><span
                                class="hide-menu">Lista
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link" href="{{ URL::route('cursos.create') }}"
                            aria-expanded="false"><i data-feather="plus" class="feather-icon"></i><span
                                class="hide-menu">Agregar</span></a></li>
                @else
                @if(Auth::user()->hasRole('alumno'))
                    <li class="nav-small-cap"><span class="hide-menu">Opciones</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('alumno.calendario') }}" aria-expanded="false">
                            <i data-feather="calendar" class="feather-icon"></i>
                            <span class="hide-menu">Mi Calendario</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('cursos.disponibles') }}" aria-expanded="false">
                            <i data-feather="flag" class="feather-icon"></i>
                            <span class="hide-menu">Cursos</span>
                        </a>
                    </li>

                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link" href="#" aria-expanded="false">
                            <i data-feather="file" class="feather-icon"></i>
                            <span class="hide-menu">Exámenes</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#" aria-expanded="false">
                            <i data-feather="credit-card" class="feather-icon"></i>
                            <span class="hide-menu">Pagos</span>
                        </a>
                    </li> --}}

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('alumno.soporte') }}" aria-expanded="false">
                            <i data-feather="info" class="feather-icon"></i>
                            <span class="hide-menu">Soporte Técnico</span>
                        </a>
                    </li>
                @else
                @if(Auth::user()->hasRole('instructor'))
                    <li class="nav-small-cap"><span class="hide-menu">Cursos</span></li>

                    <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('instructor.cursos.index') }}"
                            aria-expanded="false"><i data-feather="list" class="feather-icon"></i><span
                                class="hide-menu">Lista
                            </span></a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('instructor.soporte') }}" aria-expanded="false">
                            <i data-feather="info" class="feather-icon"></i>
                            <span class="hide-menu">Soporte Técnico</span>
                        </a>
                    </li>
                @endif
                @endif
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
