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
