@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Reportes</h3>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-5 align-self-center">
                <div class="customize-input float-right">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="container py-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Detalles del Cargo (OpenPay)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>ID Transacción:</strong>
                                    <div class="text-muted">{{ $charge->id ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Monto:</strong>
                                    <div class="text-success">${{ number_format($charge->amount, 2) }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Estado:</strong>
                                    <span
                                        class="badge {{ $charge->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($charge->status) }}
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Método de pago:</strong>
                                    <div class="text-muted">{{ $charge->method ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Fecha de creación:</strong>
                                    <div class="text-muted">
                                        {{ \Carbon\Carbon::parse($charge->creation_date)->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Descripción:</strong>
                                    <div class="text-muted">{{ $charge->description ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Cliente:</strong>
                                    <div class="text-muted">{{ $charge->customer->name ?? '-' }}
                                        {{ $charge->customer->last_name ?? '' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Email del cliente:</strong>
                                    <div class="text-muted">{{ $charge->customer->email ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>ID de autorización:</strong>
                                    <div class="text-muted">{{ $charge->authorization ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Referencia:</strong>
                                    <div class="text-muted">{{ $charge->order_id ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Telefono:</strong>
                                    <div class="text-muted">{{ $charge->customer->phone_number ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Tarjeta:</strong>
                                    <div class="text-muted">{{ $charge->card->card_number ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
