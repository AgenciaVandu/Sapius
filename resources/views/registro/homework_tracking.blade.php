@extends('layouts.adminmart.default')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Mis Tareas</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('alumno.home') }}">Mis Cursos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Seguimiento de Tareas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Estado de mis Tareas</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Lección</th>
                                <th>Estado</th>
                                <th>Fecha Límite</th>
                                <th>Fecha de Entrega</th>
                            </tr>
                        </thead>
                        @foreach ($modulos as $modulo)
                            <tbody style="border-top: 2px solid #dee2e6;">
                                <tr data-toggle="collapse" data-target="#module-{{ $modulo->id }}" aria-expanded="false" aria-controls="module-{{ $modulo->id }}" style="cursor: pointer; background-color: #f4f6f9;">
                                    <td colspan="4">
                                        <h5 class="mb-0 font-weight-bold text-dark">
                                            <i class="fas fa-folder text-primary mr-2"></i>{{ $modulo->titulo }}
                                        </h5>
                                    </td>
                                    <td class="text-right align-middle">
                                        <span class="badge badge-pill badge-secondary mr-2">{{ $modulo->Clases->count() }} lecciones</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="module-{{ $modulo->id }}" class="collapse">
                                @foreach ($modulo->Clases as $clase)
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $moduleScheduleItem = $schedule->firstWhere('id', $modulo->id);
                                        $scheduleItem = $schedule->firstWhere('id', $clase->id) ?? $moduleScheduleItem;

                                        $fechaFinalCarbon = null;
                                        $estadoStr = '<span class="badge badge-warning" style="background-color:#ffcc00; color:black;">Pendiente</span>';
                                        $fechaLimiteStr = '-';

                                        if ($scheduleItem && isset($scheduleItem['fecha_final'])) {
                                            try {
                                                $endFormat = 'd/m/Y';
                                                $endStr = $scheduleItem['fecha_final'];
                                                if (isset($scheduleItem['hora_final'])) {
                                                    $endFormat .= ' H:i';
                                                    $endStr .= ' ' . $scheduleItem['hora_final'];
                                                }
                                                $fechaFinalCarbon = \Carbon\Carbon::createFromFormat($endFormat, $endStr);
                                                if (!isset($scheduleItem['hora_final'])) {
                                                    $fechaFinalCarbon->setTime(23, 59, 59);
                                                }
                                                $fechaLimiteStr = $fechaFinalCarbon->format('d/m/Y H:i');

                                                if (!$homeworks->has($clase->id)) {
                                                    if ($now->gt($fechaFinalCarbon)) {
                                                        $estadoStr = '<span class="badge badge-danger">Cerrada</span>';
                                                    } else {
                                                        if (isset($scheduleItem['fecha_inicial'])) {
                                                            $startFormat = 'd/m/Y';
                                                            $startStr = explode(' ', $scheduleItem['fecha_inicial'])[0];
                                                            $fechaInicialCarbon = \Carbon\Carbon::createFromFormat($startFormat, $startStr);
                                                            $reminderStartDate = $fechaInicialCarbon->copy()->addDays(2);
                                                            
                                                            if ($now->gte($reminderStartDate)) {
                                                                $estadoStr = '<span class="badge text-white" style="background-color: #e6a23c;">Atrasada</span>';
                                                            }
                                                        }
                                                    }
                                                }
                                            } catch (\Exception $e) {}
                                        }

                                        if ($homeworks->has($clase->id)) {
                                            $estadoStr = '<span class="badge badge-success">Entregado</span>';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center align-middle" style="width: 50px;">
                                            <i class="fas fa-level-up-alt fa-rotate-90 text-muted"></i>
                                        </td>
                                        <td class="pl-3 align-middle">{{ $clase->titulo }}</td>
                                        <td class="align-middle">
                                            {!! $estadoStr !!}
                                        </td>
                                        <td class="align-middle">{{ $fechaLimiteStr }}</td>
                                        <td class="align-middle">
                                            @if ($homeworks->has($clase->id))
                                                {{ $homeworks[$clase->id]->created_at->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
