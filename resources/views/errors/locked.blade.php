@extends('layouts.adminmart.default')

@section('content')
    @php
        $recentHistory = \App\Models\UserStrikeHistory::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        $totalSeverity = 0;
        $itemsCount = 0;

        foreach ($recentHistory as $h) {
            $act = $h->action;
            $pts = 10; // BASE

            // High Intent
            if (
                in_array($act, [
                    'Copy',
                    'Cut',
                    'Paste',
                    'PrintScreen',
                    'Save',
                    'View Source',
                    'DevTools',
                    'F12',
                ])
            ) {
                $pts = 100;
            }
            // Medium
            elseif ($act === 'Right Click') {
                $pts = 50;
            }
            // Low / Accidental
            elseif (in_array($act, ['Shift', 'Restricted Key / Modifier'])) {
                $pts = 10;
            }
            // Very Low
            elseif (strpos($act, 'Volume') !== false) {
                $pts = 0;
            }

            $totalSeverity += $pts;
            $itemsCount++;
        }

        $avgSeverity = $itemsCount > 0 ? $totalSeverity / $itemsCount : 0;

        $isGraveBlock = $recentHistory->contains(function ($h) {
            return strpos($h->details, 'retro') !== false && strpos($h->details, 'grabe') !== false;
        });

        $semaphoreColor = '#28a745'; // Green
        $semaphoreText = 'Baja Intencionalidad (Posibles Errores)';
        $semaphoreIcon = 'fa-check-circle';

        if ($isGraveBlock) {
            $avgSeverity = 100;
            $semaphoreColor = '#4b0000'; // Dark Blood Red
            $semaphoreText = 'VIOLACIÓN CRÍTICA DE SEGURIDAD (MODO RETROALIMENTACIÓN)';
            $semaphoreIcon = 'fa-skull-crossbones';
        } elseif ($avgSeverity >= 70) {
            $semaphoreColor = '#dc3545'; // Red
            $semaphoreText = 'Alta Intencionalidad (Acciones Prohibidas Detectadas)';
            $semaphoreIcon = 'fa-exclamation-circle';
        } elseif ($avgSeverity >= 30) {
            $semaphoreColor = '#ffc107'; // Yellow
            $semaphoreText = 'Intencionalidad Media (Precaución)';
            $semaphoreIcon = 'fa-exclamation-triangle';
        }
    @endphp

    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8 text-center">
            <div class="card shadow-lg p-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i data-feather="lock" class="text-danger" style="width: 80px; height: 80px;"></i>
                    </div>
                    <h2 class="card-title font-weight-bold" style="color: {{ $isGraveBlock ? '#4b0000' : '#dc3545' }};">
                        {{ $isGraveBlock ? 'BLOQUEO POR VIOLACIÓN DE SEGURIDAD' : 'Cuenta Bloqueada' }}
                    </h2>
                    <h5 class="text-dark mb-4">
                        @if ($isGraveBlock)
                            Se ha detectado una violación crítica de los términos de servicio y derechos de autor durante la
                            retroalimentación de tu evaluación.
                        @else
                            Hemos detectado actividad sospechosa en tu cuenta (intentos reiterados de uso indebido).
                        @endif
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


                    <div class="card mb-4" style="border: 2px solid {{ $semaphoreColor }};">
                        <div class="card-body py-3">
                            <h5 class="mb-0" style="color: {{ $semaphoreColor }}; font-weight: bold;">
                                <i class="fas {{ $semaphoreIcon }}"></i> Nivel de Intencionalidad Detectado
                            </h5>
                            <p class="text-muted mb-0 mt-1">
                                El sistema ha analizado tus acciones recientes:
                                <span class="badge"
                                    style="background-color: {{ $semaphoreColor }}; color: white; font-size: 1rem;">
                                    {{ $semaphoreText }}
                                </span>
                            </p>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ min($avgSeverity, 100) }}%; background-color: {{ $semaphoreColor }};"
                                    aria-valuenow="{{ $avgSeverity }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
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
                                        <th scope="col">Observaciones</th>
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
                                                $visual =
                                                    '<span class="kbd-key">PrtScn</span> <span class="align-middle pl-2">Captura de Pantalla</span>';
                                            } elseif ($record->action == 'F12' || $record->action == 'DevTools') {
                                                $visual =
                                                    '<span class="kbd-key">F12</span> <span class="align-middle pl-2">Herramientas de Desarrollo</span>';
                                            } elseif (Str::contains($record->action, 'Copy')) {
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">C</span> <span class="align-middle pl-2">Copiar Contenido</span>';
                                            } elseif (Str::contains($record->action, 'Paste')) {
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">V</span> <span class="align-middle pl-2">Pegar Contenido</span>';
                                            } elseif (Str::contains($record->action, 'Cut')) {
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">X</span> <span class="align-middle pl-2">Cortar Contenido</span>';
                                            } elseif (Str::contains($record->action, 'Shortcut')) {
                                                // Extract key from "Shortcut x"
                                                $key = strtoupper(str_replace('Shortcut ', '', $record->action));
                                                $visual =
                                                    '<span class="kbd-key">Ctrl</span> + <span class="kbd-key">' .
                                                    $key .
                                                    '</span> <span class="align-middle pl-2">Atajo de Teclado</span>';
                                            } elseif (Str::contains($record->action, 'Mac Screenshot')) {
                                                $visual =
                                                    '<span class="kbd-key">Cmd</span> + <span class="kbd-key">Shift</span> + <span class="kbd-key">3/4</span> <span class="align-middle pl-2">Captura en Mac</span>';
                                            } elseif (Str::contains($record->action, 'Snipping Tool')) {
                                                $visual =
                                                    '<span class="kbd-key">Win</span> + <span class="kbd-key">Shift</span> + <span class="kbd-key">S</span> <span class="align-middle pl-2">Recortes (Snipping Tool)</span>';
                                            } elseif (Str::contains($record->action, 'Restricted Key')) {
                                                // Try to guess key from details if available or just generic
                                                $visual =
                                                    '<span class="kbd-key"><i class="fas fa-ban"></i></span> <span class="align-middle pl-2">Tecla Restringida / Shift</span>';
                                            } elseif (Str::contains($record->action, 'Volume')) {
                                                $visual =
                                                    '<i class="fas fa-volume-up fa-lg text-muted"></i> <span class="align-middle pl-2">Ajuste de Volumen</span>';
                                            } else {
                                                // Generic Keyboard visual
                                                $visual = '<span class="kbd-key">' . $record->action . '</span>';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="align-middle">{{ $record->created_at->format('H:i:s') }}</td>
                                            <td class="text-danger font-weight-bold align-middle">{!! $visual !!}
                                            </td>
                                            <td class="align-middle text-muted">{{ $record->details }}</td>
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
