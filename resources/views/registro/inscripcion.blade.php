@extends('layouts.adminmart.default')

@section('breadcrumb')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
                    Pasarela de pagos</h2>
                {{-- <h3 class="page-title text-truncate text-dark font-weight-medium mb-1"></h3> --}}
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        $precio = $curso->precio;
        $descuento = session('descuento');
        $cupon = session('cupon');
        if ($descuento) {
            $precio = $curso->precio - ($descuento / 100) * $curso->precio;
        }
    @endphp

    <input type="hidden" id="curso" value="{{ $curso->Curso->titulo }}">
    <div class="card shadow-lg border-0 rounded-4 my-4">
        <div class="row justify-content-center px-5 py-4">
            <div class="col-md-5 px-4 d-flex flex-column align-items-center">
                <img src="{{ route(Auth::user()->rol[0]->slug . '.cursos.image', ['file' => $curso->Curso->imagen]) }}"
                    id="img" alt="Imagen del curso" class="img-thumbnail mb-3" style="max-width: 320px;">
                <h2 class="fw-bold text-primary text-center mb-2">
                    {{ $curso->Curso->titulo }}
                </h2>
                <small class="text-muted text-center mb-3">
                    {!! $curso->Curso->descripcion !!}
                </small>
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h2 class="mb-4">
                        @if ($descuento)
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">Precio original:</span>
                                    <span class="text-end">
                                        <strike>${{ number_format($curso->precio, 2) }} MXN</strike>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">
                                        Descuento aplicado
                                    </span>
                                    <span class="text-end text-success">
                                        <span class="">({{ $descuento }}%)</span>
                                        - ${{ number_format($curso->precio - $precio, 2) }} MXN
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center fw-bold">
                                    <span class="text-dark">Total a pagar:</span>
                                    <span class="text-end">
                                        <strong class="fs-4 text-primary">${{ number_format($precio, 2) }} MXN</strong>
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center fw-bold">
                                    <span class="text-dark">Total a pagar:</span>
                                    <span class="text-end">
                                        <strong class="fs-4 text-primary">${{ number_format($curso->precio, 2) }}
                                            MXN</strong>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </h2>
                    @if ($descuento)
                        <div class="alert alert-success d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <strong>¡Descuento aplicado!</strong>
                                <br>
                                <span>Cupón usado: <span class="badge bg-info text-dark">{{ $cupon }}</span></span>
                                <br>
                                <small>El precio mostrado ya incluye tu descuento.</small>
                            </div>
                            <form action="{{ route('descuentos.cancel') }}" method="POST" class="ms-3">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Quitar descuento">
                                    <i class="fas fa-times"></i> Cancelar cupón
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('descuentos.check') }}" method="POST" class="px-2 py-2 mb-4">
                            @csrf
                            @if (session('error'))
                                <div class="alert alert-danger mb-2">No se encontró la clave o ya expiró.</div>
                            @endif
                            @if (session('limit'))
                                <div class="alert alert-warning mb-2">Descuento agotado.</div>
                            @endif
                            <div class="input-group">
                                <input type="text" class="form-control" name="clave" placeholder="Código de descuento">
                                <input type="hidden" name="curso_programado_id" value="{{ $curso->id }}">
                                <button type="submit" class="btn btn-primary">Agregar descuento</button>
                            </div>
                        </form>
                    @endif
                    <div class="mt-4">
                        @if ($descuento == 100)
                            <a href="{{ route('inscripcion.pago', $curso) }}"
                                class="btn btn-primary btn-lg w-100 shadow-sm d-flex align-items-center justify-content-center gap-2 py-3 fs-5">
                                <span>Redimir Cúpon</span>
                            </a>
                        @else
                            <a href="{{ route('alumno.checkout', $curso) }}"
                                class="btn btn-primary btn-lg w-100 shadow-sm d-flex align-items-center justify-content-center gap-2 py-3 fs-5">
                                <i class="fas fa-credit-card"></i>
                                <span>Ir al pago</span>
                            </a>
                        @endif
                    </div>

                    <div class="mb-4"
                        style="background-color: #eef2ff; padding: 1.5rem; border-left: 5px solid #3b82f6; margin-top: 1.5rem; border-radius: 0.5rem; ">
                        <p style="margin: 0; font-weight: bold; color: #1e3a8a;">
                            Aviso importante sobre pagos:
                        </p>
                        <p style="margin: 0; color: #1e40af;">
                            Todos los pagos realizados en esta plataforma se procesan de forma segura a través de la
                            pasarela de
                            pagos de <strong>Openpay</strong>. Al realizar una compra, el usuario acepta los términos y
                            condiciones
                            de Openpay y autoriza el uso de dicha pasarela para procesar su transacción.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            /*  $(".modal-title").html("Inscripción al curso " + $('#curso').val());
             $("#pago").click(function() { */
            //$("#form-pago").submit();
            //event.preventDefault();
            /* var $form = $('#form-pago'); */
            //$form = $(this);

            /* Previene hacer submit más de una vez */
            /* $("#pago").prop("disabled", true);
            Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler); */
            /* Previene que la información de la forma sea enviada al servidor */
            /*     return false;
            }); */
            //Codigo para el tipo de transaccion
            /* $("#tarjeta").click(function() {
                $("#tipo_cobro").val("tarjeta");
            }); */
            /* $("#oxxo").click(function() {
                $("#tipo_cobro").val("oxxo");
            }); */
            //Codigo para el descuento
            $("#descuento").click(function() {
                var precio = $("#precioh").val();
                var clave = $("#clave").val();
                var curso_programado_id = $("#curso_programado_id").val();
                var token = "{{ csrf_token() }}";
                $.post("{{ route('descuentos.check') }}", {
                    _token: token,
                    clave: clave,
                    curso_programado_id: curso_programado_id
                }, function() {}).done(function(data) {
                    descuento = JSON.parse(data);
                    if (descuento.descuento > 0) {
                        $("#descuento").hide();
                        $("#clave").hide();
                        $("#precio").val('$ ' + (precio - ((descuento.descuento / 100) * precio)) +
                            ' MxN');
                        $("#precioh").val((precio - ((descuento.descuento / 100) * precio)));
                        $("#text_descuento").html(', descuento aplicado <strike>$ ' + precio +
                            ' MxN</strike>');
                        $("#divAlerts").html(
                            '<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>¡Correcto!</strong> Descuento aplicado </div>'
                        );
                        console.log('pase por aqui');
                    } else {
                        $("#divAlerts").html(
                            '<div class="alert alert-warning alert-dismissible bg-warning text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>Advertencia !</strong> ' +
                            descuento.mensaje + ' </div>');
                    }
                }).fail(function() {
                    $("#rowValidar").show();
                    $("#rowValidarOk").hide();
                    $("#divAlerts").html(
                        '<div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button> <strong>Error !</strong> No se aplicaron los cambios </div>'
                    );
                });
            });
        });
    </script>
@endsection
