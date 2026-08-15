@extends('layouts.adminmart.detalle')

@section('content')

<table class="table table-borderless table-striped">
    <tbody>
        <tr>
            <th scope="row">Nombre:</th>
            <td>{{ $user->nombre_completo }}<td>
        </tr>
        <tr>
            <th scope="row">Usuario:</th>
            <td>{{ $user->username }}<td>
        </tr>
        <tr>
            <th scope="row">Correo Electrónico:</th>
            <td>{{ $user->email }}<td>
        </tr>
        <tr>
            <th scope="row">Rol:</th>
            <td>{{ $user->roles[0]->name }}<td>
        </tr>
        <tr>
            <th scope="row">Dirección MAC:</th>
            <td>
                @if($user->mac_address)
                    <code class="bg-light px-2 py-1 border rounded text-dark font-weight-bold">{{ $user->mac_address }}</code>
                    <form action="{{ route('users.clearMac', $user->id) }}" method="POST" class="d-inline ml-2" onsubmit="return confirm('¿Estás seguro de que deseas desvincular todos los dispositivos de este alumno?');">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-danger font-weight-bold" style="padding: 2px 8px; font-size: 11px;">Desvincular Todos</button>
                    </form>
                @else
                    <span class="text-muted italic">Ningún dispositivo vinculado aún (se registrará al primer inicio de sesión).</span>
                @endif
            </td>
        </tr>
        @if($user->pending_mac_address)
        <tr class="table-warning">
            <th scope="row">Solicitud de Nuevo Dispositivo:</th>
            <td>
                <code class="bg-warning px-2 py-1 border rounded text-dark font-weight-bold">{{ $user->pending_mac_address }}</code>
                <form action="{{ route('users.approveMac', $user->id) }}" method="POST" class="d-inline ml-2">
                    @csrf
                    <button type="submit" class="btn btn-xs btn-success font-weight-bold" style="padding: 2px 8px; font-size: 11px;">Aprobar Dispositivo</button>
                </form>
                <form action="{{ route('users.rejectMac', $user->id) }}" method="POST" class="d-inline ml-1">
                    @csrf
                    <button type="submit" class="btn btn-xs btn-secondary font-weight-bold" style="padding: 2px 8px; font-size: 11px;">Rechazar</button>
                </form>
            </td>
        </tr>
        @endif
    </tbody>
</table>

<h4 class="mt-4">Cursos Inscritos</h4>
<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Curso</th>
                <th>Identificador</th>
                <th>Estado</th>
                <th>Fecha Inscripción</th>
                <th class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscripciones as $inscripcion)
                @if($inscripcion->CursoProgramado && $inscripcion->CursoProgramado->Curso)
                    <tr>
                        <td><strong>{{ $inscripcion->CursoProgramado->Curso->titulo }}</strong></td>
                        <td><span class="badge badge-primary">{{ $inscripcion->CursoProgramado->identificador }}</span></td>
                        <td>
                            @if($inscripcion->aceptado == 'si')
                                <span class="badge badge-success">Aceptado</span>
                            @else
                                <span class="badge badge-warning">Pendiente / Inactivo</span>
                            @endif
                        </td>
                        <td>{{ $inscripcion->created_at ? \Carbon\Carbon::parse($inscripcion->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ route('admin.cursos.lista-inscritos') }}" class="d-inline" target="_top">
                                @csrf
                                <input name="curso_programado_id" type="hidden" value="{{ $inscripcion->CursoProgramado->id }}">
                                <button type="submit" class="btn btn-xs btn-dark font-weight-bold" style="padding: 3px 8px; font-size: 11px;" title="Ver detalle del curso / matrícula">
                                    <i class="fas fa-external-link-alt"></i> Ver Matrícula del Curso
                                </button>
                            </form>
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">El alumno no se encuentra inscrito en ningún curso actualmente.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<h4 class="mt-4">Historial de Advertencias / Bloqueos</h4>
<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Fecha/Hora</th>
                <th>Acción</th>
                <th>Detalles/Puntos</th>
            </tr>
        </thead>
        <tbody>
            @php
                $history = \App\Models\UserStrikeHistory::where('user_id', $user->id)->latest()->get();
            @endphp
            @forelse($history as $record)
                <tr>
                    <td>{{ $record->created_at }}</td>
                    <td><span class="badge badge-danger">{{ $record->action }}</span></td>
                    <td>{{ $record->details }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay registros de advertencias.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
