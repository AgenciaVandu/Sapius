@extends('layouts.adminmart.default')

@section('content')
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-8 text-center">
            <div class="card shadow-lg p-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i data-feather="lock" class="text-danger" style="width: 80px; height: 80px;"></i>
                    </div>
                    <h2 class="card-title text-danger font-weight-bold">Cuenta Bloqueada</h2>
                    <h5 class="text-dark mb-4">
                        Hemos detectado actividad sospechosa en tu cuenta (intentos reiterados de uso indebido).
                    </h5>
                    <p class="card-text lead mt-3 text-muted">
                        Por motivos de seguridad y cumpliendo con nuestros términos de servicio, tu acceso ha sido
                        suspendido temporalmente.
                        <br>
                        {{-- <strong>El examen en curso ha sido finalizado automáticamente.</strong> --}}
                    </p>

                    <div class="alert alert-warning text-left">
                        <h6 class="font-weight-bold"><i class="fas fa-camera"></i> Instrucción Importante:</h6>
                        <p class="mb-0">
                            Para poder desbloquear tu cuenta, <strong>debes tomar una foto de esta pantalla</strong> donde
                            se vean las acciones registradas abajo y enviarla a soporte técnico.
                        </p>
                    </div>

                    @php
                        $history = \App\Models\UserStrikeHistory::where('user_id', Auth::id())
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if ($history->count() > 0)
                        <div class="table-responsive mt-3 mb-3">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Hora</th>
                                        <th scope="col">Acción Detectada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $record)
                                        @php
                                            $actionDisplay = $record->action;
                                            $visual = '';

                                            // Determine Visual for Action
                                            if (Str::contains($record->action, 'Right Click')) {
                                                $visual =
                                                    '<div class="mouse-icon"><div class="mouse-btn left"></div><div class="mouse-btn right active"></div></div> <span class="align-middle">Clic Derecho</span>';
                                            } elseif (Str::contains($record->action, 'PrintScreen')) {
                                                $visual = '<span class="kbd-key">PrtScn</span>';
                                            } elseif ($record->action == 'F12' || $record->action == 'DevTools') {
                                                $visual = '<span class="kbd-key">F12</span>';
                                            } elseif (Str::contains($record->action, 'Copy')) {
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">C</span>';
                                            } elseif (Str::contains($record->action, 'Paste')) {
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">V</span>';
                                            } elseif (Str::contains($record->action, 'Cut')) {
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">X</span>';
                                            } elseif (Str::contains($record->action, 'Shortcut')) {
                                                // Extract key from "Shortcut x"
                                                $key = strtoupper(str_replace('Shortcut ', '', $record->action));
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">' .
                                                    $key .
                                                    '</span>';
                                            } elseif (Str::contains($record->action, 'Mac Screenshot')) {
                                                $visual =
                                                    '<span class="kbd-key">Cmd</span> + <span class="kbd-key">Shift</span> + <span class="kbd-key">3/4</span>';
                                            } else {
                                                $visual = $record->action;
                                            }
                                        @endphp
                                        <tr>
                                            <td class="align-middle">{{ $record->created_at->format('H:i:s') }}</td>
                                            <td class="text-danger font-weight-bold align-middle">{!! $visual !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <p class="text-muted mt-3">
                        Para recuperar el acceso, por favor contacta a soporte técnico enviando la evidencia solicitada.
                    </p>
                    <div class="mt-4">
                        <a href="https://wa.me/529993648594?text=Hola,%20mi%20cuenta%20ha%20sido%20bloqueada"
                            target="_blank" class="btn btn-success btn-lg rounded-pill px-5">
                            <i class="fab fa-whatsapp mr-2"></i> Contactar Soporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .kbd-key {
            display: inline-block;
            padding: 4px 8px;
            font-size: 0.85rem;
            font-weight: 700;
            line-height: 1;
            color: #444;
            vertical-align: middle;
            border-radius: 4px;
            background-color: #f8f9fa;
            border: 1px solid #c6c8ca;
            border-bottom: 3px solid #b1b4b8;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
            margin: 0 2px;
            font-family: 'Consolas', 'Monaco', monospace;
        }

        /* Mouse Icon CSS */
        .mouse-icon {
            width: 24px;
            height: 36px;
            border: 2px solid #555;
            border-radius: 12px;
            position: relative;
            display: inline-block;
            vertical-align: middle;
            background: white;
            margin-right: 5px;
        }

        .mouse-btn {
            position: absolute;
            top: 2px;
            width: 8px;
            height: 12px;
            border: 1px solid #555;
            background: white;
        }

        .mouse-btn.left {
            left: 2px;
            border-top-left-radius: 6px;
        }

        .mouse-btn.right {
            right: 2px;
            border-top-right-radius: 6px;
        }

        .mouse-btn.active {
            background-color: #ff4d4d;
            /* Red for the pressed button */
        }
    </style>

    <script>
        // Prevent back navigation loop
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };

        // Poll to check if unblocked
        setInterval(() => {
            fetch(window.location.href, {
                    method: 'HEAD'
                })
                .then(response => {
                    if (response.redirected && response.url.includes('alumno')) {
                        window.location.href = "{{ route('alumno.home') }}";
                    }
                })
                .catch(() => {});
        }, 5000);
    </script>
@endsection
