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
