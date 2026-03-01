<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <!-- Logo icon -->
                <a href="{{ url('/' . Auth::user()->rol[0]->slug) }}">
                    {{-- <b class="logo-icon">
                        <!-- Dark Logo icon -->
                        <img src="{{ asset('vendor/adminmart/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                        <!-- Light Logo icon -->
                        <img src="{{ asset('vendor/adminmart/assets/images/logo-icon.png') }}" alt="homepage" class="light-logo" />
                    </b> --}}
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                        <!-- dark Logo text -->
                        <img src="{{ asset('vendor/adminmart/assets/images/200x80.png') }}" alt="homepage"
                            class="dark-logo" />
                        <!-- Light Logo text -->
                        <img src="{{ asset('vendor/adminmart/assets/images/logo-light-text.png') }}" class="light-logo"
                            alt="homepage" />
                    </span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                @hasSection('timer')
                    @yield('timer')
                @else
                    @if (isset($globalActiveExam) && $globalActiveExam)
                        @php
                            $str_time = $globalActiveExam->Prueba->tiempo;
                            sscanf($str_time, '%d:%d:%d', $hours, $minutes, $seconds);
                            $duration_seconds = isset($hours)
                                ? $hours * 3600 + $minutes * 60 + $seconds
                                : $minutes * 60 + $seconds;
                            // Ensure created_at is parsed correctly (sometimes it's a string)
                            $start_time = \Carbon\Carbon::parse($globalActiveExam->created_at);
                            $now = \Carbon\Carbon::now();
                            // Use abs to avoid negative iff clock skew, but typically diffInSeconds is absolute.
                            // method diffInSeconds(date, absolute=true) default is true.
                            // We want direction. if now > start, fine.
                            $elapsed_seconds = $start_time->diffInSeconds($now);

                            $remaining_seconds = $duration_seconds - $elapsed_seconds;
                        @endphp

                        @if ($remaining_seconds > 0)
                            <li class="nav-item d-none d-md-block" id="global-exam-timer-li">
                                <form id="global-exam-form" action="{{ route('examen.presentar') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    <input type="hidden" name="prueba_id" value="{{ $globalActiveExam->prueba_id }}">
                                    <input type="hidden" name="inscripcion_id"
                                        value="{{ $globalActiveExam->inscripcion_id }}">
                                </form>
                                <a class="nav-link" href="javascript:void(0)"
                                    onclick="document.getElementById('global-exam-form').submit();"
                                    style="background-color: #ffefef; border: 1px solid #ffcccc; border-radius: 50px; padding: 8px 20px; margin-top: 12px; line-height: 1.2;">
                                    <span class="text-danger font-weight-bold" style="font-size: 0.9rem;">
                                        <i data-feather="clock" class="svg-icon mr-1"
                                            style="height: 16px; width: 16px;"></i>
                                        <span
                                            class="d-none d-lg-inline">{{ \Illuminate\Support\Str::limit($globalActiveExam->Prueba->titulo, 15) }}:</span>
                                        <span id="global-timer-countdown"
                                            style="font-family: monospace; font-size: 1rem;"></span>
                                    </span>
                                </a>
                                <input type="hidden" id="global_remaining_seconds" value="{{ $remaining_seconds }}">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        let seconds = parseInt(document.getElementById('global_remaining_seconds').value);
                                        const timerElement = document.getElementById('global-timer-countdown');
                                        const liElement = document.getElementById('global-exam-timer-li');

                                        function updateTimer() {
                                            if (seconds <= 0) {
                                                liElement.style.display = 'none';
                                                return;
                                            }

                                            let hrs = Math.floor(seconds / 3600);
                                            let mins = Math.floor((seconds % 3600) / 60);
                                            let secs = seconds % 60;

                                            let display = "";
                                            if (hrs > 0) display += (hrs < 10 ? "0" : "") + hrs + ":";
                                            display += (mins < 10 ? "0" : "") + mins + ":";
                                            display += (secs < 10 ? "0" : "") + secs;

                                            timerElement.innerText = display;
                                            seconds--;
                                        }

                                        setInterval(updateTimer, 1000);
                                        updateTimer();
                                    });
                                </script>
                            </li>
                        @endif
                    @endif
                @endif
                <!-- Notification -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                        id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="badge badge-primary notify-no rounded-circle">{{ Auth::user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown" style="min-width: 350px;">
                        <ul class="list-style-none">
                            <li>
                                <div class="message-center notifications position-relative" style="max-height: 300px; overflow-y: auto;">
                                    @forelse(Auth::user()->unreadNotifications as $notification)
                                    <!-- Message -->
                                    <a href="javascript:void(0)" id="notif-item-{{ $notification->id }}"
                                        class="message-item d-flex align-items-center border-bottom px-3 py-2 position-relative">
                                        <div class="btn btn-warning rounded-circle btn-circle"><i
                                                data-feather="alert-circle" class="text-white"></i></div>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h6 class="message-title mb-0 mt-1">{{ \Illuminate\Support\Str::limit($notification->data['titulo'], 30) }}</h6>
                                            <span class="font-12 text-nowrap d-block text-muted">{{ \Illuminate\Support\Str::limit($notification->data['modulo'] ?? '', 30) }}</span>
                                            <span class="font-12 text-nowrap d-block text-muted">Vence: {{ $notification->data['fecha_final'] ?? '' }}</span>
                                            
                                            @php
                                                $actionUrl = route('alumno.home');
                                            @endphp

                                            <div class="mt-1 d-flex">
                                                <button class="btn btn-xs btn-primary mr-2" onclick="event.stopPropagation(); markAsRead('{{ $notification->id }}', '{{ $actionUrl }}')">Ir al Curso</button>
                                                
                                                <button class="btn btn-xs btn-outline-danger" onclick="event.stopPropagation(); deleteNotification('{{ $notification->id }}')" title="Eliminar alerta">
                                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                    @empty
                                    <div class="p-3 text-center">No tienes notificaciones nuevas.</div>
                                    @endforelse
                                </div>
                            </li>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                            <li>
                                <a class="nav-link pt-3 text-center text-danger" href="javascript:void(0);" onclick="deleteAllNotifications()">
                                    <strong>Eliminar todas</strong>
                                    <i class="fa fa-trash"></i>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <!-- End Notification -->
                <script>
                    function markAsRead(id, redirectUrl) {
                         fetch('/alumno/notifications/mark-as-read/' + id, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    window.location.href = redirectUrl;
                                } else {
                                    // Fallback just in case
                                    window.location.href = redirectUrl;
                                }
                            });
                    }

                    function deleteNotification(id) {
                        fetch('/alumno/notifications/delete/' + id, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    document.getElementById('notif-item-' + id).remove();
                                    let badge = document.querySelector('.notify-no');
                                    if(badge) {
                                        let currentCount = parseInt(badge.innerText);
                                        if(currentCount > 1) {
                                            badge.innerText = currentCount - 1;
                                        } else {
                                            badge.remove();
                                            document.querySelector('.message-center.notifications').innerHTML = '<div class="p-3 text-center">No tienes notificaciones nuevas.</div>';
                                            // Remover boton eliminar todas
                                            let clearAllBtn = document.querySelector('.text-danger[onclick^="deleteAll"]');
                                            if (clearAllBtn) clearAllBtn.closest('li').remove();
                                        }
                                    }
                                }
                            });
                    }

                    function deleteAllNotifications() {
                        fetch('/alumno/notifications/delete-all', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    document.querySelector('.message-center.notifications').innerHTML = '<div class="p-3 text-center">No tienes notificaciones nuevas.</div>';
                                    let badge = document.querySelector('.notify-no');
                                    if(badge) badge.remove();
                                    
                                    // Remove the delete all button itself
                                    let clearAllBtn = document.querySelector('.text-danger[onclick^="deleteAll"]');
                                    if (clearAllBtn) clearAllBtn.closest('li').remove();
                                }
                            });
                    }
                </script>
                <!-- ============================================================== -->
                <!-- create new -->
                <!-- ============================================================== -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="settings" class="svg-icon"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <div class="customize-input">
                            <select
                                class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                <option selected>EN</option>
                                <option value="1">AB</option>
                                <option value="2">AK</option>
                                <option value="3">BE</option>
                            </select>
                        </div>
                    </a>
                </li> --}}
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item d-none d-md-block" id="statusIconWrapper">
                    {{-- Icono de un triangulo color amarillo parpadeante con un signo de admiracion dentro  --}}
                    @if (Auth::user()->rol[0]->slug == 'alumno')
                        @if (Auth::user()->documento_identificacion != null &&
                                Auth::user()->pase_ingreso != null &&
                                Auth::user()->validado != 'no')
                            <a class="nav-link" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom"
                                title="Tu cuenta está completa">
                                <i data-feather="check-circle" class="svg-icon" style="color: #28a745;"></i>
                            </a>
                        @else
                            <a class="nav-link" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom"
                                title="Documentos en revision o incompletos">
                                <i data-feather="alert-triangle" class="svg-icon"
                                    style="color: #f06340; animation: blinker 1.5s linear infinite;"></i>
                            </a>
                        @endif
                    @endif
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown" id="userDropdownWrapper">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" id="userDropdownTrigger">
                        @if (Auth::user()->foto !== null && Auth::user()->foto !== '')
                            <img src="{{ route(Auth::user()->rol[0]->slug . '.image', ['file' => Auth::user()->foto]) }}"
                                alt="user" class="rounded-circle" width="40" height="40">
                        @else
                            <img src="{{ asset('vendor/adminmart/assets/images/big/icon.png') }}" alt="user"
                                class="img-fluid rounded-circle">
                        @endif
                        <span class="ml-2 d-none d-lg-inline-block"><span>Bienvenido,</span> <span
                                class="text-dark">{{ Auth::user()->nombre_completo }}</span> <i
                                data-feather="chevron-down" class="svg-icon"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">

                        <form method="POST" id="profile-form"
                            action="{{ route(Auth::user()->rol[0]->slug . '.profile') }}">
                            @csrf
                            <input name="id" type="hidden" value="{{ Auth::user()->id }}">
                            <a class="dropdown-item" href="{{ route(Auth::user()->rol[0]->slug . '.profile') }}"
                                id="userProfileBtn"
                                onclick="event.preventDefault();
                            document.getElementById('profile-form').submit();">
                                <i data-feather="user" class="svg-icon mr-2 ml-1"></i>
                                {{ __('My Profile') }}
                            </a>
                        </form>

                        <a class="dropdown-item"
                            href="{{ route(Auth::user()->rol[0]->slug . '.complete', ['role' => Auth::user()->id]) }}"
                            id="userCompleteDataBtn">
                            <i data-feather="clipboard" class="svg-icon mr-2 ml-1"></i>
                            Completar datos
                        </a>

                        {{-- <a class="dropdown-item" href="{{ route('users.profile
                        ') }}"><i data-feather="user"
                                class="svg-icon mr-2 ml-1"></i>
                                {{ __('My Profile') }} </a> --}}
                        {{-- <a class="dropdown-item" href="javascript:void(0)"><i data-feather="credit-card"
                                class="svg-icon mr-2 ml-1"></i>
                            My Balance</a>
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="mail"
                                class="svg-icon mr-2 ml-1"></i>
                            Inbox</a> --}}
                        {{-- <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings"
                                class="svg-icon mr-2 ml-1"></i>
                            {{ __('Account Setting') }}</a> --}}
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            id="userLogoutBtn">
                            <i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        {{-- <div class="dropdown-divider"></div>
                        <div class="pl-4 p-3"><a href="javascript:void(0)" class="btn btn-sm btn-info">
                            {{ __('View Profile') }}</a></div> --}}
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
